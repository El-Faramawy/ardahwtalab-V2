<?php

// namespace App\Http\Controllers\Admin;

// use App\Area;
// use Illuminate\Http\Request;

// use App\Http\Requests;
// use App\Http\Controllers\Controller;
// use App\LawCategory;
// use App\Lawsuit;
// use App\Lawyer;
// use DB;
// use Config;

// class LawsuitsController extends Controller
// {
//     private $country;
//     private $config;
//     private $sms;
//     public function __construct()
//     {
//         $this->country = \App\Country::orderBy('id', 'desc')->get();
//         $this->config = \App\SiteConfig::first();
//         $this->sms = \DB::table('site_sms')->first();
//         $this->middleware('role:lawsuits');
//     }
//     public function index()
//     {
//         return view('admin.lawsuits.index', ['rows' => Lawsuit::orderBy('id', 'desc')->get()]);
//     }
//     public function create()
//     {
//         $data = ['rows' => Lawsuit::all(), 'categories' => LawCategory::all()];
//         $data['areas'] = Area::where('country_id', '!=', null)->get();
//         return view('admin.lawsuits.create', $data);
//     }
//     public function store(Request $request)
//     {
//         $data = $request->except('_token');
//         $data['user_id'] = auth()->user()->id;
//         Lawsuit::create($data);
//         return redirect()->route('admin.lawsuits.index', ['true' => 1]);
//     }
//     public function edit($id)
//     {
//         $data = ['info' => Lawsuit::find($id), 'rows' => Lawsuit::all(), 'categories' => LawCategory::all()];
//         $data['areas'] = Area::where('country_id', '!=', null)->get();
//         return view('admin.lawsuits.edit', $data);
//     }
//     public function update(Request $request, $id)
//     {
//         $data = $request->except('_token', '_method');
//         Lawsuit::findOrFail($id)->update($data);
//         return redirect()->back()->with('true', "تم التعديل بنجاح");
//     }


//     public function lawyers($id)
//     {




//         $lawsuit = $data['lawsuit'] = Lawsuit::findOrFail($id);
//         if (request()->isMethod('get')) {





//              $lawyers                = Lawyer::whereStatus(1)->get();
//             $lawsuit_lawyers_ids    = $lawsuit->lawyers()->pluck('lawyers.id')->toArray();
//             $countries              = \App\Country::all();

//              $lawsuit_lawyers        = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->get();

//             return view('admin.lawsuits.lawyers', compact('lawsuit', 'lawyers', 'lawsuit_lawyers_ids','countries'));
//         } else {

//             $lawyers = request('lawyers');
//             if (is_array($lawyers) && !empty($lawyers)) {
//                 $lawsuit->lawyers()->sync($lawyers);
//                 $lawyers = Lawyer::whereIn('id', $lawyers)->get();
//                 $lawsuit->status = 'wait_lawyer_approve';
//                 $lawsuit->save();





//                 foreach ($lawyers as $lawyer) {
//                     $data['lawyer'] = $lawyer;
//                     // try {
//                         \Mail::send('emails.lawsuit', $data, function ($m) use ($lawyer) {
//                             $m->from($this->config->email, $this->config->title);
//                             $m->to($lawyer->email, $lawyer->fullname)->subject("طلب وساطة جديد");

//                         });






//                     // } catch (\Exception $e) { }
//                 }
//                 return back()->with('success', 'تم ارسال اشعار التعيين للمحامين بنجاح');
//             }
//         }
//         return back();
//     }


//     public function choose_lawyer($id)
//     {
//         $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
//         $lawsuit->update(['choose' => 1]);

//         return back()->with('success', 'تم إختيار المحامى بنجاح');
//     }

//     public function un_choose_lawyer($id)
//     {
//         $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
//         $lawsuit->update(['choose' => 0]);

//         return back()->with('success', 'تم إلغاء إختيار المحامى بنجاح');
//     }

//     public function approve_lawyer($id)
//     {
//         $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
//         $lawsuit->update(['approved' => 1]);
//         Lawsuit::find($lawsuit->first()->lawsuit_id)->update(['status' => 'wait_payment']);
//         $lawsuit_lawyer = $lawsuit->first();
//         $lawyer = Lawyer::find($lawsuit_lawyer->lawyer_id);
//         $lawsuit = $data['lawsuit'] = Lawsuit::find($lawsuit_lawyer->lawsuit_id);
//         $notfs['user_id'] = $lawsuit->user_id;
//         $notfs['link'] = route('lawsuits.index');
//         $notfs['text'] = "تم تعيين محامي لمتابعة الدعوى الخاصة بك يرجي الدفع للتواصل مع المحامي";
//         \App\Notfs::insert($notfs);

//         //Send mail
//         $data['lawyer'] = $lawyer;
//         $data['text']   = str_replace(['[NAME]','[EMAIL]'],[$lawyer->fullname,$lawyer->email],$this->config->appoint_msg);
//         \Mail::send('emails.lawsuit_approved' , $data , function($m) use($lawyer){
//             $m->from($this->config->email, $this->config->title);
//             $m->to($lawyer->email, $lawyer->fullname)->subject(" إشعار بإسناد طلب العميل");
//         });
//         \Mail::send('emails.appoint', $data, function ($m) use ($lawsuit) {
//             $m->from($this->config->email, $this->config->title);
//             $m->to($lawsuit->user->email, $lawsuit->user->username)->subject("إشعار بإسناد الطلب");
//         });

