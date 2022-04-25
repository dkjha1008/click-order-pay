<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'guest_uuid',
        'users_id',
        'products_id',
    ];
	
	
	public function product()
    {
		return $this->belongsTo('App\Models\Products', 'products_id');
	}
}
