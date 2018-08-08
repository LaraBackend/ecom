<?php
/*
Project Name: IonicEcommerce
Project URI: http://ionicecommerce.com
Author: VectorCoder Team
Author URI: http://vectorcoder.com/
Version: 2.9.2
*/
namespace App\Http\Controllers\Admin;

//validator is builtin class in laravel
use Validator;

use DB;
//for password encryption or hash protected
use Hash;
use App\Administrator;
use App\ProductsPaymentCommssion;

//for authenitcate login data
use Auth;

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminAffiliateController extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	//get all countries
	public function network(){

        $pageTitle = 'Network';
        return view("admin.affiliate.network" , compact('pageTitle'));

	}

	public function commissions(){

        $pageTitle = 'Commissions';
        $commissions = ProductsPaymentCommssion::with('user' , 'from_user')->paginate(30);
        return view("admin.affiliate.commissions" , compact('pageTitle','commissions'));

	}


	public function registration_points(){

        echo 'registration_points';
	}

	

}