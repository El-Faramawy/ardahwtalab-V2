<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model{
	protected $table='country';
    protected $guarded = ['id'];
	protected $hidden = ['created_at','updated_at'];

	// public function __construct(){
	// 	if(isset($this)){
	// 		// dd('000000000000000000');
	// 	}else{
	// 		dd('sssssssssss');
	// 	}
	// }

	public function advs(){
		return $this->hasMany('App\Models\Advs','country');
	}
	public function user(){
		return $this->hasMany('App\Models\User');
	}
	public function area(){
		return $this->hasMany('App\Models\Area');
	}


   // public static function first($columns = ['*'])
   //  {
   //  	dd('sssssssssssq');
   //      $results = $this->take(1)->get($columns);

   //      return count($results) > 0 ? reset($results) : null;
   //  }

}
?>
