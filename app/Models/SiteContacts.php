<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContacts extends Model
{
    protected $table	= 'site_contacts';
    protected $guarded 	= ['id'];
	protected $hidden 	= ['created_at','updated_at'];
}
