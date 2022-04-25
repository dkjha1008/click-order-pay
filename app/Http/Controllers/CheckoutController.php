<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as InertiaRequest;
use Illuminate\Support\Facades\Redirect;

use Omnipay\Omnipay;
//...
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use App\Models\Cart;
use App\Models\Promocode;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\Address;
use App\Models\Settings;
use App\Models\ProductAttribute;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderPlacedVenmo;
use Stripe\Stripe;

use Carbon\Carbon;

class CheckoutController extends Controller
{
	public $gateway;
	private $stripe;

    public function __construct()
    {
        /* $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(config('services.authorize.login'));
        $this->gateway->setTransactionKey(config('services.authorize.key'));
		if(config('services.authorize.environment')=='SANDBOX'){
			$this->gateway->setTestMode(true); //comment this line when move to 'live'
		} */
        $key = "sk_test_51HNz14IKJM6jnGd5TlpQS173p8Z8XFcTfiPQSZV9KuDV9qL9Mf0xr7kEvwqtGFa5UADHi3V52G3iplWxTWLuf9sK00iSOZg26J";
        $this->stripe = new \Stripe\StripeClient($key);
        $this->middleware('auth');

		
    }
	
	//...
	public function user(Request $request)
	{

		// return $request;
		if(!$request->name){
			return response(['type'=>'error', 'message'=>'Name is Required']);
		}
		if(Auth::check()==false){
			
			if(!$request->phone_number){
				return response(['type'=>'error', 'message'=>'Phone number is Required']);
			}
			$numberCheck = User::where('phone_number', $request->phone_number)->count();
			if($numberCheck>0){
				return response(['type'=>'error', 'message'=>'Phone number already exist']);
			}
			try {
				message($request->phone_number, 'Verify Mobile Number');
			}
			catch(\Exception $e) {
				return response(['type'=>'error', 'message'=> 'Invalid Phone number']);
			}
			
			if(strlen(trim($request->password)) <= 6){
				return response(['type'=>'error', 'message'=>'Password must be 6 characters']);
			}
		}
		
		// if(!$request->address){
		// 	return response(['type'=>'error', 'message'=>'Address is Required']);
		// }
		
		// if(!$request->address){
		// 	return response(['type'=>'error', 'message'=>'Address is Required']);
		// }
		
		if(@$request->promo_code){
			$date = date('Y-m-d');
			$code = Promocode::where('promocode', $request->promo_code)
			->where('start_date', '<=', $date)
			->where('expire_date', '>=', $date)
			->where('status', '1')
			->count();
			
			if($code==0){
				return response(['type' => "error", 'message' => "Invalid Promo Code"], 200);
			}
		}
		
		return response(['type'=>'success', 'message'=>'Sucess']);
		
	}
	
