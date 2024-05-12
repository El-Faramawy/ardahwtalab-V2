<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Roles;
class RolesController extends Controller
{
    public function __construct(){
        $this->middleware('role:users');
    }
    public function index(){
    	return view('admin.roles.index',['roles'=>Roles::all()]);
    }
    public function create(){
    	return view('admin.roles.create',['roles'=>Roles::all()]);
    }
    public function store(Request $request){
    	$data=$request->except('_token');
    	$data['roles']=implode(',',$data['roles']);
    	Roles::insert($data);
    	return redirect()->route('roles.index',['true'=>"تم التعديل بنجاح"]);
    }
    public function edit($id){
    	$roles=Roles::find($id);
    	return view('admin.roles.edit',['info'=>$roles,'roles'=>explode(',', $roles->roles)]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_token','_method');
    	$data['roles']=implode(',',$data['roles']);
    	Roles::where('id',$id)->update($data);
    	return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
