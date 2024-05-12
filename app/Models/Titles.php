<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Titles extends Model
{
    protected $table='properties_titles';
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at'];

    public function properties(){
        return $this->hasMany(Props::class , 'title_id');
    }

    public function dept(){
        return $this->belongsTo(Depts::class , 'dept_id');
    }
}
