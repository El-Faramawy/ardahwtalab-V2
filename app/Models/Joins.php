<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joins extends Model
{
    protected $table='joins';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function users(){
		return $this->hasMany('App\Models\User','type');
	}
	public function user(){
		return $this->belongsTo('App\Models\User','user_id');
	}
	public function join(){
		return $this->belongsTo('App\Models\Jointypes','type');
	}
}
