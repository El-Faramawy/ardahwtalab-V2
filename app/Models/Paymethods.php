<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymethods extends Model
{
    protected $table='pay_methods';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
