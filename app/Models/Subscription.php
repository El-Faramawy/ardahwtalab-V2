<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Subscription extends Model{

    protected $table= "subscriptions" ;
    protected $fillable = [
        'title' , 'description' , 'duration' , 'price' , 'active',
    ] ;

    public function advs(){
        return $this->hasMany('App\Models\Advs' , 'subscription_id' , 'id');
    }

}
