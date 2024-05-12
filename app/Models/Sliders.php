<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $table='sliders';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
