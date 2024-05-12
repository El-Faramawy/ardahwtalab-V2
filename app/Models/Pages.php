<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getUrlAttribute()
    {
        return $this->link ?? route('page', [$this->id, $this->slug]);
    }
}
