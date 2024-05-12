<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionReports extends Model
{

    protected $table = 'commission_reports';

    protected $fillable = [
        'user_id',
        'adv_id',
        'order_id',
        'price',
        'status',
        ];

    public function user(){
    	return $this->hasOne('App\Models\User','id','user_id');
    }

    public function adv(){
    	return $this->hasOne('App\Models\Advs','id','adv_id');
    }
}
