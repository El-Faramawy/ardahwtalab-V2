<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryDocumentationForm extends Model
{
    protected $table='categories_documentation_form';

    protected $fillable = ['title'];

    public function forms(){
    	return $this->hasMany('App\Models\DocumentationForm','category_id','id');
    }


}
