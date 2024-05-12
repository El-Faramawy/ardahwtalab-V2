<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Validator;
use Hash;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware('role:users');
    }
    public function index(Request $request){
        $process=$request->input('type');
        $users=User::where(['active'=>1,'block'=>"0"])->orderBy('id','desc')->get();
        if($process=='blacklist'){
            $users=User::where('block',"1")->orderBy('id','desc')->get();
        }
        if($process=='not-active'){
            $users=User::where(['active'=>0,'block'=>"0"])->orderBy('id','desc')->get();
        }
    	return view('admin.users.index',['users'=>$users]);
    }

    public function create(){
    	return view('admin.users.create',['roles'=>Roles::all()]);
    }

    public function store(Request $request){
    	$data=$request->except('_token');
        $rules=['confirm-password'=>'same:password'];
        $validator=Validator::make($data,$rules);
        if($validator->fails()){
            foreach($validator->messages() as $msg){
                return redirect()->back()->with('error',$msg);
            }
        }
        unset($data['confirm-password']);
    	$image = $request->file('image');
    	$image ? $data['image']=uploadImage($image) : '' ;
        $data['password']=Hash::make($data['password']);
        $data['active']=1;
        if($data['role_id']=='null')$data['role_id']=NULL;
    	User::insert($data);
    	return redirect()->route('admin.users.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit(Request $request,$id){
        $process=$request->input('process');
        if($process=='blacklist'){
            $user=User::where('id',$id)->first();
            if($user->block){
                User::where('id',$id)->update(['block'=>'0']);
            }else{
                User::where('id',$id)->update(['block'=>'1']);
            }
            return redirect()->back();
        }
        if($process=='active'){
            $user=User::where('id',$id)->first();
            if($user->active){
                User::where('id',$id)->update(['active'=>0]);
            }else{
                User::where('id',$id)->update(['active'=>1]);
            }
            return redirect()->back();
        }
    	return view('admin.users.edit',['info'=>User::find($id),'roles'=>Roles::all()]);
    }

    public function update(Request $request,$id){
    	$data=$request->except('_token','_method');
        if($request->has('password')){
            if($data['password']!='' || $data['password']!=' '){
                $rules=['confirm-password'=>'same:password'];
                $validator=Validator::make($data,$rules);
                if($validator->fails()){
                    foreach($validator->messages() as $msg){
                        return redirect()->back()->with('error',$msg);
                    }
                }
                $data['password']=Hash::make($request->password);
            }else{ unset($data['password']); }
        }else{
            unset($data['password']);
        }
        unset($data['confirm-password']);
    	$image = $request->file('image');
    	$image ? $data['image']=uploadImage($image) : '' ;
        if($data['role_id']=='null')$data['role_id']=NULL;
    	User::where('id',$id)->update($data);
    	return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }

    public function requests(Request $request){
        $data=$request->all();
        $info['requests']=\App\Models\Joins::orderBy('id','desc')->get();
        if(!$data){ return view('admin.users.requests.index',$info); }
        if(isset($data['view'])){
            $join=\App\Models\Joins::where('id',$data['view']);
            $join->update(['seen'=>1]);
            return view('admin.users.requests.show',['info'=>$join->first()]);
        }if(isset($data['action'])){
            $action=$data['action'];
            if($action=='approve'){
                $join=\App\Models\Joins::where('id',$data['request']);
                $join->update(['status'=>'تمت الموافقة']);
                \App\Models\User::where('id',$join->first()->user_id)->update(['type'=>$join->first()->type]);
            }
            if($action=='refuse'){
                $join=\App\Models\Joins::where('id',$data['request']);
                $join->update(['status'=>'تم الرفض']);
            }
            return redirect()->back();
        }
    }
}
