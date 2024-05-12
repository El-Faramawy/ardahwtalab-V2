<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table='images';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function advs(){
		return $this->belongsTo('App\Models\Advs');
	}
	public function getImageAttribute($img){
		return $img ? url('/').$img : '';
	}
}
