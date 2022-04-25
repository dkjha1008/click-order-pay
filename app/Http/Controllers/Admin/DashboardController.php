<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Payment;
use App\Models\User;
use App\Models\Products;
use App\Models\Settings;

class DashboardController extends Controller
{
    //-----
    public function index(){
		$title = array(
			'title' => 'Dashboard',
			'active' => 'dashboard'
		);
		
		$newOrder = Payment::where('order_status', '1')->count();
		
		//$cancleOrder = Payment::where('order_status', '3')->count();
		
		
		
		$sales = Payment::where('payment_status', 'captured')
		->where('is_progress', '0')
		->where('is_admin_cancle', '0')
		->where('is_refund', '0')
		->where('order_status', '!=', '3')
		->sum('amount');

		$totalOrders = Payment::where('order_status', '2')->count();
		
		//$latestUser = User::where('role', 'user')->whereDate('created_at', '>=', date('Y-m-d', strtotime('-1 week')))->count();
		$latestUser = User::where('role', 'user')->count();
		
		//.............................................................
		$daily = Carbon::now();
		$daily = $daily->setTimezone('America/Chicago');
		//$daily = $daily->setTimezone('Asia/Calcutta');
		
		
		$cdate = $daily->format('Y-m-d');
		$currentDay = $daily->format('l');
		$hour = $daily->format("Hi");		
		
		$settings = Settings::find(1);


		$products = Products::where('qty', '<=', @$settings->low_quantity)->count();

		
		$start_time = $settings->start_time;
		//$close_time = $settings->close_time;
	
		if($currentDay=='Thursday' || $currentDay=='Friday' || $currentDay=='Saturday'){
			$start_time = $settings->start_time_second;
			//$close_time = $settings->close_time_second;
		}
		
		$ctime = $start_time;
		
		$start_time = Carbon::parse($start_time)->format("Hi");
		//$close_time = Carbon::parse($close_time)->format("Hi");
		
		if($hour < $start_time){
			$cdate = Carbon::now()->subDays(1)->format('Y-m-d');
		}
		
		$cdate = $cdate. ' '. $ctime;
		
		//$newdate = Carbon::createFromFormat('Y-m-d H:i:s', $cdate, 'America/Chicago');
		//$newdate->setTimezone('UTC');
		//$cdate = $newdate->format('Y-m-d H:i:s');
		
		//_________
		
		$dailyCancleOrder = Payment::where('order_status', '3')
			->where('created_at', '>=', $cdate)
			->count();
		
		$dailyOrder = Payment::where('order_status', '2')
			->where('created_at', '>=', $cdate)
			->count();			
		
		$dailySales = Payment::where('payment_status', 'captured')
			->where('is_progress', '0')
			->where('is_admin_cancle', '0')
			->where('is_refund', '0')
			->where('order_status', '2')
			->where('created_at', '>=', $cdate)
			->sum('amount');
		
		$dailyUser = User::where('role', 'user')
			->where('created_at', '>=', $cdate)
			->count();
		
 
		return view('admin.dashboard.index', compact('title', 'newOrder', 'dailyOrder', 'totalOrders', 'dailyCancleOrder', 'sales', 'dailySales', 'latestUser', 'products', 'dailyUser', 'settings'));
	}
}
