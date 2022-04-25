<?php

namespace App\Http\Controllers\Store;

use App\Models\CartProducts;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as InertiaRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

// use Omnipay\Omnipay;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Payment;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;

use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatus as OrderStatusEmail;
use DB;


class StoreOrdersController extends Controller
{
	public function __construct()
    {
        // $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        // $this->gateway->setAuthName(config('services.authorize.login'));
        // $this->gateway->setTransactionKey(config('services.authorize.key'));
		// if(config('services.authorize.environment')=='SANDBOX'){
		// 	$this->gateway->setTestMode(true); //comment this line when move to 'live'
		// }
    }
	



	
	
	
	
	//..................................................................
	
	
	
	
	
	//...
	public function adminOrders(Request $request)
	{
		$title = array(
			'title' => 'Orders',
			'slug' => 'Listing All The Orders',
			'active' => 'orders'
		);
		$cartIds = CartProducts::where('store_id',\Auth::id())->groupBy('carts_id')->pluck('carts_id');
		
		$orders = Payment::whereIn('carts_id',$cartIds);
		
		if(@$request->user){
			$orders = $orders->where('users_id', $request->user);
		}
		if(@$request->status){
			$orders = $orders->where('order_status', $request->status);
		}
		if(@$request->payment_type){
			$orders = $orders->where('payment_type', $request->payment_type);
		}		
		
		if(@$request->from_date && empty($request->to_date)){
			$orders = $orders->whereDate('created_at', '>=', $request->from_date);
		}
		if(@$request->to_date && empty($request->from_date)){
			$orders = $orders->whereDate('created_at', '<=', $request->to_date);
		}
		if(@$request->from_date && @$request->to_date){
			if($request->from_date==$request->to_date){
				$orders = $orders->whereDate('created_at', $request->from_date);
			}
			else {
				$orders = $orders->whereBetween('created_at', [$request->from_date, $request->to_date]);
			}
		}
		
		$orders = $orders->orderBy('id', 'desc')->paginate(10);
		
		$users = User::where('role', 'user')->where('status', '1')->pluck('phone_number', 'id');
		$status = OrderStatus::where('status', '1')->pluck('name', 'id');
		
		return view('store.orders.index', compact('title', 'orders', 'users', 'status'));
	}
	
	
	//...
	public function adminOrdersCsv(Request $request)
	{
		$cartIds = CartProducts::where('store_id',\Auth::id())->groupBy('carts_id')->pluck('carts_id');
		
		$orders = Payment::whereIn('carts_id',$cartIds);
		
       
		if(@$request->user){
			$orders = $orders->where('users_id', $request->user);
		}
		if(@$request->status){
			$orders = $orders->where('order_status', $request->status);
		}
		if(@$request->payment_type){
			$orders = $orders->where('payment_type', $request->payment_type);
		}
		if(@$request->from_date && empty($request->to_date)){
			$orders = $orders->whereDate('created_at', '>=', $request->from_date);
		}
		if(@$request->to_date && empty($request->from_date)){
			$orders = $orders->whereDate('created_at', '<=', $request->to_date);
		}
		if(@$request->from_date && @$request->to_date){
			if($request->from_date==$request->to_date){
				$orders = $orders->whereDate('created_at', $request->from_date);
			}
			else {
				$orders = $orders->whereBetween('created_at', [$request->from_date, $request->to_date]);
			}
		}
		
		$orders = $orders->orderBy('id', 'desc')->get();
		
		//csv
		$filename = auth()->user()->id . date('Y_m_d_h_i');
		
		$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=".$filename.".csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		);
		
		$columns = array('Order Id', 'User Name', 'Phone', 'ID', 'Amount', 'Payment Type', 'Status', 'Date');
		
