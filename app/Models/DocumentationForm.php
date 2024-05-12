<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentationForm extends Model
{
    protected $table='documentation_form';

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'documentation_number',
        'image',
        'info',
        'status',
        'activeted',
        ];

    public function user(){
    	return $this->hasOne('App\Models\User','id','user_id');
    }

    public function catgeory(){
    	return $this->hasOne('App\Models\CategoryDocumentationForm','id','category_id');
    }

}
