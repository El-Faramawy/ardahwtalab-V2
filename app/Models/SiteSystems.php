<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSystems extends Model
{
    protected $table='site_systems';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
