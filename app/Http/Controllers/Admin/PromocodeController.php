<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\User;
use App\Models\Products;

class PromocodeController extends Controller
{
    //-----
    public function index(Request $request){
		$title = array(
			'title' => 'Promocodes',
			'slug' => 'Listing All The Promocodes',
			'active' => 'promocode'
		);
		
		$promocode = Promocode::query();
		if(@$request->promocode){
			$promocode = $promocode->where('promocode', $request->promocode);
		}
		if(@$request->status){
			$promocode = $promocode->where('status', $request->status);
		}
		if(@$request->archive){
			$promocode = $promocode->where('is_delete', $request->archive);
		}
		else {
			$promocode = $promocode->where('is_delete', '0');
		}
		
		$promocode = $promocode->orderBy('id', 'desc')->paginate(10);
		
		
		return view('admin.promocode.index', compact('title', 'promocode'));
	}
	
	
	//-----
    public function create(){
		$title = array(
			'title' => 'Promocodes',
			'slug' => 'Add New Promocode',
			'active' => 'promocode'
		);
		
		$users = User::where('role', 'user')->pluck('phone_number', 'id');
		$products = Products::where('is_delete', '0')->where('status', '1')->pluck('title', 'id');
		
		return view('admin.promocode.create', compact('title', 'users', 'products'));
	}
	
	//store
	public function store(Request $request)
    {
		$request->validate([
			'promocode' => 'required|unique:promocodes,promocode',
			'start_date' => 'required',
			'expire_date' => 'required',
			'coupon_type' => 'required',
			'discount' => 'required',
			'uses_limit' => 'required',
			'status' => 'required',
		]);
		
		$store = new Promocode;
		$store->promocode = $request->promocode;
		$store->users = @$request->users ? json_encode($request->users) : '';
		// $store->products = @$request->products ? json_encode($request->products) : '';
		$store->start_date = $request->start_date;
		$store->expire_date = $request->expire_date;
		$store->coupon_type = $request->coupon_type;
		$store->discount = $request->discount;
		$store->uses_limit = $request->uses_limit;
		$store->status = $request->status;
		if(@$request->new_users=='yes'){
			$store->new_users = 'yes';
		}
		else {
			$store->new_users = 'no';
		}
		$store->save();
		
		$request->session()->flash('success', "Promocode Created Successfully");
		return redirect()->route("admin.promocode");		
	}
	
	//edit
	public function edit(Request $request, Promocode $code)
    {
		$title = array(
			'title' => 'Promocodes',
			'slug' => 'Edit Promocode',
			'active' => 'promocode'
		);
		
		$users = User::where('role', 'user')->pluck('phone_number', 'id');
		$products = Products::where('is_delete', '0')->where('status', '1')->pluck('title', 'id');
		
		return view('admin.promocode.edit', compact('title', 'code', 'users', 'products'));
    }
	
	//update
	public function update(Request $request, Promocode $code)
    {
		$request->validate([
			'promocode' => 'required|unique:promocodes,promocode,'.$code->id,
			'start_date' => 'required',
			'expire_date' => 'required',
			'coupon_type' => 'required',
			'discount' => 'required',
			'uses_limit' => 'required',
			'status' => 'required',
		]);
		
		$code->promocode = $request->promocode;
		$code->users = @$request->users ? json_encode($request->users) : '';
		$code->products = @$request->products ? json_encode($request->products) : '';
		$code->start_date = $request->start_date;
		$code->expire_date = $request->expire_date;
		$code->coupon_type = $request->coupon_type;
		$code->discount = $request->discount;
		$code->uses_limit = $request->uses_limit;
		$code->status = $request->status;
		if(@$request->new_users=='yes'){
			$code->new_users = 'yes';
		}
		else {
			$code->new_users = 'no';
		}
		$code->save();
		
		$request->session()->flash('success', "Promocode Updated Successfully");
		return redirect()->route("admin.promocode");
	}
	
	//delete
	public function destroy(Request $request, Promocode $code)
    {		
		if($code->is_delete=='1'){
			$code->is_delete = '0';
			$message = "Promocode Retrieve";
		}
		else {
			$code->is_delete = '1';
			$message = "Promocode Deleted";
		}
		$code->save();
		$request->session()->flash('success', $message);
		return redirect()->route("admin.promocode");
    }
}
