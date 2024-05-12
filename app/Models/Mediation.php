<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mediation extends Model
{
    protected $table='mediation';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function advs(){
		return $this->belongsTo('App\Models\Advs');
	}
}
