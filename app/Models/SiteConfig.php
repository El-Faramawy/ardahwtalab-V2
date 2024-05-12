<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    protected $table='site_config';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

    public function getLogoAttribute($logo){
        return $logo ? url('/').'/'.$logo : '';
    }
}
