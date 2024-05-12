<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Jointypes;
class JointypesController extends Controller
{
    public function __construct(){
        $this->middleware('role:joins');
    }
    public function index(){
    	return view('admin.jointypes.index',['jointypes'=>Jointypes::all()]);
    }
    public function create(){
    	return view('admin.jointypes.create');
    }
    public function store(Request $request){
    	$data=$request->except('_token');
    	$data['rules']=implode(',', $data['rules']);
    	Jointypes::insert($data);
    	return redirect()->route('jointypes.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit($id){
        $join=Jointypes::find($id);
        $rules=explode(',',$join->rules);
    	return view('admin.jointypes.edit',['info'=>$join,'rules'=>$rules]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_method','_token');
    	$data['rules']=implode(',', $data['rules']);
    	Jointypes::where('id',$id)->update($data);
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
