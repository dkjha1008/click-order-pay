<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'store_online',
		'store_modal',
		'store_offline_message',
		'start_time',
		'close_time',
		'start_time_second',
		'close_time_second',
		'instagram',
		'linkedin',
		'tiktok',
		'store_tax',
		'delivery_charges',
		'delivery_time',
		'students_served',
		'promocode_show',
		'promocode_text',
		'promocode',
		'promocode_message',
    ];
	
}
