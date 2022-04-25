<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
        'email',
        'phone_number',
        'image',
        'city',
        'state',
        'zip_code',
        'address',
        'notes',
        'verified',
        'status',
        'store_slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];
	
	public function payment()
    {
		return $this->hasMany('App\Models\Payment', 'users_id');
	}
	
	public function address()
    {
		return $this->hasOne('App\Models\Address', 'users_id');
	}

    public function store()
    {
		return $this->hasOne('App\Models\Store', 'users_id');
	}
}
