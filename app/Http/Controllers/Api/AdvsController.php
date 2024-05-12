<?php

namespace App\Http\Controllers\Api;

use App\Advs;
use App\Depts;
use App\Http\Controllers\Controller;
use App\Likes;
use App\Props;
use Auth;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

//use Response;
class AdvsController extends Controller
{

    private $notfs;
    public $json_arr;
    public $api_config;

    public function __construct()
    {
        $this->notfs = [];
        $this->json_arr['message'] = 'success';
        $this->json_arr['code'] = 1;
        $this->api_config = \App\Advs_config::first();
    }

    public function last(Request $request, $type = null)
    {
        $where = [];
        if ($type == 'sale') {
            $where['type'] = 1;
        } elseif ($type == 'buy') {
            $where['type'] = 3;
        } elseif ($type == 'bid') {
            $where['type'] = 2;
        }
        if ($request->has('area_id')) {
            $where['area'] = $request->input('area_id');
        }
        if ($request->has('dept_id')) {
            $where['dept'] = $request->input('dept_id');
        }
        $advs = new Advs;
        if ($request->has('word')) {
            $advs = $advs->where('title', 'like', '%' . request('word') . '%')->orWhere('details', 'like', '%' . request('word') . '%');
        }
        if (count($where)) {
            $advs = $advs->where($where);
        }
        $data = $advs->where('is_deleted',0)->orderBy('id', 'desc')->paginate(7);
        foreach ($data as $dt) {
            $dt = $this->show_advs_data($dt);
        }
        $this->json_arr['data']['advs'] = [];
        foreach ($data as $da) {
            $this->json_arr['data']['advs'][] = $da;
        }
        $this->json_arr['data']['subcategories'] = Depts::find(request('dept_id')) ? Depts::find(request('dept_id'))->childs()->get() : [];
        $this->json_arr['pagnation'] = api_model_set_pagenation($data);
        empty($this->json_arr['data']) ? $this->json_arr['data'] = [] : '';
        return Response::json($this->json_arr);

        empty($this->json_arr['data']) ? $this->json_arr['data'] = [] : '';
        return Response::json($this->json_arr);
    }
    
    
    
     public function republished($id) {
        $adv = Advs::where(['id' => $id])->first();
        if (is_null($adv)) {
            return view('site.advs.inactive');
        }
        if ($adv->active != 1) {
            $message = "هذا الإعلان غير مفعل";
            return Response::json(['message' => $message, 'code' => 0]);
        }
        $user_id = \App\User::where('api_token', request('api_token'))->first()->id;
        if($adv->user_id != $user_id) {
            $message = "هذا الإعلان غير متوفر لديك";
            return Response::json(['message' => $message, 'code' => 0]);
        }
        $date1  =   date('Y-m-d');
        $date2  =   $adv->created_at->format('Y-m-d');
        $date1  =   date_create($date1);
        $date2  =   date_create($date2);
        $diff   =   date_diff($date1,$date2);
        if($diff->days >= 3) {
            $array = $adv->toArray();
            unset($array['id']);
            unset($array['main_options']);
            unset($array['has_bids']);
            unset($array['created_at']);
            $array['options'] = json_encode($array['options']);
            // dd($array);
            $new = Advs::create($array);
            $images = \App\Images::where(['adv_id'=>$adv->id])->get();
            foreach($images as $image) {
                \App\Images::create([
                        'adv_id'    =>  $new->id,
                        'image'     =>  str_replace('https://ardhwatalab.com.sa/','/',$image->image),
                    ]);
                $image->delete();
            }
            $catgeories = $adv->catgeories()->pluck('dept_id')->toArray();
            $new->catgeories()->sync($catgeories);
            $adv->delete();
            $message = "تم إعاده نشر الإعلان الخاص بك بنجاح";
            return Response::json(['message' => $message, 'code' => 1]);
        } else {
            $message = "عفوا لا يمكن تحديث ورفع الاعلان قبل مرور ثلاثة أيام";
            return Response::json(['message' => $message, 'code' => 0]);
        }
    }

