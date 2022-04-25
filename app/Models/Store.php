<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['users_id', 'title', 'slug'];

    public function user()
    {
		return $this->belongsTo('App\Models\User', 'users_id');
	}

}
