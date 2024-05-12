<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posters extends Model
{
    protected $table='posters';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
