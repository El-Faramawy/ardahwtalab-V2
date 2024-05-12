<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pages;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:pages');
    }
    public function index()
    {
        return view('admin.pages.index', ['pages' => Pages::all()]);
    }
    public function create()
    {
        return view('admin.pages.create', ['pages' => Pages::all()]);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data = array_filter($data);
        $data['slug'] = preg_replace('/\s+/', '-', $data['title']);
        Pages::insert($data);
        return redirect()->route('pages.index', ['true' => 1]);
    }
    public function edit($id)
    {
        $pg = Pages::find($id);
        $positions = explode(',', $pg->position);
        return view('admin.pages.edit', ['info' => $pg, 'positions' => $positions]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $data = array_filter($data);
        $data['slug'] = preg_replace('/\s+/', '-', $data['title']);
        Pages::where('id', $id)->update($data);
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }
}
