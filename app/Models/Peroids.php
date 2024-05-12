<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peroids extends Model
{
    protected $table='peroids';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
