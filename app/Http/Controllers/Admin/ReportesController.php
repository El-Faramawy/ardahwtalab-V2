<?php

namespace App\Http\Controllers\Admin;

use App\Models\Depts;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Advs;
use App\Models\Lawsuit;

class ReportesController extends Controller
{
    public function users() {
        $users = new User;
        if(request()->has('from')) {
            $users = $users->whereBetween('created_at',[request('from'),request('to')]);
        }
        $data['lists'] = $users->orderBy('id','desc')->get();
        $data['counters'] = [
            [
                'title'=> 'المستخدمين',
                'count'=> $users->count(),
            ],
            [
                'title'=> 'المفعلين',
                'count'=> $users->where(['active'=>1])->count(),
            ],
            [
                'title'=> 'الغير مفعلين',
                'count'=> $users->where(['active'=>0])->count(),
            ],
            [
                'title'=> 'القائمة السوداء',
                'count'=> $users->where(['block'=>1])->count(),
            ],
        ];
        return view('admin.reports.users', get_defined_vars());
    }

    public function advs() {
        $adv = new Advs;
        if(request()->has('from')) {
            $adv = $adv->whereBetween('created_at',[request('from'),request('to')]);
            $ClaimsCount = \App\Models\Claims::where('advs_id', '!=', null)->whereBetween('created_at',[request('from'),request('to')])->count();
        } else {
            $ClaimsCount = \App\Models\Claims::where('advs_id', '!=', null)->count();
        }
        $data['lists'] = $adv->orderBy('id','desc')->get();
        $data['counters'] = [
            [
                'title' =>  "إجمالي مبالغ الإعلانات",
                'count' =>  $adv->sum('price') . ' ريال'
            ],
            [
                'title'=> 'الإعلانات المفعله',
                'count'=> $adv->count(),
            ],
            [
                'title'=> 'طلبات التفعيل',
                'count'=> $adv->where(['active'=>0])->count(),
            ],
            [
                'title'=> 'الإعلانات المبلغ عنها',
                'count'=> $ClaimsCount,
            ],
        ];
        return view('admin.reports.advs', get_defined_vars());
    }

    public function orders() {
        $lawsuit = new Lawsuit;
        if(request()->has('from')) {
            $lawsuit = $lawsuit->whereBetween('created_at',[request('from'),request('to')]);
        }
        $data['lists']    = $lawsuit->orderBy('id','desc')->get();
        $data['counters'] = [];
        return view('admin.reports.orders', get_defined_vars());
    }
}
