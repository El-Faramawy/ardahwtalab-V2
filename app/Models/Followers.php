<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    protected $table='followers';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function user(){
		return $this->belongsTo('App\Models\User','user_id','id');
	}
	public function follower(){
		return $this->belongsTo('App\Models\User','follower_id','id');
	}
}
