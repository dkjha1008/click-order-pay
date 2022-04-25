<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\Promocode;

class SettingsController extends Controller
{
    //...
	public function index(Request $request)
	{
		$title = array(
			'title' => 'Settings',
			'slug' => 'Store Settings',
			'active' => 'settings'
		);
		
		$setting = Settings::find('1');		
		
		$date = date('Y-m-d');
		$promocode = Promocode::where('start_date', '<=', $date)
		->where('expire_date', '>=', $date)
		->where('status', '1')
		->where('is_delete', '0')
		->pluck('promocode', 'promocode');
		
		return view('admin.settings.index', compact('title', 'setting', 'promocode'));
	}
	
	
	//...
	public function store(Request $request)
	{
		$request->validate([
			'store_tax' => 'required',
			'delivery_charges' => 'required',
			'low_quantity' => 'required',
			'order_limit' => 'required',
		]);
		
		$setting = Settings::find('1');
		
		$store = new Settings;
		if(@$setting){
			$store->id = $setting->id;
			$store->exists = true;
		}
		//store hours
		$store->store_online = $request->store_online;
		$store->store_modal = $request->store_modal;
		$store->store_offline_message = $request->store_offline_message;
		$store->start_time = $request->start_time;
		$store->close_time = $request->close_time;
		$store->start_time_second = $request->start_time_second;
		$store->close_time_second = $request->close_time_second;
		
		$store->linkedin = $request->linkedin;
		$store->instagram = $request->instagram;
		$store->tiktok = $request->tiktok;
		
		$store->store_tax = $request->store_tax;
		$store->delivery_charges = $request->delivery_charges;		
		
		$store->delivery_time = $request->delivery_time;
		$store->students_served = $request->students_served;
		
		$store->promocode_show = $request->promocode_show;
		$store->promocode_text = $request->promocode_text;
		$store->promocode = $request->promocode;
		$store->promocode_message = $request->promocode_message;
		

		$store->low_quantity = $request->low_quantity;
		$store->order_limit = $request->order_limit;
		

		$store->save();
		
		//...
		$request->session()->flash('success', "Settings Updated");
		return redirect()->route("admin.settings");	
	}
}
