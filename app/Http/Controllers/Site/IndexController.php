<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Depts;
use App\Models\Advs;
use App\Models\User;
use App\Models\Area;
use App\Models\Images;
use App\Models\Advs_config;
use App\Models\Pages;
use Auth;
use Config;
use DB;
use Carbon\Carbon;
use App\Models\Subscription;

class IndexController extends Controller
{

    public function home(Request $request)
    {
        // dd(url()->previous());
        if (isset ($request->session()->all()['commision_store'] )){
        $adv = Advs::findOrFail($request->session()->all()['commision_store']['adv_id']);

        $adv->update([
            'active' => 1 ,
            'subscription_id' => $request->session()->all()['commision_store']['subscription_id'] ,
            'end_date' => Carbon::parse($adv->created_at)->addHour(Subscription::find($request->session()->all()['commision_store']['subscription_id'])->duration) ,
            ]);

            // dd("this ok");
            $data['areas']  = Area::where('country_id', '!=', null)->get();
        $data['depts'] = Depts::where('parent_id', null)->get();
        $data['advs'] = Advs::where(['active' => 1,'is_deleted'=>0])
            ->orderBy('id', 'desc')
            ->paginate(request('perpage' , 20));
        $data['advs_count'] = Advs::where(['active' => 1])->count();
        return view('site.pages.home', $data)->with('success', 'تم نشر الاعلان بنجاح');
        }
        $data['areas']  = Area::where('country_id', '!=', null)->select('id','name')->get();
        $data['depts'] = Depts::where('parent_id', null)->select('id','name')->get();
        $data['advs'] = Advs::where(['active' => 1,'is_deleted'=>0])
            ->orderBy('id', 'desc')
            // ->select('id','price','show_phone','complete','created_at','title','description','slug')
            ->paginate(request('perpage' , 20));
        $data['advs_count'] = Advs::where(['active' => 1])->count();

        return view('site.pages.home', $data);
    }

    public function page($id, $slug)
    {
        $info['page'] = Pages::findOrFail($id);
        return view('site.pages.page', $info);
    }

    public function blacklist(Request $request)
    {
        $word = $request->input('word');
        if ($word) {
            $data['user'] = User::where(['block' => 1, 'username' => $word])->orWhere(['block' => 1, 'email' => $word])->orWhere(['block' => 1, 'phone' => $word])->first();
            return view('site.pages.blacklist', $data);
        }
        return view('site.pages.blacklist');
    }
}
