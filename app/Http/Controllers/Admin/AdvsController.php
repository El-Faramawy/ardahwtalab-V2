<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advs_config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Advs;
use App\Models\Depts;
use DB;
use Auth;
use Watermark;
use Validator;
use App\Models\Props;
use Carbon\Carbon;

class AdvsController extends Controller
{

    private $config;

    public function __construct()
    {
        $this->config = Advs_config::first();
        $this->middleware('role:advs');
    }

    public function index(Request $request)
    {
        $type = $request->input('type');
        $info = [];
        if ($type == 'deleted') {
            $info = ['is_deleted' => 1];
        }
        if ($type == 'active') {
            $info = ['active' => 1,'is_deleted'=>0];
        }
        if ($type == 'not-active') {
            $info = ['active' => 0,'is_deleted'=>0];
        }
        if ($type == 'excellent') {
            $info = ['excellent' => 1,'is_deleted'=>0];
        }
        if ($type == 'report') {
            $claims = \App\Models\Claims::where('advs_id', '!=', null)->orderBy('id', 'desc')->get();
            $data['claims'] = [];
            foreach ($claims as $c) {
                $c->advs = Advs::find($c->advs_id);
                $c->user = \App\Models\User::find($c->user_id);
                $data['claims'][] = $c;
            }
            // dd($data);
            return view('admin.advs.claims', $data);
        }
        if ($type == 'report-comments') {
            $claims = \App\Models\Claims::where('comment_id', '!=', null)->orderBy('id', 'desc')->get();
            $data['claims'] = [];
            foreach ($claims as $c) {
                $c->comment = \App\Models\Comments::find($c->comment_id);
                $c->advs = Advs::find($c->comment->advs_id);
                $c->user = \App\Models\User::find($c->user_id);
                $data['claims'][] = $c;
            }
            // dd($data);
            return view('admin.advs.claims', $data);
        }
        if ($type == 'median') {
            $meds = \App\Models\Mediation::orderBy('id', 'desc')->pluck('advs_id')->toArray();
            $data['advs'] = Advs::whereIn('id', $meds)->orderBy('id', 'desc')->get();
            return view('admin.advs.index', $data);
        }
        // $date = Carbon::now()->addHour(10);
        $advs = count($info) ? Advs::where($info)->orderBy('id', 'desc')->get() : Advs::latest()->get();
        // dd($advs->first()->created_at ,$date );
        return view('admin.advs.index', ['advs' => $advs]);
    }

    public function create()
    {
        $data['depts'] = \App\Models\Depts::where('parent_id', null)->get();
        $data['country'] = \App\Models\Country::all();
        $data['types'] = \App\Models\Operations::all();
        return view('admin.advs.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $rules = ['title' => 'required', 'dept' => 'required', 'area' => 'required'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = "";
            if ($errors->has('title'))
                $msg .= "<li>عنوان الاعلان مطلوب</li>";
            if ($errors->has('dept'))
                $msg .= "<li>قسم الاعلان مطلوب</li>";
            if ($errors->has('area'))
                $msg .= "<li>منطقة الاعلان مطلوب</li>";
            return redirect()->back()->with('error', $msg);
        }

        // check for dept
        $Cdept = \App\Models\Depts::where(['id'=>$data['dept']])->first();
        if(!is_null($Cdept)) {
            if($Cdept->childs()->count() > 0){
                $msg = "<li>برجاء إدخال أخر قسم فرعي متاح لدينا</li>";
                return redirect()->back()->with('error', $msg);
            }
        }


        $cols = DB::getSchemaBuilder()->getColumnListing('advs');
        foreach ($data as $key => $dt) {
            $key = trim($key);
            if (in_array($key, $cols)) {
                $info[$key] = $dt;
                unset($data[$key]);
            }
        }
        $images = $data['images'];
        unset($data['images']);
        $output = [];
        foreach ($data as $key => $dt) {
            $key = str_replace('_', ' ', $key);
            $output[$key] = $dt;
        }
        $data = $output;
        $options = request('myoptions', []);
        $details = [];
        foreach ($options as $key => $value) {
            $key_name = Props::find($key)->name ?? '#';
            $details[] = $key_name . '=' . $value;
        }
        $info['options'] = json_encode($options);
        $info['details'] = implode(',', $details);
        $info['active'] = "1";
        $info['user_id'] = Auth::user()->id;
        $info['slug'] = preg_replace('/\s+/', '-', $info['title']);
        $adv_id = Advs::insertGetId($info);
        if ($images) {
            foreach ($images as $img) {
                if ($this->config->watermark) {
                    $thisimg = uploadImage($img, 750, 550, true);
                } else {
                    $thisimg = uploadImage($img, 750, 550, true);
                }
                $thisimg != '' ? \App\Models\Images::insert(['adv_id' => $adv_id, 'image' => $thisimg]) : '';
            }
        }
        // dd('11');
        return redirect()->route('admin.advs.index', ['true', 1]);
    }

