<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sliders;

class SlidersController extends Controller {

    public function __construct() {
        $this->middleware('role:sliders');
    }

    public function index() {
        return view('admin.sliders.index', ['sliders' => \App\Models\Sliders::all()]);
    }

    public function create() {
        return view('admin.sliders.create');
    }

    public function store(Request $request) {
        $data = $request->except('_token');
        $image = $request->file('image');
        $image ? $data['image'] = uploadImage($image,1280,400) : '';
        Sliders::insert($data);
        return redirect()->route('sliders.index', ['true' => 1]);
    }

    public function edit($id) {
        return view('admin.sliders.edit', ['info' => Sliders::find($id)]);
    }

    public function destroy($id) {
        Sliders::destroy($id);
        return redirect()->back()->with('destroy-true', 1);
    }

    public function update(Request $request, $id) {
        $data = $request->except('_method', '_token');
        $image = $request->file('image');
        $image ? $data['image'] = uploadImage($image,1280,400) : '';
        Sliders::where('id', $id)->update($data);
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }

}
