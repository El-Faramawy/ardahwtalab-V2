<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Peroids;
class PeroidsController extends Controller
{
    public function __construct(){
        $this->middleware('role:peroids');
    }
    public function index(){
    	return view('admin.peroids.index',['peroids'=>Peroids::all()]);
    }
    public function create(){
    	return view('admin.peroids.create',['peroids'=>Peroids::all()]);
    }
    public function store(Request $request){
    	$data=$request->except('_token');
    	Peroids::insert($data);
    	return redirect()->route('peroids.index',['true'=>"تم التعديل بنجاح"]);
    }
    public function edit($id){
    	return view('admin.peroids.edit',['info'=>Peroids::find($id)]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_token','_method');
    	Peroids::where('id',$id)->update($data);
    	return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