    public function edit($id)
    {
        $data['info'] = Advs::find($id);
        $details = (array) json_decode($data['info']->details);
        // $data['info']->keywords=explode(',',$data['info']->keywords);
        if ($details) {
            $details = explode(',', $data['info']->details);
            $output = [];
            foreach ($details as $dd) {
                list($key, $value) = explode('=', $dd);
                $output[$key] = $value;
            }
            $details = $output;
            $dts = [];
            foreach ($details as $key => $dt) {
                $dts[str_replace('_', ' ', $key)] = $dt;
            }
            $details = $dts;
        }
        $images = \App\Models\Images::where('adv_id', $id)->get();
        //location
        $data['country'] = \App\Models\Country::all();
        $data['area'] = \App\Models\Area::where('country_id', $data['info']->country)->get();
        //depts & props & types
        $data['depts'] = \App\Models\Depts::where('parent_id', null)->get();
        $props = \App\Models\Props::where(['dept_id' => $data['info']->dept, 'parent' => null])->get();
        $prop_keys = [];
        foreach ($props as $pr) {
            $prop_keys[] = $pr->name;
        }
        foreach ($details as $key => $dt) {
            $key = trim($key);
            if (in_array($key, $prop_keys)) {
                $prop = \App\Models\Props::where('name', $key)->first();
                if ($prop->input == 'input') {
                    $data['advs_details'][] = [$key => $dt, 'type' => 'input'];
                } else {
                    $others = \App\Models\PropTypes::where('name', $dt)->first();
                    if ($others) {
                        $others = \App\Models\PropTypes::where(['parent' => $others->parent, 'prop_id' => $others->prop_id])->get();
                        $data['advs_details'][] = [$key => $dt, 'others' => $others, 'type' => 'select'];
                    }
                }
            } else {
                $others = \App\Models\Props::where('name', $key)->first();
                if (!$others) {
                    $others = \App\Models\PropTypes::where('name', $key)->first();
                    if ($others) {
                        $others = \App\Models\PropTypes::where(['parent' => $others->parent, 'prop_id' => $others->prop_id])->get();
                        $data['advs_proptypes'][] = [$key => $dt, 'others' => $others, 'type' => 'input'];
                    }
                } else {
                    $others = \App\Models\PropTypes::where('prop_id', $others->id)->get();
                    $data['advs_proptypes'][] = [$key => $dt, 'others' => $others, 'type' => 'select'];
                }
            }
        }
        //servs & operations
        $data['types'] = \App\Models\Operations::all();
        $servs = \App\Models\Operations::find($data['info']->type);
        $servs = isset($servs->props) ? explode(',', $servs->props) : [];
        foreach ($servs as $sv) {
            $data['type_details'][] = [$sv => $data['info']->$sv];
        }
        $data['type_keys'] = [
            'peroid' => 'مدة التجهيز',
            'price' => 'السعر',
            'start_price' => 'فتح المزاد بمبلغ',
            'end_date' => 'تاريخ انهاء المزاد',
        ];
        // dd($data);
        return view('admin.advs.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $rules = ['title' => 'required', 'dept' => 'required', 'area' => 'required'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = "";
            if ($errors->has('title'))
                $msg .= "<li>عنوان الاعلان مطلوب</li>";
            if ($errors->has('dept'))
                $msg .= "<li>قسم الاعلان مطلوب</li>";
            if ($errors->has('area'))
                $msg .= "<li>منطقة الاعلان مطلوب</li>";
            return redirect()->back()->with('error', $msg);
        }

        // check for dept
        $Cdept = \App\Models\Depts::where(['id'=>$data['dept']])->first();
        if(!is_null($Cdept)) {
            if($Cdept->childs()->count() > 0){
                $msg = "<li>برجاء إدخال أخر قسم فرعي متاح لدينا</li>";
                return redirect()->back()->with('error', $msg);
            }
        }


        $cols = DB::getSchemaBuilder()->getColumnListing('advs');
        foreach ($data as $key => $dt) {
            if (in_array($key, $cols)) {
                $info[$key] = $dt;
                unset($data[$key]);
            }
        }
        $images = $data['images'];
        unset($data['images']);
        $output = [];
        foreach ($data as $key => $dt) {
            $key = str_replace('_', ' ', $key);
            $output[$key] = $dt;
        }
        $data = $output;
        $options = request('myoptions', []);
        $details = [];
        foreach ($options as $key => $value) {
            $key_name = Props::find($key)->name ?? '#';
            $details[] = $key_name . '=' . $value;
        }
        $info['options'] = json_encode($options);
        $info['details'] = implode(',', $details);
        // $info['user_id'] = Auth::user()->id;
        $info['slug'] = preg_replace('/\s+/', '-', $info['title']);
        $adv_id = Advs::where('id', $id)->update($info);
        if ($images) {
            foreach ($images as $img) {
                if ($this->config->watermark) {
                    $thisimg = uploadImage($img, 400, 450, true);
                } else {
                    $thisimg = uploadImage($img);
                }
                $thisimg != '' ? \App\Models\Images::insert(['adv_id' => $id, 'image' => $thisimg]) : '';
            }
        }

        return redirect()->back()->with('true', "تم تعديل الإعلان بنجاح");
    }

