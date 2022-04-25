<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'promocode',
        'start_date',
        'expire_date',
        'coupon_type',
        'discount',
        'uses_limit',
        'status'
    ];
}
