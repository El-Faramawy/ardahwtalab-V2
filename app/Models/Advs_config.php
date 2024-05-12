<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advs_config extends Model
{
    protected $table='ads_config';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
