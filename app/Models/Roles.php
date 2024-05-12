<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table='roles';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function users(){
		return $this->hasMany('App\Models\User');
	}
}
