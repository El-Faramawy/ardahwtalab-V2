<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model {

    protected $table = 'rates';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function rater() {
        return $this->belongsTo('App\Models\User');
    }

}
