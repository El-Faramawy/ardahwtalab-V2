<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LawCategory;

class LawCategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('role:law_categories');
    }
    public function index(){
    	return view('admin.law_categories.index',['rows'=>LawCategory::orderBy('id','desc')->get()]);
    }
    public function create(){
    	return view('admin.law_categories.create',['rows'=>LawCategory::where('parent_id' , 0)->get()]);
    }
    public function store(Request $request){
    	$data=$request->except('_token');
        LawCategory::create($data);
    	return redirect()->route('law_categories.index',['true'=>"تم التعديل بنجاح"]);
    }
    public function edit($id){
        return view('admin.law_categories.edit',['info'=>LawCategory::find($id),'rows'=>LawCategory::where('parent_id' , 0)->get()]);
    }
    public function update(Request $request,$id){
        $data=$request->except('_token','_method');
        LawCategory::findOrFail($id)->update($data);
    	return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
