<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jointypes extends Model
{
    protected $table='join_types';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function users(){
		return $this->hasMany('App\Models\User');
	}
}
