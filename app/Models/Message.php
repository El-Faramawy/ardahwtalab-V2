<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Message extends Model
{

    protected $table = 'message';
    protected $guarded = ['id'];
    protected $hidden = ['updated_at'];
    protected $appends = ['message'];


}
