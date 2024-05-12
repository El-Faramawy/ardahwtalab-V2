<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table='user_contacts';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	public function user(){
		return $this->belongsTo('App\Models\User');
	}
}
