<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
	protected $table = 'bids';
	protected $guarded = ['id'];
	protected $hidden = ['updated_at'];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
	public function advs()
	{
		return $this->belongsTo('App\Models\Advs');
	}

	public function getCreatedAtAttribute($created_at)
	{
		return date('Y / m / d', strtotime($created_at));
	}
}
