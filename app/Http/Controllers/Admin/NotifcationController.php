<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Notfs;
use App\Models\User;

use App\Models\Chat;

class NotifcationController extends Controller
{

    public function index(){
        $lists = User::whereNull('role_id')->orderBy('id','desc')->get();
    	return view('admin.notifcations.index',['users'=>$lists]);
    }

    public function store(Request $request){
        // dd($request->all());
        $request = request()->all();
        if(empty($request['user_id'])) {
            return redirect()->back()->with('error' , "برجاء تحديد الأعضاء");
        }
        if(in_array('0',$request['user_id'])) {
            $users = User::whereNull('role_id')->orderBy('id','desc')->get();
            foreach($users as $user) {
            	Chat::create([
            	        'from'      => \Auth::user()->id,
            	        'to'        => $user->id,
            	        'message'   => $request['message'],
            	    ]);
            }
        } else{
            foreach($request['user_id'] as $value) {
                Chat::create([
            	        'from'      => \Auth::user()->id,
            	        'to'        => $value,
            	        'message'   => $request['message'],
            	    ]);
            }
        }
    	return redirect()->back()->with('true' , "تم الإرسال بنجاح");
    }
}
