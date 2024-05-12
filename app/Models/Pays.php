<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $table='pays';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function user(){
		return $this->belongsTo('App\Models\User','user_id');
	}
	public function getbank(){
		return $this->belongsTo('App\Models\Paymethods','bank');
	}
}