    public function create()
    {
        $rules = ['title' => 'required', 'dept' => 'required', 'area' => 'required'];
        $data = request()->except('api_token');
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('title')) {
                $message = "عنوان الاعلان مطلوب";
            }

            if ($errors->has('dept')) {
                $message = "قسم الاعلان مطلوب";
            }

            if ($errors->has('area')) {
                $message = "منطقة الاعلان مطلوب";
            }

            //if($errors->has('images'))$message="صور الاعلان مطلوب";
            return Response::json(['message' => $message, 'code' => 0]);
        }
        $cols = DB::getSchemaBuilder()->getColumnListing('advs');
        foreach ($data as $key => $dt) {
            $key = trim($key);
            if (in_array($key, $cols)) {
                $info[$key] = $dt;
                unset($data[$key]);
            }
        }
        if (isset($data['images'])) {
            $images = $data['images'];
        }
        // dd($images);
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
        $info['active'] = 1;
        $info['user_id'] = \App\User::where('api_token', request('api_token'))->first()->id;
        $info['slug'] = preg_replace('/\s+/', '-', $info['title']);
        $info['show_phone'] = request('show_phone');
        // dd($images);
        //images test
        $adv_id = Advs::insertGetId($info);
        if (isset($images)) {
            foreach ($images as $img) {
                $thisimg = '/' . uploadBaseImage($img);
                $thisimg != '' ? \App\Images::insert(['adv_id' => $adv_id, 'image' => $thisimg]) : '';
            }
        }
        $data = Advs::find($adv_id);
        $GetCategories = $this->GetCategories($info['dept']);
        $data->catgeories()->sync($GetCategories);
        return Response::json(['message' => 'success', 'code' => 1, 'data' => $data]);
    }

    public function GetCategories($ID) {
        $array   = [];
        $dept = \App\Depts::find($ID);
        if(!is_null($dept)) {
            if($dept->parent) {
                $arr = $this->GetParents($dept->parent);
                foreach($arr as $v) {
                    $array[] = $v;
                }
            }
            $array[] = (int)$ID;
        }
        return $array;
    }
    
    public function GetParents($parent) {
        $arr = [];
        if($parent->parent) {
            $x = $this->GetParents($parent->parent);
            foreach($x as $c) {
                $arr[] = $c;
            }
        }
        $arr[] = $parent->id;
        return $arr;
    }


    public function getInfo(Request $request)
    {
        if (!$request->has('advs_id')) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = 'advs_id is required';
        } else {
            $data = Advs::find($request->input('advs_id'));
            if (!$data) {
                $this->json_arr['code'] = 2;
                $this->json_arr['message'] = 'advertise not found';
            } else {
                $data = $this->show_advs_data($data);
                $this->json_arr['data'] = $data;
            }
            // $data->update(['views' => $data->views + 1]);
        }
        return Response::json($this->json_arr);
    }

    public function actions(Request $request, $action)
    {
        $data = $request->except('api_token');
        //$user=\App\User::where('api_token',$request('api_token'))->first();
        $user = \App\User::where('api_token', $request->input('api_token'))->first();

        if (!$request->has('advs_id')) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = 'advs_id required';
        } // elseif(!$request->has('user_id')){ $this->json_arr['code']=0; $this->json_arr['message']='user_id required'; }
        else {
            //like ----- dislike
            $advs = Advs::find($data['advs_id']);
            if ($action == 'like' || $action == 'dislike') {
                $i = 0;
                $type = 0;
                if (Likes::where($data)) {
                    $i = 1;
                    Likes::where($data)->delete();
                }
                if ($action == 'like') {
                    $type = 1;
                    $this->notfs['user_id'] = $advs->user_id;
                    $this->notfs['link'] = route('advertise.show', [$advs->id, $advs->slug]);
                    $this->notfs['text'] = "أعجب <b>" . $user->username . "</b> ب <b>" . $advs->title . "</b>";
                    \App\Notfs::insert($this->notfs);
                }
                $data['type'] = $type;
                Likes::insert($data);
                $info['likes'] = Likes::where(['advs_id' => $data['advs_id'], 'type' => 1])->count();
                $info['dislikes'] = Likes::where(['advs_id' => $data['advs_id'], 'type' => 0])->count();
                $this->json_arr['data'] = $info;
            } //comment
            elseif ($action == 'comment') {
                if (!isset($data['comment'])) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = 'comment required';
                } else {
                    \App\Comments::insert($data);
                    $this->notfs['user_id'] = $advs->user_id;
                    $this->notfs['link'] = route('advertise.show', [$advs->id, $advs->slug]);
                    $this->notfs['text'] = "علق <b>" . $user->username . "</b> على <b>" . $advs->title . "</b>";
                    \App\Notfs::insert($this->notfs);
                }
            } elseif ($action == 'claim') {
                if (!isset($data['text'])) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = 'text required';
                } else {
                    \App\Claims::insert($data);
                }
            } elseif ($action == 'bid') {
                if (!request()->has('price') || !request()->has('details') || !request()->has('advs_id')) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = 'details and price required';
                } else {
                    $advs = Advs::find($data['advs_id']);
                    if ($data['price'] < $advs->start_price) {
                        return Response::json(['message' => 'السعر المدخل أقل من سعر بداية المزاد', 'code' => '0']);
                    }
                    $data['user_id'] = $user->id;
                    \App\Bids::insert($data);
                }
            } else {
                $this->json_arr['code'] = 0;
                $this->json_arr['message'] = 'please insert valid action';
            }
        }
        return Response::json($this->json_arr);
    }

    public function show_advs_data($data)
    {

        $data->gettype ? $data->type = $data->gettype()->first()->name : $data->type = '';
        $output = [];
        if ($data->details != '' && $data->details != ' ') {
            $details = explode(',', $data->details);
            foreach ($details as $dd) {
                list($key, $value) = explode('=', $dd);
                $output[$key] = $value;
            }
        }
        $data->user = $data->user()->first(['id', 'phone', 'username', 'image','online']);
        $data->user->image = url('/') . '/' . $data->user->image;
        $data->user->check_documentation = $data->user->check_doc;
        
        $rates = \App\Rates::where('user_rated',$data->user->id)->count();
        $rate  = \App\Rates::where('user_rated',$data->user->id)->sum('rate');
        if($rates == 0) {
            $data->user->rate = 0;
        } else {
            $data->user->rate = $rate / $rates;    
        }
        
        
        $data->details = $output;
        $data->main_options = $data->main_options;
        $dept = $data->getdept()->first();
        $data->dept = $dept->name;
        $data->dept_id = $dept->id;

        $country = $data->getcountry()->first();
        $data->country = $country->name;
        $data->country_id = $country->id;

        $area = $data->getarea()->first();
        $data->area = $area->name;
        $data->area_id = $area->id;
        $data->show_phone = $data->show_phone ?? null;
        $data->time_ago = time_ago($data->created_at);
        $link = route('advertise.show', [$data->id, $data->slug]);
        // require_once('googl-php-master/Googl.class.php');
        // $googl = new Googl('AIzaSyDGYH1WajbEd1Wvq_-VSy2YrKYG5YbG45E');
        // $data->link = $googl->shorten($link);
        $data->link = $link;
        // unset($googl);
        $like = Likes::where(['advs_id' => $data->id, 'user_id' => request('user_id')])->first();
        $like ? $data->like = 1 : $data->like = 0;
        $data->imgs = $data->images()->get(['image']);
        $comments = $data->comments;
        foreach ($comments as $ct) {
            $ct->user = $ct->user()->first(['id', 'phone', 'username', 'image', 'created_at']);
            $ct->user->image = url('/') . $ct->user->image;
        }
        // dd($data->type);
        if ($data->bids) {
            $data->max_price = $data->bids->max('price');
        }
        $data->comments = $comments;
        $arr = [];
            $IDS = $data->catgeories()->pluck('dept_id')->toArray();
            $x = 0;
            foreach($data->catgeories as $v) {
                $parent = $v->parent_id;
                $dep = \App\Depts::where('parent_id','=',$parent)->get();
                foreach($dep as $value) {
                    $arr[$x][] = [
                        'category_id'   =>  $value->id,
                        'name'          =>  $value->name,
                        'select'        =>  (in_array($value->id,$IDS)) ? true : false,
                    ];
                }
                $x = $x + 1;
            }
            $fristArray = 0;
            $lastArray  = count($arr) - 1;
            $rr[] = $arr[$fristArray];
            $rr[] = $arr[$lastArray];
        $data->categories = $rr;
        unset($data['user_id'], $data['closed'], $data['paid']);
        return $data;
    }

    public function delete(Advs $ad)
    {
        if ($ad->delete()) {
            return [
                'msg' => 'done',
            ];
        }
        return [
            'msg' => 'fail',
        ];
    }

    public function deleteImage(Request $request, Advs $ad)
    {
        $image = '/' . str_replace(asset(''), '', $request['image']);
        $imageM = \App\Images::where([
            'adv_id' => $ad->id,
            'image' => $image,
        ])->first();
        if ($imageM) {
            $imageM->delete();
            return [
                'msg' => 'done',
            ];
        }
        return [
            'msg' => 'fail',
        ];
    }

    public function update(Request $request, Advs $ad)
    {

        if (Auth::guard('api')->user()->id != $ad->user_id) {
            return [
                'msg' => 'Not your ad',
            ];
        }
        $data = $request->except('_token', '_method', 'api_token');
        $rules = ['title' => 'required', 'dept' => 'required'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        if (isset($data['images'])) {
            $images = $data['images'];
        }

        unset($data['images']);
        $cols = DB::getSchemaBuilder()->getColumnListing('advs');
        foreach ($data as $key => $dt) {
            if (in_array($key, $cols)) {
                $info[$key] = $dt;
                unset($data[$key]);
            }
        }
        $output = [];
        foreach ($data as $key => $dt) {
            $key = str_replace('_', ' ', $key);
            $output[$key] = $dt;
        }

        $data = $output;

        if (isset($info['details'])) {
            $info['details'] = implode(', ', array_map(
                function ($v, $k) {
                    return sprintf("%s=%s", $k, $v);
                },
                $data,
                array_keys($data)
            ));
        }

        $info['slug'] = preg_replace('/\s+/', '-', $info['title']);
        $options = request('myoptions');
        
        
        $dd = (is_array($options)) ? $options : json_decode($options,true);
        $info['details'] = '';
        foreach($dd as $key=>$value) {
            $proprites = \DB::table('proprites')->where('id',$key)->first();
            if($info['details'] == '') {
                $info['details'] = "{$proprites->name}={$value}";
            } else {
                $info['details'] = $info['details'].",{$proprites->name}={$value}";
            }
        }
        
        
        $info['options'] = json_encode($options);
        $ad->update($info);
        if (isset($images)) {
            foreach ($images as $img) {
                $thisimg = '/' . uploadBaseImage($img);
                $thisimg != '' ? \App\Images::insert(['adv_id' => $ad->id, 'image' => $thisimg]) : '';
            }
        }
        $GetCategories = $this->GetCategories($info['dept']);
        $ad->catgeories()->sync($GetCategories);
        return [
            'msg' => 'done',
            'ad_id' => $ad->id,
        ];
    }

    public function saloka()
    {
        $Request = Request()->all();
        $ss = uploadBaseImageEEE($Request['image']);
        return $ss;
    }
}
