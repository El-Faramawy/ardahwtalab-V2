<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Depts;

class DeptsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:depts');
    }
    public function index()
    {
        if ($dept_id = request('dept_id')) {
            $depts =  Depts::where('parent_id', $dept_id)->get();
        } else {
            $depts = Depts::where('parent_id' , null)->get();
        }
        return view('admin.depts.index', compact('depts'));
    }
    public function create()
    {
        return view('admin.depts.create', ['depts' => Depts::all()]);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $image = $request->file('image');
        $data['parent_id'] = $data['parent_id'] == 0 ? null : $data['parent_id'];
        $image ? $data['image'] = $thisimg = uploadImage($image, 44, 44) : '';
        Depts::insert($data);
        return redirect()->route('depts.index', ['true' => 1]);
    }
    public function edit($id)
    {
        return view('admin.depts.edit', ['info' => Depts::find($id), 'depts' => Depts::all()]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $image = $request->file('image');
        $image ? $data['image'] = $thisimg = uploadImage($image, 44, 44) : '';
        $data['parent_id'] = $data['parent_id'] == 0 ? null : $data['parent_id'];
        Depts::where('id', $id)->update($data);
        return redirect()->back()->with('true', 'تم تعديل القسم بنجاح');
    }
}
