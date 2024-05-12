<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Models\Members;


class MembersController extends Controller
{
    public function CreateNew(Request $request){
        if($request->isMethod('post')){
           Members::create($request->all());
           return redirect()->back()->with('message','تم الحفظ بشكل سليم ');

        }else{
           return view('admin.members.create');
        }

    }

    public function ManageMember(){
        $rows = Members::all();
        return view('admin.members.index',['rows'=>$rows]);
    }

    public function EditMember(Request $request,$id){
        $Find = Members::find($id);
        if(isset($Find)){
            if($request->isMethod('post')){
                $Find->update($request->all());
                 return redirect()->back()->with('message','تم الحذف بشكل سليم ');

            }else{
               return view('admin.members.Edit',['data'=>$Find]);
            }

        }else{
            abort(404);
        }

    }

     public function RemoveMember(Request $request,$id){
        $Find = Members::find($id);
        if(isset($Find)){
            $Find->delete();
           return redirect()->back()->with('message','تم الحفظ بشكل سليم ');

        }else{
            abort(404);
        }

    }




}
