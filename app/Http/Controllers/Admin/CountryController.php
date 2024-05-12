<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Country;
class CountryController extends Controller
{
    public function __construct(){
        $this->middleware('role:area');
    }
    public function index(){
    	return view('admin.country.index',['country'=>Country::all()]);
    }
    public function create(){
    	return view('admin.country.create');
    }
    public function store(Request $request){
    	$data=$request->except('_token');
    	Country::insert($data);
    	return redirect()->route('country.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit($id){
    	return view('admin.country.edit',['info'=>Country::find($id)]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_method','_token');
    	Country::where('id',$id)->update($data);
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
