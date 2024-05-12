<?php

namespace App\Http\Controllers\Admin;

use App\Models\Depts;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Titles;
use Validator;

class TitlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:depts');
    }
    public function index()
    {
        return view('admin.titles.index', ['titles' => Titles::orderBy('dept_id')->get()]);
    }
    public function create()
    {
        return view('admin.titles.create', ['depts' => \App\Models\Depts::where('parent_id' , null)->get()]);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, ['dept_id' => 'required']);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'يجب اختيار القسم');
        }
        $info['name'] = trim($data['name']);
        $info['dept_id'] = $data['dept_id'];
        $prop_id = Titles::insertGetId($info);
        return redirect()->route('props.index', ['true' => 1]);
    }
    public function edit(Request $request, $id)
    {
        $data['info'] = Titles::find($id);
        $data['depts'] = \App\Depts::where('parent_id' , null)->get();
        $data = (object) $data;
        return view('admin.titles.edit', ['data' => $data]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $info['name'] = trim($data['name']);
        $info['dept_id'] = $data['dept_id'];
        Titles::where('id', $id)->update($info);
        return redirect()->back()->with(['true' => 1]);
    }
}
