<?php

	//check session route permissions accordingly user role
	function checkPermission($permissions){
		foreach ($permissions as $key => $value) {
			if($value == auth()->user()->role){				
				return true;
			}
		}
		return false;
	}

	//change date format
	function dateFormat($date){
		$date = explode('-', $date);
		$newDate = $date[1].'.'.$date[2].'.'.$date[0];
		return $newDate;
	}	
	
	//authCheck
	function authCheck(){
		if(auth()->check() && auth()->user()->status == '0'){
            auth()->logout();
            return true;
        }
		return false;
	}
	
	//salesDetails
	function salesDetails($month, $year){
		
		return App\Models\Payment::whereMonth('created_at', $month)
			->whereYear('created_at', $year)
			->where('payment_status', 'captured')
			->where('is_progress', '0')
			->where('is_admin_cancle', '0')
			->where('is_refund', '0')
			->where('order_status', '!=', '3')
			->sum('amount');
	}
	function storesalesDetails($month, $year){
		$cartIds =  App\Models\CartProducts::where('store_id',\Auth::id())->groupBy('carts_id')->pluck('carts_id');
		return App\Models\Payment::whereIn('carts_id',$cartIds)
		    ->whereMonth('created_at', $month)
			->whereYear('created_at', $year)
			->where('payment_status', 'captured')
			->where('is_progress', '0')
			->where('is_admin_cancle', '0')
			->where('is_refund', '0')
			->where('order_status', '!=', '3')
			->sum('amount');
	}
	
	//months
	function months(){
		$months = array (
			array("Jan", '01'),
			array("Feb", '02'),
			array("Mar", '03'),
			array("Apr", '04'),
			array("May", '05'),
			array("Jun", '06'),
			array("Jul", '07'),
			array("Aug", '08'),
			array("Sep", '09'),
			array("Oct", '10'),
			array("Nov", '11'),
			array("Dec", '12')
		);
		return $months;
	}
	
	//years
	function years(){
		$years = range( date("Y") , date("Y") + 10 );
		return $years;
	}
	
	
	
	//send message
	function message($phone_number, $message){
		// Your Account SID and Auth Token from twilio.com/console
		$sid = config('services.twilio.sid');
		$token = config('services.twilio.token');
		$from = config('services.twilio.number');
		$client = new \Twilio\Rest\Client( $sid, $token );
		
		//...
		$res = $client->messages->create(
			config('app.admin.country_code') .$phone_number,
			[
			'from' => $from,
			'body' => $message,
			]
		);
		
		return $res;
    }
	
	
	
	//daily sales
	function dailySales($date){
		//count
		$totalSales = App\Models\Payment::whereDate('created_at', $date)->count();
		//sum
		$totalOrders = App\Models\Payment::whereDate('created_at', $date)->sum('amount');
		//users
		$users = App\Models\User::whereDate('created_at', $date)->count();
		
		$data = [
			'totalSales' => $totalSales,
			'totalOrders' => $totalOrders,
			'users' => $users,
		];
		
		return $data;
	}
	
	
	
	
	