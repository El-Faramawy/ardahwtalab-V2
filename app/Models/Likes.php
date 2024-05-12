<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table='likes';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function users(){
		return $this->belongsTo('App\Models\User');
	}
	public function advs(){
		return $this->belongsTo('App\Models\Advs');
	}
}
