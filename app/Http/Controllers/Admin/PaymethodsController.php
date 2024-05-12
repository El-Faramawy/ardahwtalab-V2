<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Paymethods;

class PaymethodsController extends Controller {

    public function __construct() {
        $this->middleware('role:payments');
    }

    public function index() {
        return view('admin.paymethods.index', ['paymethods' => \App\Models\Paymethods::all()]);
    }

    public function create() {
        return view('admin.paymethods.create');
    }

    public function store(Request $request) {
        $data = $request->except('_token');
        $image = $request->file('image');
        $image ? $data['image'] = uploadImage($image) : $data['image'] = '';
        Paymethods::insert($data);
        return redirect()->route('paymethods.index', ['true' => 1]);
    }

    public function edit($id) {
        return view('admin.paymethods.edit', ['info' => Paymethods::find($id)]);
    }

    public function update(Request $request, $id) {
        $data = $request->except('_method', '_token');
        $image = $request->file('image');
        if ($image) {
            $data['image'] = uploadImage($image);
        } else {
            $data['image'] = '';
        }
        Paymethods::where('id', $id)->update($data);
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }

}
