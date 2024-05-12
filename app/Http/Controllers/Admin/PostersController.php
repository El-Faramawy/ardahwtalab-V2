<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Posters;
class PostersController extends Controller
{
    public function __construct(){
        $this->middleware('role:posters');
    }
    public function index(){
    	return view('admin.posters.index',['posters'=>\App\Models\Posters::all()]);
    }
    public function create(){
    	return view('admin.posters.create');
    }
    public function store(Request $request){
    	$data=$request->except('_token');
        $image=$request->file('image');
        if($request('position')=='left'){
            $image ? $data['image']=uploadImage($image,370,310) : '';
        }else{
            $image ? $data['image']=uploadImage($image,1184,363) : '';
        }
    	Posters::insert($data);
    	return redirect()->route('posters.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit($id){
    	return view('admin.posters.edit',['info'=>Posters::find($id)]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_method','_token');
        $image=$request->file('image');
        if($image){
            if(request('position')=='left'){
                $image ? $data['image']=uploadImage($image,370,310) : '';
            }else{
                $image ? $data['image']=uploadImage($image,1184,363) : '';
            }
        }
    	Posters::where('id',$id)->update($data);
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
