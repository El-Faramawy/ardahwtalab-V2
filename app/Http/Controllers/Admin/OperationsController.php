<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Operations;
class OperationsController extends Controller
{
    public function index(){
    	return view('admin.operations.index',['operations'=>Operations::all()]);
    }
    public function create(){
    	return view('admin.operations.create',['operations'=>Operations::all()]);
    }
    public function store(Request $request){
    	$data=$request->except('_token');
        $request->has('props') ? $data['props']=implode(',', $data['props']) : '';
        Operations::insert($data);
    	return redirect()->route('operations.index',['true'=>"تم التعديل بنجاح"]);
    }
    public function edit($id){
        $op=Operations::find($id);
        $operations=explode(',',$op->props);
    	return view('admin.operations.edit',['info'=>$op,'operations'=>$operations]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_token','_method');
        $data['props']=implode(',', $data['props']);
        $request->has('home') ? '' : $data['home']=0;
    	Operations::where('id',$id)->update($data);
    	return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
