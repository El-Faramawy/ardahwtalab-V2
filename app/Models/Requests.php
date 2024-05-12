<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    protected $table='requests';
    protected $guarded = ['id'];

    public function advs(){
    	return $this->belongsTo('App\Models\Advs');
    }
    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}
