<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ProductController extends Controller
{
    public function show()
    {
        return view('frontend.product.singelproduct');
    }
    public function showSingel($id)
    {
        $product = DB::table('products')->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('products_attributes', 'products_attributes.products_id', '=', 'products.products_id')
            ->join('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.products_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products.products_id')
            ->select('products.*', 'products_description.*', 'products_attributes.*', 'manufacturers.manufacturers_name','products_options_values.*')
            ->where('products.products_id',$id)
            ->first();

        $product_images = DB::table('products_images')->where('products_id',$id)->get();

//dd($product);

       // dd($product_images);
        return view('frontend.product.singelproduct',compact('product','product_images'));

    }
}
