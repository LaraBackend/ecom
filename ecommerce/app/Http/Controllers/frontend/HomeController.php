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




    public function allBrands()
    {

        $categories = DB::table('manufacturers')
            ->join('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->select('manufacturers.*','manufacturers_info.*')
            ->get();

        // dd($categories);
        return view('frontend.home',compact('categories'));
    }
}
