<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawCategory extends Model
{
    protected $table = 'law_categories';
    protected $fillable = ['name', 'cost', 'parent_id'];

    public function lawyers()
    {
        return $this->hasMany(Lawyer::class, 'category_id');
    }

    public function lawsuits()
    {
        return $this->hasMany(Lawsuit::class, 'category_id');
    }

    public function childs()
    {
        return $this->hasMany(LawCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(LawCategory::class, 'parent_id');
    }

}
