<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Members extends Model
{

    protected $table = 'members';
    protected $guarded = ['id'];
    protected $fillable = ['id','title','price','time','descr','active'];

}
