<?php

namespace App\Http\Controllers\Admin;

use App\Models\Depts;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Props;
use App\Models\PropTypes;
use Validator;

class PropsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:depts');
    }
    public function index()
    {
        return view('admin.props.index', [
            'props' => Props::orderBy('dept_id')->orderBy('title_id', 'asc')->orderBy('id', 'asc')->get()
        ]);
    }
    public function create()
    {
        return view('admin.props.create', ['depts' => \App\Models\Depts::all()]);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, ['dept_id' => 'required']);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'يجب اختيار القسم');
        }
        $info['name'] = trim($data['name']);
        $data['parent'] ?  $info['parent'] = $data['parent'] : '';
        $info['dept_id'] = $data['dept_id'];
        $info['title_id'] = $data['title_id'] ?? null;
        $info['input'] = $data['input'];
        $info['icon'] = $data['icon'] ?? null;
        $info['main'] = $data['main'];
        $prop_id = Props::insertGetId($info);
        $i = 0;
        foreach ($data['props'] as $pr) {
            $info = [];
            if ($data['props'][$i] && $data['props'][$i] != '') {
                $info['prop_id'] = $prop_id;
                $request->has('type') ? $data['type'][$i] ? $info['parent'] = $data['type'][$i] : '' : '';
                $info['name'] = trim($data['props'][$i]);
                $image = $data['images'][$i];
                $image ? $info['image'] = uploadImage($image) : '';
                \App\PropTypes::insert($info);
            }
            $i++;
        }
        return redirect()->route('props.index', ['true' => 1]);
    }
    public function edit(Request $request, $id)
    {
        $data['info'] = Props::find($id);
        if ($request->input('type') == 'main') {
            $dept = $data['info']->dept_id;
            $main = Props::where('id', $id)->first()->main;
            $main ? $main = 0 : $main = 1;
            // Props::where('id','>',0)->where('dept_id',$dept)->update(['main'=>0]);
            Props::where('id', $id)->first()->update(['main' => $main]);
            return redirect()->back();
        }
        $data['props'] = Props::all();
        $data['depts'] = \App\Depts::all();
        $data['mainprops'] = \App\Props::where('dept_id', $data['info']->dept_id)->get();
        if ($data['info']->parent) {
            $data['proptypes'] = PropTypes::where('prop_id', $data['info']->parent)->get();
        } else {
            $data['propalltypes'] = PropTypes::where('prop_id', $data['info']->id)->get();
        }
        $data = (object) $data;
        return view('admin.props.edit', ['data' => $data]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $info['name'] = trim($data['name']);
        $data['parent'] ?  $info['parent'] = $data['parent'] : '';
        $info['dept_id'] = $data['dept_id'];
        $info['title_id'] = $data['title_id'] ?? null;
        $info['input'] = $data['input'];
        $info['icon'] = $data['icon'] ?? null;
        $info['main'] = $data['main'];
        Props::where('id', $id)->update($info);
        $prop_id = $id;
        $i = 0;
        if (isset($data['props'])) {
            foreach ($data['props'] as $pr) {
                $info = [];
                if ($data['props'][$i] && $data['props'][$i] != '') {
                    $info['prop_id'] = $prop_id;
                    if ($request->has('type')) {
                        $data['type'][$i] ? $info['parent'] = $data['type'][$i] : '';
                    }
                    $info['name'] = trim($data['props'][$i]);
                    $image = $data['images'][$i];
                    $image ? $info['image'] = uploadImage($image) : '';
                    if ($data['ids'][$i]) {
                        \App\PropTypes::where('id', $data['ids'][$i])->update($info);
                    } else {
                        \App\PropTypes::insert($info);
                    }
                }
                $i++;
            }
        }
        return redirect()->back()->with(['true' => 1]);
    }
    public function getProps(Request $request)
    {
        if ($request->has('prop')) {
            $prop = $request->input('prop');
            $props = PropTypes::where('prop_id', $prop)->get();
            return view('admin.ajax.props', ['props' => $props]);
        }
        $dept = $request->input('dept');
        $props = Props::where('dept_id', $dept)->get();
        return view('admin.ajax.mainprops', ['props' => $props]);
    }

    public function getTitles()
    {
        $dept = Depts::find(request('dept'));
        $html = '';
        foreach ($dept->titles as $title) {
            $html .= "<option value='{$title->id}'>{$title->name}</option>";
        }
        return $html;
    }
    public function delPropTypes(Request $request)
    {
        $id = $request->input('id');
        \App\PropTypes::where('id', $id)->delete();
        return 1;
    }
}
