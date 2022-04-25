<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use App\Models\Favourite;

use Inertia\Inertia;
use Illuminate\Support\Facades\Request as InertiaRequest;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactUs;
use App\Models\Attribute;

use Artisan;


use DB;

use App\Models\CartProductsNew;
use App\Models\User;
use App\Models\Store;

class FrontController extends Controller
{


	public function insta(){

		$cart = CartProductsNew::all();

		foreach($cart as $cc){

			$products = Products::find($cc->products_id);
			$products->qty = $products->qty + $cc->quantity;
			$products->save();

			$cc->delete();

		}

	}

	public function move(){
		if(\Auth::check()){
			$role = \Auth::user()->role;
			if($role=='user') return  Redirect::route('ucla')->with('success', 'Welcome Back.');
			if($role=='admin') return  Inertia::location('/admin');
			if($role=='store') return  Inertia::location('/store');

		}else{
			Redirect::route('/');
		}
	}
	
	//...
	public function cron(){
		Artisan::call('refund:cron');
		//Artisan::call('schedule:run');
	}	
	
    //...
	public function home(){
		$stores = Store::whereHas('user',function($query) {
			$query->where('role','store')->where('status','1');
		})->select('title','slug')->get();
		$category = Category::where('status', '1')->where('is_delete', '0')->orderBy('reorder', 'asc')->get();
		return Inertia::render('Home', ['category'=>$category,'stores'=>$stores]);
	}
	
	//...
	public function storeHours(){
		return Inertia::render('Storehours');
	}
	
	//...
	public function about(){
		return Inertia::render('About');
	}
	
	//...
	public function currentLocation(){
		return Inertia::render('Currentlocation');
	}
	
	//...
	public function joinus(){
		return Inertia::render('Joinus');
	}
	
	//...
	public function contact(){
		return Inertia::render('Contact');
	}
	
	//contact Us form submit
    public function contactUsForm(Request $request){
		InertiaRequest::validate([
			'name' => 'required|min:3|max:50',
			'email' => 'required|string|email|min:3|max:100',
			'phone_number' => 'required|numeric|digits_between:10,12',
			'subject' => 'required|min:3|max:200',
			'message' => 'required|min:10'
		]);
		
		//send email
		Notification::route('mail', config('app.admin.email'))
			->notify(new ContactUs($request->all()));

		return Redirect::route('contact')->with('success', "Thanks for your query, we'll get on that");
	}
	
	//...
	public function privacy(){
		return Inertia::render('Privacy');
	}
	
	//...
	public function terms(){
		return Inertia::render('Terms');
	}
	
	//...
	public function applyNow(){
		return view('apply_now');
	}
	
	
	//...
	public function favourite()
	{		
		return Inertia::render('Favourite');
	}
	
	
	//...
	public function favouriteData(Request $request)
	{
		$uuid = $request->uuid;
		$products = Favourite::with('product')
			->where(function ($query) use ($uuid) {
				$query->where('guest_uuid', $uuid);
				if(auth()->check()==true){
				$query->orWhere('users_id', auth()->user()->id);
				}
			})
			->orderBy('id', 'desc');			
			if(@$request->page=='fav'){
				$products = $products->get();
			}
			else {
				$products = $products->pluck('products_id');
			}
		
		return response(['type' => "success", 'message' => "Favorite Data", 'products'=>$products], 200);
	}
	
	//favouriteAction 
	public function favouriteAction(Request $request)
	{
		$uuid = $request->uuid;
		$message = '';
		
		$product = Favourite::where('products_id', $request->product)
			->where(function ($query) use ($uuid) {
				$query->where('guest_uuid', $uuid);
				if(auth()->check()==true){
				$query->orWhere('users_id', auth()->user()->id);
				}
			})
			->first();
			
		if(@$product){
			$product->delete();
			$message = 'Product removed from favorite list';
		}
		else {
			$store = new Favourite;
			$store->guest_uuid = $uuid;
			if(auth()->check()==true){
				$store->users_id = auth()->user()->id;
			}
			$store->products_id = $request->product;
			$store->save();
			$message = 'Product added to favorite list';
		}
		
		
		$products = Favourite::with('product')
			->where(function ($query) use ($uuid) {
				$query->where('guest_uuid', $uuid);
				if(auth()->check()==true){
				$query->orWhere('users_id', auth()->user()->id);
				}
			})
			->orderBy('id', 'desc');
		
		if(@$request->page=='fav'){
			$products = $products->get();
		}
		else {
			$products = $products->pluck('products_id');
		}
		return response(['type' => "success", 'message' => $message, 'products'=>$products], 200);
	}
	
	
	//...
	public function ucla(){
	 
		$request = InertiaRequest::only('search', 'type','store');
		if(!isset($request['store'])) return redirect('/');
		$storeId = Store::where('slug',$request['store'])
					
					->first()->users_id;
		$category = Category::where('status', '1')->where('is_delete', '0');
		
		$allcat = $category->orderBy('reorder', 'asc')->get();
		
		if(@$request['type']){
			$category = $category->where('slug', $request['type']);
		}
		$category = $category->orderBy('id', 'asc')->get();
		
		foreach($category as $cat){
			$products = Products::with('attributes')->where('category', $cat->id)
				->where('status', '1')
				->where('store_id',$storeId )
				->where('is_delete', '0')
				->orderBy('reorder', 'asc')->get();
			// dd($products[2]->attributes);
			
			// $modified = $products->map(function($item, $key) {
			// 	return strtoupper($item);
			//  });

			$cat->products = $products;

		}
		
		$products = '';
		if(@$request['search']){
			$products = Products::with('attributes')->where('status', '1')
				->where('is_delete', '0')
				->where('store_id',$storeId )
				->where('title', 'like', '%'.$request['search'].'%')
				->orderBy('reorder', 'asc')->get();
		}
	   $attributes = Attribute::all();

		return Inertia::render('Ucla', ['category'=>$category, 'allcat'=>$allcat, 'products'=>$products, 'attributes'=>$attributes]);
	}


	
	
	
}
