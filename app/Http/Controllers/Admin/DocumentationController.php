<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DocumentationForm;

class DocumentationController extends Controller
{

    public function index(){
        $lists = DocumentationForm::orderBy('id','desc')->get();
    	return view('admin.documentation.index',['lists'=>$lists]);
    }

    public function create(){
    	return view('admin.documentation.create');
    }

    public function store(Request $request){
    	DocumentationForm::create(request()->all());
    	return redirect()->route('documentation.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function show(Request $request,DocumentationForm $documentation){
        $documentation->update([
            'status'    => 1
            ]);
    	return view('admin.documentation.show',['info'=>$documentation]);
    }

    public function edit(Request $request,DocumentationForm $documentation){
        $documentation->update([
            'status'    => 1
            ]);
    	return view('admin.documentation.edit',['info'=>$documentation]);
    }

    public function update(Request $request,DocumentationForm $documentation){
        $request = request()->all();
        if(request()->file('image')) {
            $request['image'] = uploadImage($request['image']);
        }
    	$documentation->update($request);
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }

    public function activeted(Request $request,DocumentationForm $documentation){
    	$documentation->update([
    	    'activeted' =>  1
    	    ]);
    	\App\User::where(['id'=>$documentation->user_id])->update(['active'=>1]);
        return redirect()->back()->with('true' , "تم تفعيل الوثيقة بنجاح");
    }

}
