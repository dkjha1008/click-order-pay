<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Console\Command;
use Mail;

use Omnipay\Omnipay;

use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatus as OrderStatusEmail;

class RefundCron extends Command
{
	
	/**
	* The name and signature of the console command.
	*
	* @var string
	*/
	protected $signature = 'refund:cron';

	/**
	* The console command description.
	*
	* @var string
	*/
	protected $description = 'Payment Refunded';
	
	/**
	* Create a new command instance.
	*/
	public function __construct() {
		parent::__construct();
		//$this->handle();
		
		$this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(config('services.authorize.login'));
        $this->gateway->setTransactionKey(config('services.authorize.key'));
		if(config('services.authorize.environment')=='SANDBOX'){
			$this->gateway->setTestMode(true); //comment this line when move to 'live'
		}
	}
	
	/**
	* Execute the console command.
	*
	* @return mixed
	*/
	public function handle(){
	
		$payments = Payment::where('order_status', '3')->where('is_progress', '1')->get();
		
		foreach($payments as $order){
			$response = $this->gateway->fetchTransaction([
				'transactionReference' => $order->transaction_id,
			])->send();
			
			if($response->getData()){
				$cardNumber = $response->getData()['transaction']['payment']['creditCard']['cardNumber'];
				$cardNumber = str_replace('XXXX', '', $cardNumber);
				
				$response = $this->gateway->refund([
					'amount' => $order->amount,
					'currency' => 'USD',
					'transactionReference' => $order->transaction_id,
					'numberLastFour' => $cardNumber
				])->send();
				
				if($response->isSuccessful()) {
					$order->order_status = '6';
					$order->is_progress = '0';
					$order->is_refund = '1';
					$order->save();
					
					$store = new PaymentStatus;
					$store->users_id = auth()->user()->id;
					$store->payments_id = $order->id;
					$store->order_status_id = '6';
					$store->comment = 'Payment Refund to user';
					$store->save();
					
					//user
					$mess = config('app.name').' has been refunded your payment $'.$order->amount;
					message($order->user->phone_number, $mess);
					
					//send email
					Notification::route('mail', config('app.admin.email'))
						->notify(new OrderStatusEmail($order, 'Payment refunded'));
					
				}
			}
		}
		
		
	}
	
	
}