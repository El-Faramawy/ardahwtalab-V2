<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notfs extends Model
{
    protected $table='notfs';
    protected $guarded = ['id'];

    public function user(){
		return $this->belongsTo('App\Models\User');
	}
}