	//...
	public function store(Request $request)
	{
		// return response()->json(['data'=>$request->all()]);
		InertiaRequest::validate([
			'name' => 'required|string|max:50',
			// 'address' => 'required|string|max:255',
			'card_name' => 'required|max:50',
			'zip_code' => 'required|min:3',
			'card_number' => 'required|min:12|max:16',
			'cvv' => 'required|min:3|max:4',
			'expire_month' => 'required|digits:2',
			'expire_year' => 'required|digits:4',
		]);

		//update profile
		$check = User::where('phone_number', $request->phone_number)->first();
		
		$user = new User;
		if(@$check){
			$user->id = $check->id;
			$user->exists = true;
		}
		else {
			$user->phone_number = $request->phone_number;
			$user->password = Hash::make($request->password);
			$user->verified_at = date('Y-m-d H:i:s');
		}
		$user->name = $request->name;
		$user->address = $request->address;
		$user->notes = $request->notes;
		$user->zip_code = $request->zip_code;
		$user->save();
		
		if(Auth::check()==false){
			Auth::attempt(
				InertiaRequest::validate([
					'phone_number' => ['required'],
					'password' => ['required'],
				])
			);
		}



		//....checking order limit...................
		$setting = Settings::find('1');
		$checkLastOrderTime = Payment::where('users_id', auth()->user()->id)
			->where('created_at', '>', Carbon::now()->subDay())
			->count();

		if($checkLastOrderTime >= $setting->order_limit){
			return Redirect::back()->with('error', "You can't place more then ".$setting->order_limit." Orders per day");
		}

		
		//calculate amount
		$amount = $request->pay_amount;
		
		$code = '';
		if($request->promo_code){
			$date = date('Y-m-d');
			$code = Promocode::where('promocode', $request->promo_code)
				->where('start_date', '<=', $date)
				->where('expire_date', '>=', $date)
				->where('status', '1')
				->where('is_delete', '0')
				->first();
			if(!$code){
				return Redirect::back()->with('error', 'Invalid Promo Code');
			}
		}
		
		//cart
		$uuid = $request->uuid;
		$cart = Cart::where('status', 'cart')
		->where(function ($query) use ($uuid) {
			$query->where('guest_uuid', $uuid);
			if(Auth::check()==true){
				$query->orWhere('users_id', auth()->user()->id);
			}
		})
		->first();
		
		if(@$cart){
			//$user = auth()->user();
			$user = User::find(auth()->user()->id);
			
			$cart->users_id = $user->id;
			$cart->promocode = @$code ? $code->promocode : '';
			$cart->tax = $request->tax;
			$cart->delivery_charges = $request->delivery_charges;
			$cart->tip = $request->tip;
			$cart->price = $request->totalPrice;
			$cart->total_price = $amount+$request->tip;
			$cart->pickup_time = $request->pickup_time;
			$cart->pickup_date = $request->pickup_date;
			$cart->save();
			
			$checkAddress = Address::where('users_id', $user->id)->first();
			$address = new Address;
			$address->users_id = $user->id;
			if(@$checkAddress){
				$address->id = $checkAddress->id;
				$address->exists = true;
			}
			$address->card_name = $request->card_name;
			$address->card_number = $request->card_number;
			$address->expire_month = $request->expire_month;
			$address->expire_year = $request->expire_year;
			$address->save();
		
			
			//----------
			//payment
			try {
			
				// // Common setup for API credentials
				// $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
				// $merchantAuthentication->setName(config('services.authorize.login'));
				// $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
				
		
				// // Generate a unique merchant site transaction ID.				
				// $transactionId = 'ref'.time();
				
				// // Create the payment data for a credit card
				// $creditCard = new AnetAPI\CreditCardType();
				// $creditCard->setCardNumber($request->input('card_number'));
				// $expiry = $request->input('expire_year') . '-' . $request->input('expire_month');
				// $creditCard->setExpirationDate($expiry);
				// $creditCard->setCardCode($request->input('cvv'));
				
				// // Add the payment data to a paymentType object
				// $paymentOne = new AnetAPI\PaymentType();
				// $paymentOne->setCreditCard($creditCard);


				// // Create order information
				// $order = new AnetAPI\OrderType();
				// $order->setInvoiceNumber($cart->id);

				// // Set the customer's Bill To address
				// $customerAddress = new AnetAPI\CustomerAddressType();
				// $customerAddress->setFirstName($address->card_name);
				// $customerAddress->setAddress($user->address);
				// $customerAddress->setPhoneNumber($user->phone_number);
				// //$customerAddress->setCity($user->city);
				// //$customerAddress->setState($user->state);
				// $customerAddress->setZip($user->zip_code);
				// $customerAddress->setCountry("USA");
	
				// // Create a transaction
				// $transactionRequestType = new AnetAPI\TransactionRequestType();
				// $transactionRequestType->setTransactionType("authCaptureTransaction");
				// $transactionRequestType->setAmount($amount);
				// $transactionRequestType->setPayment($paymentOne);
				// $transactionRequestType->setOrder($order);
				// $transactionRequestType->setBillTo($customerAddress);				
				
				// // Assemble the complete transaction request
				// $paymentRequest = new AnetAPI\CreateTransactionRequest();
				// $paymentRequest->setMerchantAuthentication($merchantAuthentication);
				// $paymentRequest->setRefId($transactionId);
				// $paymentRequest->setTransactionRequest($transactionRequestType);
				// $controller = new AnetController\CreateTransactionController($paymentRequest);
				
				// $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
				// //if payment mode is production
				 $input = $request->all();
				try{
					 $token = $this->stripe->tokens->create([
						'card' => [
						  'number' => $input['card_number'],
						  'exp_month' => $input['expire_month'],
						  'exp_year' => $input['expire_year'],
						  'cvc' => $input['cvv'],
						],
					  ]);
					  session(['token_id' => $token->id]);
					  // Retrieve a piece of data from the session...
						//  session('token_id');
					$scustomer = $this->stripe->customers->create([
							// 'description' => $description,
							'email' => $user->email,
							'source' => session('token_id'),
						]);
		
						$charge = $this->stripe->charges->create([
							'amount' =>  $amount*100,
							'currency' => 'usd',
							'customer' => $scustomer['id']
						  ]);
			  
						  $charge_id = $charge['id'];


						  $payment = new Payment;
						  $payment->users_id = $user->id;
						  $payment->carts_id = $cart->id;
						  $payment->transaction_id =   $charge_id ;
						  // $payment->auth_code = $tresponse->getAuthCode();
						  $payment->amount = $amount+$request->tip;;
						  $payment->currency = 'USD';
						  $payment->payment_status = 'captured';
						  $payment->order_status = '1';
						  $payment->save();
						  
						  //---
						  $cart->status = 'paid';
						  $cart->save();
						  
						  //--reduce the items
						  foreach($cart->cartProduct as $pro){
								
								//quantity update
								$product = $pro->product;
								$product->qty = $product->qty - $pro->quantity;
								$product->save();
							
								
								
								
								//cart price update
								if($pro->type=='Variable'){
									$attribute = ProductAttribute::where([
										'products_id' => $product->id,
										'value' => $pro->size,
									])->first();
								
									$pro->price = $attribute->price;
								}
								else {
									$pro->price = $product->price;
								}
								$pro->save();
							  
						  }
						  
						  //PaymentStatus
						  $status = new PaymentStatus;
						  $status->users_id = $user->id;
						  $status->payments_id = $payment->id;
						  $status->order_status_id = '1';
						  $status->comment = 'Order Created';
						  $status->save();

					//   return response()->json(['status'=>202, 'message'=>'Card is working fine.']);
					return Redirect::route('orders')->with('success', 'Order Completed');
					//  return Redirect::route('orders.show', $payment->id)->with('success', 'Order Placed');
					} catch (\Exception $e) {
						$error = $e->getMessage();
						
					}
				}
				catch (\Stripe\Error\RateLimit $e) {
					$error = $e->getMessage();                  
				} catch (\Stripe\Error\InvalidRequest $e) {
					$error = $e->getMessage();
				} catch (\Stripe\Error\Authentication $e) {
					$error = $e->getMessage();
				} catch (\Stripe\Error\ApiConnection $e) {
					$error = $e->getMessage();
				} catch (\Stripe\Exception\Base $e) {
					$error = $e->getMessage();
				} catch (\Stripe\Exception\InvalidRequestException $e) {
					  $error = $e->getMessage();
				} catch (\Stripe\Exception\CardException $e) {
				  $error = $e->getMessage();                  
			   } catch (\Exception $e) {
					$error = $e->getMessage();
				}
	  
				// return response()->json(['status'=>422, 'message'=>$error]); 
				return Redirect::route('ucla')->with('error', $error);
			}
			else {
				return Redirect::route('ucla')->with('error', 'Cart is Empty');
			}
			

				//  if(config('services.authorize.environment')=='PRODUCTION'){
				//  	$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
				//  }
			
				
				// if ($response != null){
				// 	$tresponse = $response->getTransactionResponse();
				// 	if (($tresponse != null) && ($tresponse->getResponseCode()=="1")) {
						
						
						//notify
						// try{							
						// 	//admin
						// 	$mes = 'New Order Placed, Name: '.$user->name.', Phone Number:'.$user->phone_number.', Address:'.$user->address;
						// 	message(config('app.admin.phone_number'), $mes);

						// 	//user
						// 	message($user->phone_number, 'Your Order Placed');
						// } catch(Exception $e) { }

						// //send email
						// try{
						// 	Notification::route('mail', config('app.admin.email'))
						// 		->notify(new OrderPlaced($payment));
						// } catch(Exception $e) { }
						
						// //return Redirect::route('orders')->with('success', 'Order Completed');
						// return Redirect::route('orders.show', $payment->id)->with('success', 'Order Placed');
					
						// 	}
				// 	else {
				// 		return Redirect::back()->with('error', 'Charge Credit Card ERROR :  Invalid response');
				// 	}
				// }
				// else {
				// 	return Redirect::back()->with('error', 'Charge Credit Card Null response returned');
				// }
			
			
			// catch(Exception $e) {
			// 	return Redirect::back()->with('error', $e->getMessage());
			// }
			
	}
	 public function getStripeToken(Request $request)
    {
        //dd($input = $request->all());
        $input = $request->all();
               try{
        $token = $this->stripe->tokens->create([
            'card' => [
              'number' => $input['card_number'],
              'exp_month' => $input['expire_month'],
              'exp_year' => $input['expire_year'],
              'cvc' => $input['cvv'],
            ],
          ]);
          session(['token_id' => $token->id]);
          // Retrieve a piece of data from the session...
            //  session('token_id');
          return response()->json(['status'=>202, 'message'=>'Card is working fine.']);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>422, 'message'=>$msg]);
        }
	
	
	
	
	}
	//...
	public function venmo(Request $request)
	{
		InertiaRequest::validate([
			'name' => 'required|string|max:50',
			'address' => 'required|string|max:255',
		]);
		
		
		//update profile
		//$check = User::where('phone_number', $request->phone_number)->first();


		//....checking order limit...................
		$setting = Settings::find('1');
		$checkLastOrderTime = Payment::where('users_id', auth()->user()->id)
			->where('created_at', '>', Carbon::now()->subDay())
			->count();
		
		if($checkLastOrderTime >= $setting->order_limit){
			return Redirect::back()->with('error', "You can't place more then ".$setting->order_limit." Orders per day");
		}

		//dd($checkLastOrderTime);

		if(auth()->user()->status=='2'){
			Auth::logout();
			return Redirect::back()->with('error', 'Invalid Request');
		}


		$check = auth()->user();
		$user = new User;
		if(@$check){
			$user->id = $check->id;
			$user->exists = true;
		}
		else {
			$user->phone_number = $request->phone_number;
			$user->password = Hash::make($request->password);
			$user->verified_at = date('Y-m-d H:i:s');
		}
		$user->name = $request->name;
		$user->address = $request->address;
		$user->notes = $request->notes;
		$user->save();
		
		if(Auth::check()==false){
			Auth::attempt(
				InertiaRequest::validate([
					'phone_number' => ['required'],
					'password' => ['required'],
				])
			);
		}
		
		//calculate amount
		$amount = $request->pay_amount;
		
		$code = '';
		if($request->promo_code){
			$date = date('Y-m-d');
			$code = Promocode::where('promocode', $request->promo_code)
				->where('start_date', '<=', $date)
				->where('expire_date', '>=', $date)
				->where('status', '1')
				->where('is_delete', '0')
				->first();
			if(!$code){
				return Redirect::back()->with('error', 'Invalid Promo Code');
			}
		}
		
		//cart
		$uuid = $request->uuid;
		$cart = Cart::where('status', 'cart')
		->where(function ($query) use ($uuid) {
			$query->where('guest_uuid', $uuid);
			if(Auth::check()==true){
				$query->orWhere('users_id', auth()->user()->id);
			}
		})
		->first();
		
		if(@$cart){
			$user = User::find(auth()->user()->id);

			$cart->users_id = $user->id;
			$cart->promocode = @$code ? $code->promocode : '';
			$cart->tax = $request->tax;
			$cart->delivery_charges = $request->delivery_charges;
			$cart->tip = $request->tip;
			$cart->price = $request->totalPrice;
			$cart->total_price = $amount;
			$cart->save();
			
			//----------
			//payment
			// Insert transaction data into the database
			$payment = new Payment;
			$payment->users_id = $user->id;
			$payment->carts_id = $cart->id;
			$payment->amount = $amount;
			$payment->currency = 'USD';
			$payment->payment_type = 'venmo';
			$payment->payment_status = 'pending';
			$payment->order_status = '1';
			$payment->save();
			
			//---
			$cart->status = 'paid';
			$cart->save();
			
			//--reduce the items
			foreach($cart->cartProduct as $pro){
				$product = $pro->product;
				$product->qty = $product->qty - $pro->quantity;
				$product->save();
			}
			
			//PaymentStatus
			$status = new PaymentStatus;
			$status->users_id = $user->id;
			$status->payments_id = $payment->id;
			$status->order_status_id = '1';
			$status->comment = 'Order Created';
			$status->save();
			
			//notify
			try{
				//admin
				$mes = 'New Order Placed, payment type is Venmo. Name: '.$user->name.', Phone Number:'.$user->phone_number.', Address:'.$user->address;
				message(config('app.admin.phone_number'), $mes);

				//user
				//$url = 'venmo://paycharge?txn=pay&recipients=shmackedut&amount='.$amount.'&note=SHMACKED.COM: 15 minute delivery order #'.$payment->id;
				$msg = 'Your Order Placed, follow the link for payment '. route('orders.show', $payment->id);
				message($user->phone_number, $msg);
			} catch(Exception $e) { }

			//send email
			try{
				Notification::route('mail', config('app.admin.email'))
					->notify(new OrderPlacedVenmo($payment));
			} catch(Exception $e) { }
			
			//return Redirect::route('orders')->with('success', 'Order Completed');
			return Redirect::route('orders.show', $payment->id)->with('success', 'Order Placed');

		}
		else {
			return Redirect::route('ucla')->with('error', 'Cart is Empty');
		}
	}
	
	
	
	
}
