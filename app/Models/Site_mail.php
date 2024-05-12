<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site_mail extends Model
{
    protected $table='site_mail';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];
}
