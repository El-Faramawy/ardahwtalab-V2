<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table='chats';
    protected $guarded = ['id'];
    public function fromuser(){
    	return $this->belongsTo('App\Models\User','form_id','id');
    }
    public function touser(){
    	return $this->belongsTo('App\Models\User','to_id','id');
    }

    public function getSentDateAttribute(){
        return date('Y-m-d' , strtotime($this->created_at));
    }
    public function getSentTimeAttribute(){
        return date('h:i a' , strtotime($this->created_at));
    }
}