		$callback = function() use ($orders, $columns) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);
			
			foreach($orders as $order){
			
				$datas = array();
				
				$datas['Order Id'] = $order->id;
				$datas['User Name'] = $order->user->name;
				$datas['Phone'] = $order->user->phone_number;
				$datas['ID'] = $order->user->verified=='1' ? 'Verified' : 'Not Verified';
				$datas['Amount'] = $order->amount;
				$datas['Payment Type'] = $order->payment_type;
				$datas['Status'] =($order->payment_status=='pending' && $order->order_status!='3') ? 'Order Payment Pending' : $order->status->order_status->name;
				$datas['Date'] = $order->created_at->timezone('America/Chicago')->format('d/m/Y - h:ia');
				
				
				fputcsv($file, $datas);
			}
			fclose($file);
		};
		
		
		return response()->stream($callback, 200, $headers);
		
	}
	
	
	//...
	public function adminOrderShow(Request $request, Payment $order)
	{
		$title = array(
			'title' => 'Orders',
			'slug' => 'Order Details',
			'active' => 'orders'
		);
		$id = '';
		if($order->order_status=='1'){
			$id = '5';
		}
		if($order->order_status=='5'){
			$id = '2';
		}
		
		$status = [];
		if(@$id){
			$status = OrderStatus::where('id', $id)->pluck('name', 'id');
		}
		
		return view('store.orders.show', compact('title', 'order', 'status'));
	}
	
	//---
	public function orderStatus(Request $request, Payment $order)
	{
		$request->validate([
			'status' => 'required',
		]);

		$order->order_status = $request->status;
		$order->save();
		
		$store = new PaymentStatus;
		$store->users_id = auth()->user()->id;
		$store->payments_id = $order->id;
		$store->order_status_id = $request->status;
		$store->comment = $request->comment;
		$store->save();
		
		//revert qty
		if($request->status=='3'){
			$cartProduct = $order->carts->cartProduct;
			foreach($cartProduct as $cart){
				$product = $cart->product;
				$product->qty = $product->qty + $cart->quantity;
				$product->save();
			}
		}
		
		$message = OrderStatus::find($request->status);

		$newMess = '';
		$newMess .= $message->name;
		if(@$request->comment){
			$newMess .= ', Comment - '.$request->comment;
		}
		//user
		try{
			message($order->user->phone_number, $newMess);
		} catch(Exception $e) { }
		
		
		//send email
		try{
			Notification::route('mail', config('app.admin.email'))
				->notify(new OrderStatusEmail($order, $newMess));
		} catch(Exception $e) { }
		
		
		$request->session()->flash('success', "Status Updated");
		return redirect()->route("store.orders.show", $order->id);
		
	}
	
	//...
	public function adminRefund(Request $request, Payment $order)
	{
		if($order->order_status=='3')
		{
			$order->is_progress = '1';
			$order->save();
			
			//...			
			try{
				message($order->user->phone_number, 'Payment in Progress');
			} catch(Exception $e) { }

			//send email
			try{
				Notification::route('mail', config('app.admin.email'))
					->notify(new OrderStatusEmail($order, 'Refunded Payment in Progress'));
			} catch(Exception $e) { }
			
			
			//$request->session()->flash('success', "Payment in Progress");
			return redirect()->route("store.orders.show", $order->id);
		}
		//...
		$request->session()->flash('error', "Invalid Request");
		return redirect()->route("store.orders");
	}
	
	
	
	
	//not used->check cron
	public function orderPayment(Request $request, Payment $order)
	{
		if($order->payment_status=='pending'){
			$order->payment_status = 'captured';
			$order->save();
			
			//user			
			try{
				message($order->user->phone_number, 'Your Order Payment Received');
			} catch(Exception $e) { }

			//send email
			try{
				Notification::route('mail', config('app.admin.email'))
				->notify(new OrderStatusEmail($order, 'Venmo Payment Completed'));
			} catch(Exception $e) { }			
				
			$request->session()->flash('success', "Payment Completed");
			return redirect()->route("store.orders.show", $order->id);
		}
		
		$request->session()->flash('error', "Invalid Request");
		return redirect()->route("store.orders");
	}
	
	//...
	public function dailysales(Request $request)
	{
		$title = array(
			'title' => 'Orders',
			'slug' => 'Daily Sales',
			'active' => 'orders'
		);
		$cartIds = CartProducts::where('store_id',\Auth::id())->groupBy('carts_id')->pluck('carts_id');
		
		$orders = Payment::whereIn('carts_id',$cartIds)->select(DB::raw('DATE(created_at) as date'))
			->groupBy('date')
			->orderBy('date', 'desc')
			->paginate(10);

		return view('store.orders.dailysales', compact('title', 'orders'));
	}
}
