<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropTypes extends Model
{
    protected $table='prop_types';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function parent(){
		return $this->belongsTo('App\Models\PropTypes');
	}
	public function props(){
		return $this->belongsTo('App\Models\Props');
	}

	public function childs(){
		return $this->hasMany('App\Models\PropTypes','parent');
	}
}
