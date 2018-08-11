<?php

namespace App\Providers;
use DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // Using Closure based composers...
		$result = array();
        $orders = DB::table('orders')
				->leftJoin('customers','customers.customers_id','=','orders.customers_id')
				->where('orders.is_seen','=', 0)
				->orderBy('orders_id','desc')
				->get();
				
		$index = 0;	
		foreach($orders as $orders_data){
			
			array_push($result,$orders_data);			
			$orders_products = DB::table('orders_products')
				//->select('final_price', DB::raw('SUM(final_price) as total_price'))
				->where('orders_id', '=' ,$orders_data->orders_id)
				->get();
			
			$result[$index]->price = $orders_products;
			$result[$index]->total_products = count($orders_products);
			$index++;
		}
		
		//new customers
		$newCustomers = DB::table('customers')
				->where('is_seen','=', 0)
				->orderBy('customers_id','desc')
				->get();
				
		//products low in quantity
		$lowInQunatity = DB::table('products')
			->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
			->whereColumn('products.products_quantity', '<=', 'products.low_limit')
			->where('products_description.language_id', '=', '1')
			->where('products.low_limit', '>', 0)
			//->get();
			->paginate(10);
				
		 view()->share('unseenOrders', $result);
		 view()->share('newCustomers', $newCustomers);
		 view()->share('lowInQunatity', $lowInQunatity);

        //view all products
        \view()->composer('*', function ($view) {
            $view->with('products', DB::table('products_description')
                ->join('products', 'products.products_id', '=', 'products_description.products_id')
                ->join('products_attributes', 'products_attributes.products_attributes_id', '=', 'products_description.products_id')
                ->select('products_description.*','products.*','products_attributes.*')
                ->where('language_id', 1)
                ->take(6)
                ->get());
        });
        //view all products
        \view()->composer('*', function ($view) {
          $view->with('categories', DB::table('categories')
                ->join('categories_description', 'categories_description.categories_description_id', '=', 'categories.categories_id')
                ->select('categories.*','categories_description.*')
                ->where('parent_id',0)
                ->get());

        });
        //view all products
        \view()->composer('frontend.home', function ($view) {
          $view->with('manufacturers',  DB::table('manufacturers')
              ->join('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
              ->select('manufacturers.*','manufacturers_info.*')
              ->get());


        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
