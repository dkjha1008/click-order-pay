<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'users_id',
        'guest_uuid',
        'tax',
        'delivery_charges',
        'tip',
        'promocode',
        'price',
        'total_price',
        'status',
        'pickup_date',
        'pickup_time'
    ];


	public function products()
    {
		return $this->belongsToMany('App\Models\Products', 'App\Models\CartProducts', 'carts_id', 'products_id')->withPivot('quantity', 'price', 'type', 'size');
	}
	
	public function cartProduct()
    {
		return $this->hasMany('App\Models\CartProducts', 'carts_id');
	}
	
	public function promo()
    {
		return $this->belongsTo('App\Models\Promocode', 'promocode', 'promocode');
	}
	
}