//         return back()->with('success', 'تم تعيين المحامى');
//     }
// }



namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LawCategory;
use App\Models\Lawsuit;
use App\Models\Lawyer;
use DB;
use Config;

class LawsuitsController extends Controller
{
    private $country;
    private $config;
    private $sms;
    public function __construct()
    {
        $this->country = \App\Models\Country::orderBy('id', 'desc')->get();
        $this->config = \App\Models\SiteConfig::first();
        $this->sms = \DB::table('site_sms')->first();
        $this->middleware('role:lawsuits');
    }
    public function index()
    {
        return view('admin.lawsuits.index', ['rows' => Lawsuit::orderBy('id', 'desc')->get()]);
    }
    public function create()
    {
        $data = ['rows' => Lawsuit::all(), 'categories' => LawCategory::all()];
        $data['areas'] = Area::where('country_id', '!=', null)->get();
        return view('admin.lawsuits.create', $data);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['user_id'] = auth()->user()->id;
        Lawsuit::create($data);
        return redirect()->route('lawsuits.index', ['true' => 1]);
    }
    public function edit($id)
    {
        $data = ['info' => Lawsuit::find($id), 'rows' => Lawsuit::all(), 'categories' => LawCategory::all()];
        $data['areas'] = Area::where('country_id', '!=', null)->get();
        return view('admin.lawsuits.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        Lawsuit::findOrFail($id)->update($data);
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }


    public function lawyers($id)
    {




        $lawsuit = $data['lawsuit'] = Lawsuit::findOrFail($id);
        if (request()->isMethod('get')) {





             $lawyers                = Lawyer::whereStatus(1)->get();
            $lawsuit_lawyers_ids    = $lawsuit->lawyers()->pluck('lawyers.id')->toArray();
            $countries              = \App\Country::all();

             $lawsuit_lawyers        = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->get();

            return view('admin.lawsuits.lawyers', compact('lawsuit', 'lawyers', 'lawsuit_lawyers_ids','countries'));
        } else {

            $lawyers = request('lawyers');
            if (is_array($lawyers) && !empty($lawyers)) {
                $lawsuit->lawyers()->sync($lawyers);
                $lawyers = Lawyer::whereIn('id', $lawyers)->get();
                $lawsuit->status = 'wait_lawyer_approve';
                $lawsuit->save();





                foreach ($lawyers as $lawyer) {
                    $data['lawyer'] = $lawyer;
                    // try {
                        \Mail::send('emails.lawsuit', $data, function ($m) use ($lawyer) {
                            // $m->from($this->config->email, $this->config->title);
                            $m->to($lawyer->email, $lawyer->fullname)->subject("طلب وساطة جديد");

                        });






                    // } catch (\Exception $e) { }
                }
                return back()->with('success', 'تم ارسال اشعار التعيين للمحامين بنجاح');
            }
        }
        return back();
    }


    public function choose_lawyer($id)
    {
        $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
        $lawsuit->update(['choose' => 1]);

        return back()->with('success', 'تم إختيار المحامى بنجاح');
    }

    public function un_choose_lawyer($id)
    {
        $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
        $lawsuit->update(['choose' => 0]);

        return back()->with('success', 'تم إلغاء إختيار المحامى بنجاح');
    }

    public function approve_lawyer($id)
    {
        $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
        $lawsuit->update(['approved' => 1]);
        Lawsuit::find($lawsuit->first()->lawsuit_id)->update(['status' => 'wait_payment']);
        $lawsuit_lawyer = $lawsuit->first();
        $lawyer = Lawyer::find($lawsuit_lawyer->lawyer_id);
        $lawsuit = $data['lawsuit'] = Lawsuit::find($lawsuit_lawyer->lawsuit_id);
        $notfs['user_id'] = $lawsuit->user_id;
        $notfs['link'] = route('lawsuits.index');
        $notfs['text'] = "تم تعيين محامي لمتابعة الدعوى الخاصة بك يرجي الدفع للتواصل مع المحامي";
        \App\Notfs::insert($notfs);

        //Send mail
        $data['lawyer'] = $lawyer;
        $data['text']   = str_replace(['[NAME]','[EMAIL]'],[$lawyer->fullname,$lawyer->email],$this->config->appoint_msg);
        \Mail::send('emails.lawsuit_approved' , $data , function($m) use($lawyer){
            // $m->from($this->config->email, $this->config->title);
            $m->to($lawyer->email, $lawyer->fullname)->subject(" إشعار بإسناد طلب العميل");
        });
        \Mail::send('emails.appoint', $data, function ($m) use ($lawsuit) {
            // $m->from($this->config->email, $this->config->title);
            $m->to($lawsuit->user->email, $lawsuit->user->username)->subject("إشعار بإسناد الطلب");
        });

        return back()->with('success', 'تم تعيين المحامى');
    }
}

