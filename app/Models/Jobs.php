<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model {

    protected $table = 'jobs';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
