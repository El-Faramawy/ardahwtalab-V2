<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
    protected $table='operations';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
