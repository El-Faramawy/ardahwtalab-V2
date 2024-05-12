<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depts extends Model
{
	protected $table = 'depts';
	protected $guarded = ['id'];
	protected $hidden = ['created_at', 'updated_at'];

	public function advs()
	{
		return $this->hasMany('App\Models\Advs', 'dept');
	}

	public function getAllAdvsAttribute()
	{
		$childs = $this->childs()->lists('id');
		$childs[] = $this->id;
		return Advs::whereIn('dept', $childs);
	}

	public function childs()
	{
		return $this->hasMany(Depts::class, 'parent_id');
	}

	public function parent()
	{
		return $this->belongsTo(Depts::class, 'parent_id');
	}

	public function scopeMain($query)
	{
		return $query->where('parent_id', null);
	}

	public function getSuperIdAttribute()
	{
		return $this->parent_id ?? $this->id;
	}

	public function getSuperParentAttribute()
	{
		$department = $this;
		while ($department->parent_id != null) {
			$department = $department->parent;
		}
		return $department;
	}

	public function getParentsAttribute()
	{
		$parents = [];
		$department = $this;
		while ($department->parent_id != null || $department->parent_id != null) {
			$department = $department->parent;
			$parents[] = $department->id;
		}
		return $parents;
	}

	public function props()
	{
		return $this->hasMany('App\Models\Props', 'dept_id');
	}

	public function getMetasAttribute()
	{
		$keywords = $this->advs()->pluck('keywords')->toArray();
		$keywords = implode(',', $keywords);
		$keywords = explode(',', $keywords);
		$keywords = array_filter(array_unique($keywords));
		$keywords = array_slice($keywords, 0, 10);
		return $keywords;
	}

	public function getImageAttribute($img)
	{
		return $img ? url('/') . $img : '';
	}

	public function titles()
	{
		return $this->hasMany(Titles::class, 'dept_id');
	}

	public function getLinkAttribute()
	{
		$name = str_replace(['/' , '\\' , '  ' , ' '] , ['-' , '-' , '' , '-'] , $this->name);
		return route('cats', [$this->id, $name]);
	}
	public function getFullLinkAttribute()
	{
		$name = str_replace(['/' , '\\' , '  ' , ' '] , ['-' , '-' , '' , '-'] , $this->name);
		return route('cats', array_merge([$this->id, str_replace('/' , '-' , $name)], request()->query() , ['perpage' => request('perpage' , 20)]));
	}


	public function advs_n() {
        return $this->belongsToMany(Advs::class, 'advs_depts_pivot', 'dept_id', 'adv_id');
    }

}
