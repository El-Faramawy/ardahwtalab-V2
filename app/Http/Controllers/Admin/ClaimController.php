<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Claims;

class ClaimController extends Controller {

    public function index() {
        // dd(Claims::all());
        return view('admin.advs.claims', ['claims' => Claims::all()]);
    }

}
