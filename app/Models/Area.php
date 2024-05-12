<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table='area';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

    public function country(){
    	return $this->belongsTo(Area::class);
    }
    public function advs(){
    	return $this->hasMany(Advs::class,'area');
    }
}
