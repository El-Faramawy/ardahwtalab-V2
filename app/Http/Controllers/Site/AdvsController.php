<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advs;
use App\Models\Advs_config;
use App\Models\Area;
use App\Models\Bids;
use App\Models\Claims;
use App\Models\Country;
use App\Models\Depts;
use App\Models\Images;
use App\Models\Likes;
use App\Models\Mediation;
use App\Models\Message;
use App\Models\Notfs;
use App\Models\Operations;
use App\Models\Props;
use App\Models\PropTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AdvsController extends Controller
{
    private $config;
    private $notfs;

    public function __construct()
    {
        $this->config = Advs_config::first();
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'remove']]);
        // $this->middleware('active', ['only' => ['create','update']]);
        $this->notfs = [];
    }

    public function index(Request $request)
    {

        $word = $request->input('keyword');
        $data['advs'] = Advs::where([['keywords', 'like', '%' . $word . '%'], ['active', '=', '1'], ['is_deleted', '=', 0]])->orWhere([['details', 'like', '%' . $word . '%'], ['active', '=', '1'], ['is_deleted', '=', 0]])->orWhere([['description', 'like', '%' . $word . '%'], ['active', '=', '1'], ['is_deleted', '=', 0]])->orderBy('id', 'desc')->paginate(request('perpage', 20));
        $data['title'] = 'الإعلانات المتعلقة ب' . $word;
        return view('site.advs', $data);
    }

    public function last()
    {
        if (request('keyword')) {
            $data['advs'] = Advs::where('keywords', 'like', '%' . request('keyword') . '%')
                ->where('active', 1)
                ->where('is_deleted', 0)
                ->orderBy('id', 'desc')
                ->paginate(request('perpage', 20));
        } elseif (request('dept')) {
            $data['advs'] = Advs::where(['dept' => request('dept'), 'active' => 1, 'is_deleted' => 0])
                ->orderBy('id', 'desc')
                ->paginate(request('perpage', 20));
        } else {
            $data['advs'] = Advs::where(['active' => 1, 'is_deleted' => 0])
                ->orderBy('id', 'desc')
                ->paginate(request('perpage', 20));
        }
        $data['title'] = 'أخر الاعلانات';
        return view('site.advs', $data);
    }

    public function country($country)
    {
        $data['title'] = $country;
        $data['advs'] = Country::where('name', $country)->first()->advs()->where('is_deleted', 0)->where('active', 1)->paginate(request('perpage', 20));
        return view('site.advs', $data);
    }

    public function area($area)
    {
        $data['title'] = $area;
        $data['advs'] = Area::where('name', $area)->first()->advs()->where('is_deleted', 0)->where('active', 1)->paginate($this->config->per_page);
        return view('site.advs', $data);
    }

    public function byLocation($country_id, $area_id)
    {
        $data['title'] = '';
        // $data['advs'] = Advs::where('country', $country_id)->where('area', $area_id)->paginate($this->config->per_page);
        $data['advs'] = Advs::where([['area', '=', $area_id], ['active', '=', '1'], ['is_deleted', '=', 0]])->orderBy('id', 'DESC')->paginate($this->config->per_page);
        return view('site.advs', $data);
    }

    public function cat($dept_id, $dept_name)
    {

        //d(request()->all());
        $data['title'] = request('keyword') && request('keyword') != '' ? request('keyword') : $dept_name;
        $dept = $data['current_dept'] = Depts::findOrFail($dept_id);
        $data['child_dept'] = $dept;

        $data['current_dept'] = $dept->parent ?? $dept;
        if (request('first')) {
            $data['areas'] = Area::where('country_id', '!=', null)->get();
            $data['depts'] = Depts::where('parent_id', null)->get();
            $data['advs'] = $dept->all_advs->where('is_deleted', 0)->where('active', 1)->paginate(24);
            return view('site.pages.search', $data);
        }

        $order_type = request('order_type');
        $data['advs'] = Advs::where('active', 1);
        if ($distance = request('distance')) {
            $lat = $this->getUserIP()[0];
            $lng = $this->getUserIP()[1];
            $data['advs'] = $data['advs']->GetByDistance($lat, $lng, $distance);
        }

        $data['advs'] = $data['advs']->where('dept', $dept->id)->orderBy('created_at', 'DESC');

        $data['advs_count'] = $data['advs']->count();
        $data['advs'] = $data['advs']->paginate($this->config->per_page);
        $data['areas'] = Area::where('country_id', '!=', null)->get();
        $data['depts'] = Depts::where('parent_id', null)->get();
        return view('site.pages.category', $data);
    }

    public function cats()
    {
        return view('site.advs.categories');
    }

    function print($id)
    {
        $info = Advs::findOrFail($id);
        return view('site.advs.print', compact('info'));
    }

    public function show($id, $title)
    {
        $info = Advs::where(['slug' => $title, 'id' => $id, 'active' => 1])->first();
        if (!$info) {
            return view('site.advs.inactive');
        }
        if (\Auth::user()) {
            if (is_null(Auth::user()->role_id)) {
                if ($info->is_deleted == 1) {
                    return view('site.advs.isdeleted');
                }
            }
        } else {
            if ($info->is_deleted == 1) {
                return view('site.advs.isdeleted');
            }
        }
        $info->keywords = explode(',', $info->keywords);
        $prr = [];
        if ($info->details != '') {
            $props = explode(',', $info->details);
            foreach ($props as $p) {
                $arr = explode('=', $p);
                $prr[] = ['name' => $arr[0], 'value' => $arr[1]];
            }
        }
        $info->props = $prr;
        if ($info->gettype) {
            if ($info->gettype->id == 2) {
                $bids = Bids::where('advs_id', $info->id)->count();
                $info->bid_users = [];
                $info->bid_high_price = '';
                if ($bids) {
                    $info->bid_users = Bids::where('advs_id', $info->id)->pluck('user_id')->toArray();
                    $info->bid_high_price = Bids::where('advs_id', $info->id)->orderBy('price', 'desc')->first()->price;
                }
            }
        }
        $output = [];
        if ($info->details != '') {
            $details = explode(',', $info->details);
            //dd($details);
            foreach ($details as $dd) {
                list($key, $value) = explode('=', $dd);
                $output[$key] = $value;
            }
        }


        $details = $output;
        $dts = [];
        foreach ($details as $key => $dt) {
            $dts[str_replace('_', ' ', $key)] = $dt;
        }
        $details = $dts;
        $info->details = $details;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $info->like_user = 0;
            in_array($user_id, $info->likes()->where('type', 1)->pluck('user_id')->toArray()) ? $info->like_user = 1 : '';
            $info->comment_user = 0;
            in_array($user_id, $info->comments()->pluck('user_id')->toArray()) ? $info->comment_user = 1 : '';
            $info->bid_user = 0;
            in_array($user_id, $info->bids()->pluck('user_id')->toArray()) ? $info->comment_user = 1 : '';
        }
        // require_once('googl-php-master/Googl.class.php');
        // $googl = new Googl('AIzaSyBNfUlqbTUtuFucA2UrR0osJL66qocFhIs');
        // $url=route('advertise.show',[$info->id,$info->slug]);
        // $info->url=$googl->shorten($url);
        // unset($googl);

        $data['info'] = $info;
        $data['title'] = $info->title;
        $data['others'] = Advs::where('dept', $info->dept)->where('id', '!=', $id)->where('active', 1)->take(3)->get();
        Advs::where(['id' => $id])->update(['views' => $info->views + 1]);

        return view('site.advs', $data);
    }

    public function republished($id)
    {
        if (\Auth::user()) {


            $adv = Advs::where(['id' => $id, 'active' => 1])->first();
            if (!$adv) {
                return view('site.advs.inactive');
            }
            if ($adv->user_id != Auth::user()->id) {
                return redirect()->back()->with('error', 'هذا الإعلان غير متوفر لديك');
            }

            if (is_null(Auth::user()->role_id)) {
                if ($adv->is_deleted == 1) {
                    return view('site.advs.isdeleted');
                }
            }


            $date1 = date('Y-m-d');
            $date2 = $adv->created_at->format('Y-m-d');
            $date1 = date_create($date1);
            $date2 = date_create($date2);
            $diff = date_diff($date1, $date2);
            if ($diff->days >= 3) {
                $array = $adv->toArray();
                unset($array['id']);
                unset($array['main_options']);
                unset($array['has_bids']);
                unset($array['created_at']);
                $array['options'] = json_encode($array['options']);
                // dd($array);
                $new = Advs::create($array);
                $images = Images::where(['adv_id' => $adv->id])->get();
                foreach ($images as $image) {
                    Images::create([
                        'adv_id' => $new->id,
//                        'image' => str_replace('https://ardhwatalab.com.sa/', '/', $image->image),
                        'image' => $image->getAttributes()['image'],
                    ]);
                    $image->delete();
                }
                $catgeories = $adv->catgeories()->pluck('dept_id')->toArray();
                $new->catgeories()->sync($catgeories);
                $adv->delete();

                return redirect()->route('advertise.show', [$new->id, $new->slug])->with('success', 'تم إعاده نشر الإعلان الخاص بك بنجاح');
            } else {
                return redirect()->back()->with('error', 'عفوا لا يمكن تحديث ورفع الاعلان قبل مرور ثلاثة أيام');
            }

        } else {
            return redirect()->back()->with('error', 'برجاء تسجيل الدخول أولا');
        }

    }

    public function create()
    {

        $data['depts'] = Depts::all();
        $data['country'] = Country::all();
        $data['types'] = Operations::all();
        $data['Message'] = Message::first();

        return view('site.advs.add', $data);
    }

    public function store(Request $request)
    {

        $data = $request->except('_token');
        // dd($data);
        $rules = [
            'title' => 'required',
            'dept' => 'required',
            //  'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

            // 'images.*' => 'max:2'
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = "";
            if ($errors->has('title')) {
                $msg .= "<li>عنوان الاعلان مطلوب</li>";
            }

            if ($errors->has('dept')) {
                $msg .= "<li>قسم الاعلان مطلوب</li>";
            }

            if ($errors->has('area')) {
                $msg .= "<li>منطقة الاعلان مطلوب</li>";
            }
            //   if ($errors->has('images')) {
            //     $msg .= "<li>مسموح تحميل 10 صور كحد أقصى</li>";
            // }

            return redirect()->back()->with('error', $msg);
        }

        // check for dept
        $Cdept = Depts::where(['id' => $data['dept']])->first();
        if (!is_null($Cdept)) {
            if ($Cdept->childs()->count() > 0) {
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
        $options = request('myoptions');
        $details = [];
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $key_name = Props::find($key)->name ?? '#';
                $details[] = $key_name . '=' . $value;
            }
            $info['options'] = json_encode($options);
            $info['details'] = implode(',', $details);
        }

        $info['active'] = '0';
        $info['user_id'] = Auth::user()->id;
        $info['slug'] = preg_replace('/\s+/', '-', $info['title']);
        $info['show_phone'] = request('show_phone');
        $adv_id = Advs::insertGetId($info);
        $adv = Advs::find($adv_id);
        // dd($images);

        if ($images) {
            foreach ($images as $img) {
                try {
                    $thisimg = uploadImage($img, 750, 500, true);
                    $thisimg != '' ? Images::insert(['adv_id' => $adv_id, 'image' => $thisimg]) : '';
                } catch (\Exception $e) {

                }
            }
        }
        $GetCategories = $this->GetCategories($info['dept']);
        $adv->catgeories()->sync($GetCategories);
        return redirect()->route('select.subscription', ['adv_id' => $adv_id]);
    }


    public function GetCategories($ID)
    {
        $array = [];
        $dept = Depts::find($ID);
        if (!is_null($dept)) {
            if ($dept->parent) {
                $arr = $this->GetParents($dept->parent);
                foreach ($arr as $v) {
                    $array[] = $v;
                }
            }
            $array[] = (int)$ID;
        }
        return $array;
    }

    public function GetParents($parent)
    {
        $arr = [];
        if ($parent->parent) {
            $x = $this->GetParents($parent->parent);
            foreach ($x as $c) {
                $arr[] = $c;
            }
        }
        $arr[] = $parent->id;
        return $arr;
    }


    public function edit(Request $request, $title)
    {
        $data['info'] = $info = Advs::where('id', $title)->first();
        $id = $data['info']->id;
        $data['info']->keywords = explode(',', $data['info']->keywords);
        if (Auth::user()->id != $data['info']->user_id) {
            return redirect()->route('advertise.show', $title);
        }

        $data['info'] = Advs::where('id', $title)->first();
        $details = (array)json_decode($data['info']->details);
        // dd($details);
        $details = array_filter(explode(',', $data['info']->details));
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
        $images = Images::where('adv_id', $id)->get();
        //location
        $data['country'] = Country::all();
        $data['area'] = Area::where('country_id', $data['info']->country)->get();
        //depts & props & types
        $data['depts'] = Depts::all();
        $props = Props::where(['dept_id' => $data['info']->dept, 'parent' => null])->get();
        $prop_keys = [];
        foreach ($props as $pr) {
            $prop_keys[] = $pr->name;
        }
        foreach ($details as $key => $dt) {
            $key = trim($key);
            if (in_array($key, $prop_keys)) {
                $prop = Props::where('name', $key)->first();
                if ($prop->input == 'input') {
                    $data['advs_details'][] = [$key => $dt, 'type' => 'input'];
                } else {
                    $others = PropTypes::where('name', $dt)->first();
                    if ($others) {
                        $others = PropTypes::where(['parent' => $others->parent, 'prop_id' => $others->prop_id])->get();
                        $data['advs_details'][] = [$key => $dt, 'others' => $others, 'type' => 'select'];
                    }
                }
            } else {
                $others = Props::where('name', $key)->first();
                if (!$others) {
                    $others = PropTypes::where('name', $key)->first();
                    if ($others) {
                        $others = PropTypes::where(['parent' => $others->parent, 'prop_id' => $others->prop_id])->get();
                        $data['advs_proptypes'][] = [$key => $dt, 'others' => $others, 'type' => 'input'];
                    }
                } else {
                    $others = PropTypes::where('prop_id', $others->id)->get();
                    $data['advs_proptypes'][] = [$key => $dt, 'others' => $others, 'type' => 'select'];
                }
            }
        }
        //servs & operations
        $data['types'] = Operations::all();
        $servs = Operations::find($data['info']->type);
        if ($servs) {
            $servs = explode(',', $servs->props);
            foreach ($servs as $sv) {
                $data['type_details'][] = [$sv => $data['info']->$sv];
            }
        }
        $data['type_keys'] = [
            'peroid' => 'مدة التجهيز',
            'price' => 'السعر',
            'start_price' => 'فتح المزاد بمبلغ',
            'end_date' => 'تاريخ انهاء المزاد',
        ];
        return view('site.advs.edit', $data);
    }

    public function update(Request $request, $id)
    {


        $advs = Advs::find($id);
        if (Auth::user()->id != $advs->user_id) {
            return redirect()->route('advertise.show', $advs->slug);
        }
        $data = $request->except('_token', '_method','images');
        $rules = ['title' => 'required', 'dept' => 'required'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = "";
            if ($errors->has('title')) {
                $msg .= "<li>عنوان الاعلان مطلوب</li>";
            }

            if ($errors->has('dept')) {
                $msg .= "<li>قسم الاعلان مطلوب</li>";
            }

            if ($errors->has('area')) {
                $msg .= "<li>منطقة الاعلان مطلوب</li>";
            }

            return redirect()->back()->with('error', $msg);
        }

        // check for dept
//        $Cdept = Depts::where(['id' => $data['dept']])->first();
//        if (!is_null($Cdept)) {
//            if ($Cdept->childs()->count() > 0) {
//                $msg = "<li>برجاء إدخال أخر قسم فرعي متاح لدينا</li>";
//                return redirect()->back()->with('error', $msg);
//            }
//        }


        $cols = DB::getSchemaBuilder()->getColumnListing('advs');
        foreach ($data as $key => $dt) {
            if (in_array($key, $cols)) {
                $info[$key] = $dt;
                unset($data[$key]);
            }
        }
//        $images = $data['images'];
//        unset($data['images']);
        $output = [];
        foreach ($data as $key => $dt) {
            $key = str_replace('_', ' ', $key);
            $output[$key] = $dt;
        }
        $data = $output;
        $options = request('myoptions');
        $details = [];
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $key_name = Props::find($key)->name ?? '#';
                $details[] = $key_name . '=' . $value;
            }
            $info['options'] = json_encode($options);
            $info['details'] = implode(',', $details);
        }
        $info['user_id'] = Auth::user()->id;
        $info['slug'] = preg_replace('/\s+/', '-', $info['title']);
        Advs::where('id', $id)->update($info);
        $adv = Advs::where('id', $id)->first();
        $adv_id = $adv->id;
        $info['id'] = $adv_id;
        if ($request->images) {
            foreach ($request->images as $img) {
                $thisimg = uploadImage($img, 750, 500, true);
                $thisimg != '' ? Images::insert(['adv_id' => $adv_id, 'image' => $thisimg]) : '';
            }
        }

        if ($request->show_phone == null) {
            Advs::where('id', $id)->update(['show_phone' => $request->show_phone]);


        } elseif ($request->show_phone == 1) {
            Advs::where('id', $id)->update(['show_phone' => $request->show_phone]);


        }

        $GetCategories = $this->GetCategories($info['dept']);
        $adv->catgeories()->sync($GetCategories);
        return redirect()->route('advertise.show', [$info['id'], $info['slug']])->with('confirm', 1);
    }

    public function claim(Request $request, $title, $comment = null)
    {
        if (!$request->except(['_token', 'comment'])) {
            return view('site.pages.claims', ['comment_id' => $comment]);
        }
        if ($request->has('comment')) {
            $data['comment_id'] = $request->input('comment');
        } else {
            $data['advs_id'] = Advs::where('slug', $title)->first()->id;
        }
        $data['created_at'] = date('Y-m-d h:i:s');
        $data['text'] = $request->input('text');
        $data['user_id'] = Auth::user()->id;
        // dd($data);
        Claims::insert($data);
        return redirect()->back()->with('message', 'تم ابلاغ المشرف');
    }

    public function median(Request $request)
    {
        if (!$request->except('_token')) {
            return view('site.pages.median');
        }
        $validator = Validator::make($request->all(), ['captcha' => 'captcha']);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'كلمة الكابتشا غير متطابقة');
        }
        $data = [];
        $advs = Advs::find($request->input('advs_id'));
        if (!$advs) {
            return redirect()->back()->with('error', 'هذا الاعلان غير موجود');
        }
        $data['advs_id'] = $advs->id;
        $data['created_at'] = date('Y-m-d h:i:s');
        Mediation::insert($data);
        return redirect()->back()->with('message', 'تم ارسال الطلب للمشرف');
    }

    public function like(Request $request, $id, $type)
    {
        $data = ['advs_id' => $id, 'user_id' => Auth::user()->id];
        $i = 0;
        if (Likes::where($data)) {
            $i = 1;
            Likes::where($data)->delete();
        }
        if ($type) {
            $advs = Advs::find($id);
            $this->notfs['user_id'] = $advs->user_id;
            $this->notfs['link'] = route('advertise.show', [$advs->id, $advs->slug]);
            $this->notfs['text'] = "أعجب <b>" . Auth::user()->username . "</b> ب <b>" . $advs->title . "</b>";
            Notfs::insert($this->notfs);
        }
        $data['type'] = $type;
        Likes::insert($data);
        $msg['likes'] = Likes::where(['advs_id' => $id, 'type' => 1])->count();
        $msg['dislikes'] = Likes::where(['advs_id' => $id, 'type' => 0])->count();
        return back();
    }

    public function actions(Request $request, $id, $slug)
    {
        $advs = Advs::where(['id' => $id, 'slug' => $slug])->first();
        $type = $request->input('type');
        if ($type == 'excellent') {
            $advs->excellent ? $data['excellent'] = 0 : $data['excellent'] = 1;
        }
        if ($type == 'close') {
            $advs->closed ? $data['closed'] = 0 : $data['closed'] = 1;
        }
        if ($type == 'refresh') {
            $data['created_at'] = date('Y-m-d h:i:s');
        }
        $advs->update($data);
        return redirect()->back();
    }

    public function destroy($slug, $id)
    {
        $advs = Advs::where(['id' => $id])->first();
        if (Auth::user()->id == $advs->user_id) {
            // $advs->delete();
            $advs->update(['is_deleted' => 1]);
        }
        return redirect()->route('users.show', Auth::user()->id);
    }

    public function requests()
    {
        $data['last_requests'] = Advs::where(['active' => 1, 'type' => 3])->paginate(25);
        return view('site.pages.requests', $data);
    }

    public function remove_image($id)
    {
        $img = Images::find($id);
        if ($img) {
            $advs = Auth::user()->advs()->find($img->adv_id);
            if ($advs) {
                Images::where('id', $id)->delete();
                return 1;
            }
        }
        return 0;
    }

    private function getUserIP()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        $geoIP = json_decode(file_get_contents("http://api.ipstack.com/{$ip}?access_key=c106ebe2f340b943b99a1e8b254e04f7"), true);
        $lat = $geoIP['latitude'] ?? 24.840;
        $lng = $geoIP['longitude'] ?? 46.649;
        // dd([$lat , $lng]);
        return [$lat, $lng];
    }

    public function remove($id)
    {
        $ad = auth()->user()->advs()->findOrFail($id);
        $ad->delete();
        return redirect()->to('/')->with('success', 'تم حذف الإعلان بنجاح');
    }


    public function complete($id)
    {
        $advs = Advs::where(['id' => $id])->first();
        if ($advs->user_id == auth()->user()->id) {
            $ad = $advs->update(['complete' => 1]);
            return redirect()->back();
        } else {
            return abort();
        }

    }


}
