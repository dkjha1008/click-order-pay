<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'users_id',
        'card_name',
        'card_number',
        'expire_month',
        'expire_year',
    ];
	
}
