<?php
/*
Project Name: IonicEcommerce
Project URI: http://ionicecommerce.com
Author: VectorCoder Team
Author URI: http://vectorcoder.com/
Version: 2.9.2
*/
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

//validator is builtin class in laravel
use Validator;
use App;
use Lang;
use File;
use DB;
//for password encryption or hash protected
use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminNotificationController extends Controller
{
	//listingDevices
	public function listingDevices(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ListingDevices"));		
			
		$result = array();
		$message = array();
		$errorMessage = array();
				
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();
		
		if(!empty($request->id)){
			if($request->active=='no'){
				$status = '0';
			}elseif($request->active=='yes'){
				$status = '1';
			}
			
			DB::table('devices')->where('id', '=', $request->id)->update([
				'status'		 =>	  $status
				]);	
		}
		
		if(isset($request->filter) and !empty($request->filter)){
			$devices = DB::table('devices')
				->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
				->where('device_type','=', $request->filter)
				->where('devices.is_notify','=', '1')
				->where('devices.'.$setting[0]->default_notification,'=', '1')				
				->orderBy('id','DESC')
				->paginate(100);
		}else{
			$devices = DB::table('devices')
				->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
				->orderBy('id','DESC')
				->where('devices.is_notify','=', '1')
				->where('devices.'.$setting[0]->default_notification,'=', '1')	
				->paginate(100);
		}
				
		$result['message'] = $message;
		$result['devices'] = $devices;
		
		return view("admin.listingDevices",$title)->with('result', $result);
	}
	
	//viewDevices
	public function viewDevices(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.ViewDevice"));
		$result = array();		
		$result['message'] = array();
		
		$devices = DB::table('devices')
			->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
			->where('devices.id', $request->id)
			->get();	
		
		$result['devices'] = $devices;	
		return view("admin.viewDevices",$title)->with('result', $result);
	}
	
		
	//notifyUser
	public function notifyUser(Request $request){
		$device_type 	= 	$request->device_type;
		$device_id 		= 	$request->device_id;
		$message 		= 	$request->message;
		$title 			= 	$request->title;
		$pageResponse   =   0;
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();		
		
		$dir = 'assets/images/notification_images/';		
		if(!File::exists(resource_path($dir))) {
			$dir = File::makeDirectory(resource_path($dir), 0775, true);// path does not exist
		}
		
		if($request->hasFile('image')){
			$image = $request->image;
			$fileName = time().'.'.$image->getClientOriginalName();			
			$image->move('resources/assets/images/notification_images/', $fileName);
			$uploadImage = 'resources/assets/images/notification_images/'.$fileName; 			
			$websiteURL =  "http://" . $_SERVER['SERVER_NAME'] .'/'. $uploadImage;			
		}else{
			$websiteURL = '';
		}	
		
		$sendData = array
				  (
					'body' 	=> $message,
					'title'	=> $title ,
							'icon'	=> 'myicon',/*Default Icon*/
							'sound' => 'mySound',/*Default sound*/
							'image' => $websiteURL,
				  );
				  
		if($setting[0]->default_notification=='fcm'){
			$functionName = 'fcmNotification';	
		}elseif($setting[0]->default_notification=='onesignal'){
			$functionName = 'onesignalNotification';
		}
		
		$response = $this->$functionName($device_id, $sendData, $pageResponse);				
		return $response;
	}
	
	
	//notifications
	public function notifications(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.SendNotifications"));
		$result = array();		
		$result['message'] = array();
		
		return view("admin.notifications", $title)->with('result', $result);
	}

	
	//sendNotification
	public function sendNotifications(Request $request){
		$device_type 		= 	$request->device_type;
		$devices_status 	= 	$request->devices_status;
		$message 			= 	$request->message;
		$title 				= 	$request->title;
		$pageResponse		=	1;
		$response			= 	array();
		$dir = 'assets/images/notification_images/';		
		if(!File::exists(resource_path($dir))) {
			$dir = File::makeDirectory(resource_path($dir), 0775, true);// path does not exist
		}
		
		if($request->hasFile('image')){
			$image = $request->image;
			$fileName = time().'.'.$image->getClientOriginalName();			
			$image->move('resources/assets/images/notification_images/', $fileName);
			$uploadImage = 'resources/assets/images/notification_images/'.$fileName; 			
			$websiteURL =  "http://" . $_SERVER['SERVER_NAME'] .'/'. $uploadImage;			
		}else{
			$websiteURL = '';
		}	
		
		$sendData = array
				  (
				'body' 	=> $message,
				'title'	=> $title ,
						'icon'	=> 'myicon',/*Default Icon*/
						'sound' => 'mySound',/*Default sound*/
						'image' => $websiteURL,
				  );	
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();
				
		if($device_type =='all'){ 	/* to all users notification */
			
			$devices = DB::table('devices')
						->where('status','=', $devices_status)
						->where('devices.'.$setting[0]->default_notification,'=', '1')	
						->where('devices.is_notify','=', '1')
						->get();
			if($setting[0]->default_notification=='fcm'){
				$functionName = 'fcmNotification';	
			}elseif($setting[0]->default_notification=='onesignal'){
				$functionName = 'onesignalNotification';
			}
			foreach($devices as $devices_data){					
				$response[] = $this->$functionName($devices_data->device_id, $sendData, $pageResponse);
			}
					
			
		}else if($device_type =='1'){    /* apple notification */			
			
			$devices = DB::table('devices')
							->select('devices.device_id')
							->where('status','=', $devices_status)
							->where('devices.is_notify','=', '1')
							->where('devices.'.$setting[0]->default_notification,'=', '1')	
							->where('device_type','=', $device_type)
							->get();
			if($setting[0]->default_notification=='fcm'){
				$functionName = 'fcmNotification';	
			}elseif($setting[0]->default_notification=='onesignal'){
				$functionName = 'onesignalNotification';
			}
			
			foreach($devices as $devices_data){				
				$response[] = $this->$functionName($devices_data->device_id, $sendData, $pageResponse);
			}
			
		}else if($device_type =='2'){ 	/* android notification */
		
			$devices = DB::table('devices')
							->select('devices.device_id')
							->where('status','=', $devices_status)
							->where('devices.is_notify','=', '1')
							->where('devices.'.$setting[0]->default_notification,'=', '1')	
							->where('device_type','=', $device_type)
							->get();
			
			if($setting[0]->default_notification=='fcm'){
				$functionName = 'fcmNotification';	
			}elseif($setting[0]->default_notification=='onesignal'){
				$functionName = 'onesignalNotification';
			}
				
			foreach($devices as $devices_data){
				$response[] = $this->$functionName($devices_data->device_id, $sendData, $pageResponse);
			}
			
						
		}
		
		if(in_array('1', $response)){
			$message = 'sent';
		}else{
			$message = 'error';	
		}
		
		if ($message == 'sent'){	
			return redirect()->back()->withErrors([Lang::get("labels.notificationSendMessage")]);
		}elseif ($message == 'error'){	
			return redirect()->back()->withErrors([Lang::get("labels.notificationSendMessageError")]);
		}
	}
	
	//customerNotification
	public function customerNotification(Request $request){
		
		$devices = DB::table('devices')
					->leftJoin('customers','customers.customers_id','=','devices.customers_id')
					->select('devices.*','customers.customers_firstname','customers.customers_lastname')
					->where('devices.customers_id','=', $request->customers_id)
					->where('devices.is_notify','=', '1')
					->orderBy('register_date','DESC')->take(1)->get();
		
		return view("admin/customerNotificationForm")->with('devices', $devices);
	}
	
	
	//deleteTaxRate
	public function deletedevice(Request $request){
		DB::table('devices')->where('device_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.DeviceDeletedMessage")]);
	}
	
	public function fcmNotification($device_id, $sendData, $pageResponse){
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();
		
		#API access key from Google API's Console
		if (!defined('API_ACCESS_KEY')){
			define('API_ACCESS_KEY', $setting[0]->fcm_android);
		}
				
		$fields = array
				(
					'to'		=> $device_id,
					  'data'	=> $sendData
				);


		$headers = array
				(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);
		#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch);
		$data = json_decode($result);
		if($result === false)
		die('Curl failed ' . curl_error());

		curl_close($ch);

		if(!empty($data->success) and $data->success >= 1){
			$response = '1';
		}else{
			$response = '0';	
		}	
		
		if($pageResponse==1){
			return $response;
		}else{
			print $response;
		}
		
	}
	
	public function onesignalNotification($device_id, $sendData, $pageResponse){
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();
		
		$content = array(
		   "en" => $sendData['body']
		   );
		
		$headings = array(
		   "en" => $sendData['title']
		   );
		
		$big_picture = array(
		   "id1" => $sendData['image']
		   );
		
		$fields = array(
		   'app_id' => $setting[0]->onesignal_app_id,
		   'include_player_ids' => array($device_id),		   
		   'contents' => $content,
		   'headings'=>$headings,
		   'big_picture'=>$sendData['image']
		);
	
		$fields = json_encode($fields);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
				   'Authorization: Basic ZTJhZTcwNzItODQ4Ni00Y2FiLWFjZjEtMGY4ODZhZGZlMGZl'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
		$result = curl_exec($ch);
		$data = json_decode($result);
		curl_close($ch);
		
		if(!empty($data->recipients) and $data->recipients >= 1){
			$response = '1';
		}else{
			$response = '0';	
		}	
		
		if($pageResponse==1){
			return $response;
		}else{
			print $response;
		}		
	}
	
}
