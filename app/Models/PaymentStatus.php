<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'users_id',
		'payments_id',
        'order_status_id',
        'comment',
    ];
	
	public function user()
    {
		return $this->belongsTo('App\Models\User', 'users_id');
	}
	
	public function carts()
    {
		return $this->belongsTo('App\Models\Payment', 'payments_id');
	}
	
	public function order_status()
    {
		return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
	}
}
