<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryDocumentationForm;

class DocumentationCatgeoryController extends Controller
{

    public function index(){
        $lists = CategoryDocumentationForm::orderBy('id','desc')->get();
    	return view('admin.documentation.category.index',['lists'=>$lists]);
    }

    public function create(){
    	return view('admin.documentation.category.create');
    }

    public function store(Request $request){
    	CategoryDocumentationForm::create(request()->all());
    	return redirect()->route('documentation.category.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit(Request $request,CategoryDocumentationForm $category){
    	return view('admin.documentation.category.edit',['info'=>$category]);
    }

    public function update(Request $request,CategoryDocumentationForm $category){
    	$category->update(request()->all());
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }

}
