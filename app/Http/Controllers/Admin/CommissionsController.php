<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CommissionReports;

class CommissionsController extends Controller {

    public function index() {
        $lists = CommissionReports::orderBy('id','desc')->get();
        \DB::table('commission_reports')->where('status','=',0)->update(['status'=>1]);
        return view('admin.commissions.index',['lists'=>$lists]);
    }

}
