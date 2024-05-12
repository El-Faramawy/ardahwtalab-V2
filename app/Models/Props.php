<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Props extends Model
{
	protected $table = 'proprites';
	protected $guarded = ['id'];
	protected $hidden = ['created_at', 'updated_at'];

	public function dept()
	{
		return $this->belongsTo('App\Models\Depts');
	}
	public function parent()
	{
		return $this->belongsTo('App\Models\Props');
	}
	public function types()
	{
		return $this->hasMany('\App\Models\PropTypes', 'prop_id');
	}

	public function title()
	{
		return $this->belongsTo(Titles::class, 'title_id');
	}
}