    public function show(Request $request, $id)
    {
        if ($request->has('process')) {
            $process = $request->input('process');
            $advs = Advs::where('id', $id)->first();
            if ($process == 'active') {
                $advs->active ? $info['active'] = 0 : $info['active'] = 1;
            } elseif ($process == 'excellent') {
                $advs->excellent ? $info['excellent'] = 0 : $info['excellent'] = 1;
            }
            Advs::where('id', $id)->update($info);
            return back();
        }
        return redirect()->route('admin.advs.index', ['true' => 1]);
    }

    public function getDetails(Request $request)
    {
        $info = Advs::find(request('item_id')) ?? new Advs;
        if (request('item_id')) {
            $info = Advs::find(request('item_id'));
        }
        if ($request->has('dept') && request('dept') != '') {
            $super_parent = Depts::find($request->input('dept'))->super_parent;
            $props = \App\Models\Props::where(['dept_id' => $super_parent->id, 'parent' => NULL])->where('name' , "not like" , '%العمولة%')->orderBy('title_id', 'asc')->orderBy('id' , 'asc')->get();
            foreach ($props as $pr) {
                $pr->types = \App\Models\PropTypes::where('prop_id', $pr->id)->get();
            }
            // return $props;
            return view('ajax.details', ['props' => $props, 'dept' => Depts::find(request('dept')), 'info' => $info]);
        } elseif ($request->has('proptype')) {
            $parent = \App\Models\PropTypes::where('name', $request->input('proptype'))->first()->id;
            $data['proptypes'] = \App\Models\PropTypes::where('parent', $parent)->get();
            $proptype = \App\Models\PropTypes::where('parent', $parent)->first();
            $data['input'] = \App\Models\Props::find($proptype->prop_id);
            $data['info'] = $info;
            return view('ajax.details', $data);
        } elseif ($request->has('type')) {
            $servs = \App\Models\Operations::find($request->input('type'));
            // dd($servs);
            $servs = explode(',', $servs->props);
            // dd($servs);
            return view('ajax.details', ['servs' => $servs]);
        } elseif ($request->has('country')) {
            $area = \App\Models\Area::where('country_id', $request->input('country'))->get();
            return view('ajax.details', ['area' => $area]);
        }
    }

      public function getDetailsJson(Request $request)
    {
        $info = Advs::find(request('item_id')) ?? new Advs;
        if (request('item_id')) {
            $info = Advs::find(request('item_id'));
        }
        if ($request->has('dept') && request('dept') != '') {
            $super_parent = Depts::find($request->input('dept'))->super_parent;
            $props = \App\Models\Props::where(['dept_id' => $super_parent->id, 'parent' => NULL])->where('name' , "not like" , '%العمولة%')->orderBy('title_id', 'asc')->orderBy('id' , 'asc')->get();
            foreach ($props as $pr) {
                $pr->types = \App\Models\PropTypes::where('prop_id', $pr->id)->get();
            }
            // return $props;
            return json_encode( ['props' => $props, 'dept' => Depts::find(request('dept')), 'info' => $info]);
        } elseif ($request->has('proptype')) {
            $parent = \App\Models\PropTypes::where('name', $request->input('proptype'))->first()->id;
            $data['proptypes'] = \App\Models\PropTypes::where('parent', $parent)->get();
            $proptype = \App\Models\PropTypes::where('parent', $parent)->first();
            $data['input'] = \App\Models\Props::find($proptype->prop_id);
            $data['info'] = $info;
            return json_encode( $data);
        } elseif ($request->has('type')) {
            $servs = \App\Models\Operations::find($request->input('type'));
            // dd($servs);
            $servs = explode(',', $servs->props);
            // dd($servs);
            return view('ajax.details', ['servs' => $servs]);
        } elseif ($request->has('country')) {
            $area = \App\Models\Area::where('country_id', $request->input('country'))->get();
            return json_encode(['area' => $area]);
        }
    }


    public function rePublic(Advs $adv) {
        $adv->update([
            'is_deleted'=>0
            ]);
        return redirect()->back();
    }

    public function pdf(Advs $adv) {
        $data = [
              'رقم الإعلان'=>$adv->id,
              'صاحب الإعلان'=>$adv->user->username,
              'العنوان'=>$adv->title,
              'تفاصيل'=>$adv->details,
              'السعر'=>$adv->price,
              'القسم'=>$adv->getdept->name,
              'الدوله'=>$adv->getcountry->name,
              'المدينه'=>$adv->getarea->name,
              'العنوان'=>$adv->address,
              'خط الطول'=>$adv->lat,
              'خط العرض'=>$adv->lng,
              'تفاصيل إضافيه'=>$adv->description,
              'تاريخ النشر'=>$adv->created_at,
            ];
        return view('admin.pdf',['data'=>$data]);
    }
}
