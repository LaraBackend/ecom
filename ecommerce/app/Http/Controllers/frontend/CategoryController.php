<?php

namespace App\Http\Controllers\frontend;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CategoryController extends Controller
{
    public function index()
    {

       $category_all = DB::table('categories')
            ->join('categories_description', 'categories_description.categories_description_id', '=', 'categories.categories_id')
            ->select('categories.*', 'categories_description.*')
            ->where('language_id', 1)
            ->get();
        return view('frontend.category.categories', compact('category_all'));
    }

    public function show($id)
    {
         $product_category = DB::table('products_to_categories')
                    ->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
             ->leftJoin('products_description','products_description.products_id','=','products_to_categories.products_id')
           //  ->join('categories_description','categories_description.categories_id','products_to_categories.products_id')
            ->where('categories_id','=',$id)
             ->where('products_description.language_id',1)
             ->get();

               // dd($product_category);

        return view('frontend.category.productcategory', compact('product_category'));
    }

}