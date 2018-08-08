<?php

namespace App\Http\Controllers\frontend;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }

    public function allProduct()
    {
       // $lang = \App::getLocale();
        //  $products = Product::all();
        /* $products = DB::table('products')
             ->join('products_description', 'products_description.language_id', '=', 'products.products_id')
             ->join('products_attributes', 'products_attributes.products_attributes_id', '=', 'products.products_id')
             ->select('products.*','products_description.*','products_attributes.*')
            // ->where('language_id',1)
             ->get();*/

        $products = DB::table('products_description')
            ->join('products', 'products.products_id', '=', 'products_description.products_id')
            ->join('products_attributes', 'products_attributes.products_attributes_id', '=', 'products_description.products_id')
            ->select('products_description.*','products.*','products_attributes.*')
            ->where('language_id', 1)
            ->take(6)
            ->get();
       // dd($products);
        return view('frontend.home', compact('products'));
    }
    public function allCategories()
    {

        $categories = DB::table('categories')
            ->join('categories_description', 'categories_description.categories_description_id', '=', 'categories.categories_id')
           ->select('categories.*','categories_description.*')
            ->where('parent_id',0)
            ->get();

      // dd($categories);
        return view('frontend.home',compact('categories'));
    }
}
