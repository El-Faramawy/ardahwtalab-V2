<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Area;
class AreaController extends Controller
{
    private $country;
    public function __construct(){
            $this->country=\App\Models\Country::orderBy('id','desc')->get();
            $this->middleware('role:area');
    }
    public function index(){
    	return view('admin.area.index',['area'=>\App\Models\Area::orderBy('id','desc')->get()]);
    }
    public function create(){
    	return view('admin.area.create',['country'=>$this->country]);
    }
    public function store(Request $request){
    	$data=$request->except('_token');
    	Area::insert($data);
    	return redirect()->route('area.index',['true'=>"تم التعديل بنجاح"]);
    }

    public function edit($id){
    	return view('admin.area.edit',['info'=>Area::find($id),'country'=>$this->country]);
    }
    public function update(Request $request,$id){
    	$data=$request->except('_method','_token');
    	Area::where('id',$id)->update($data);
        return redirect()->back()->with('true' , "تم التعديل بنجاح");
    }

    public function getDetails(Request $request){
        if($request->has('dept')){
            $props=\App\Props::where('dept_id',$request->input('dept'))->get();
            foreach($props as $pr){
                $pr->parent ? '' : $pr->types=\App\PropTypes::where('prop_id',$pr->id)->get();
            }
            return view('ajax.details',['props'=>$props]);
        }elseif($request->has('prop')){
            $types=\App\PropTypes::where('prop_id',$request->input('prop'))->get();
            return view('ajax.details',['types'=>$types]);
        }
    }
}
