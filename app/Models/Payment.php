<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'users_id',
        'carts_id',
        'transaction_id',
        'auth_code',
        'amount',
        'currency',
        'payment_status',
        'is_progress',
        'is_admin_cancle',
        'order_status',
        'is_refund',
    ];
	
	public function carts()
    {
		return $this->belongsTo('App\Models\Cart', 'carts_id');
	}
	
	public function user()
    {
		return $this->belongsTo('App\Models\User', 'users_id');
	}
	
	public function status()
    {
		return $this->hasOne('App\Models\PaymentStatus', 'payments_id')->orderBy('id', 'desc');
	}
	
	public function order_status()
    {
		return $this->belongsTo('App\Models\OrderStatus', 'order_status');
	}
	
	public function allStatus()
    {
		return $this->hasMany('App\Models\PaymentStatus', 'payments_id');
	}
	
	// public function address()
    // {
		// return $this->belongsTo('App\Models\Address', 'addresses_id');
	// }
	
	// public function carts()
    // {
		// return $this->belongsToMany('App\Models\Cart', 'App\Models\CartProducts', 'carts_id', 'products_id')->withPivot('quantity');
	// }
}
