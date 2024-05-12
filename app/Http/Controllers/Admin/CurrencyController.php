<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Currency;
class CurrencyController extends Controller
{
    public function __construct(){
        $this->middleware('role:currency');
    }
    public function index(){
    	return view('admin.currency.index',['currency'=>Currency::all()]);
    }
    public function create(){
    	return view('admin.currency.create');
    }
    public function store(Request $request){
    	$data=$request->except('_token');
    	Currency::insert($data);
    	return redirect()->route('currency.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit($id){
    	return view('admin.currency.edit',['info'=>Currency::find($id)]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_method','_token');
    	Currency::where('id',$id)->update($data);
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }
}
