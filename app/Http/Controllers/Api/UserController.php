<?php

namespace App\Http\Controllers\Api;

use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Advs;
use App\Likes;
use App\User;
use App\Tokens;
use Auth;
use Validator;
use Hash;
use Mail;
use Config;
use Googl;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    private $country;
    private $config;
    public $json_arr;

    public function __construct()
    {
        $this->country = \App\Country::orderBy('id', 'desc')->get();
        $this->config = \App\SiteConfig::first();
        $mail = \App\Site_mail::first();
        Config::set('mail.driver', $mail->driver);
        Config::set('mail.host', $mail->host);
        Config::set('mail.port', $mail->port);
        Config::set('mail.address', $mail->email);
        Config::set('mail.name', \App\SiteConfig::first()->title);
        Config::set('mail.encryption', $mail->encryption);
        Config::set('mail.username', $mail->email);
        Config::set('mail.password', $mail->password);
        $this->json_arr['code'] = 1;
        $this->json_arr['message'] = trans('valid.success');
    }

    public function signup(Request $request)
    {
        $data = $request->all();
        $data['country_id'] = 0;
        $data['area_id']    = 0;
        if (!isset($data['username'])) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = trans('valid.username_required');
        } elseif (!isset($data['phone'])) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = trans('phone_required');
        } elseif (!isset($data['email'])) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = trans('valid.email_required');
            // } elseif (!isset($data['country_id'])) {
            //     $this->json_arr['code'] = 0;
            //     $this->json_arr['message'] = trans('valid.country_required');
            // } elseif (!isset($data['area_id'])) {
            //     $this->json_arr['code'] = 0;
            //     $this->json_arr['message'] = trans('valid.area_required');
        } elseif (!isset($data['password'])) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = trans('valid.password_required');
        } else {
           
            $validator = Validator::make($data, [
                'username'  => 'required|unique:users|min:3',
                'email'     => 'required|email|unique:users',
                'phone'     => 'required|unique:users|min:8',
                'password'  => 'required|min:9|'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->has('username')) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = trans('valid.username_used');
                }
                if ($errors->has('email')) {
                     $Email = User::where('email',$data['email'])->first();
                    if($Email){
                        $this->json_arr['code'] = 0;
                            $this->json_arr['message'] = trans('valid.email_used');
                    }else{
                      $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = trans('صيغة الايميل غير صحيحه');  
                    }
                    
                }
                if ($errors->has('phone')) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = trans('valid.phone_used');
                }
                if ($errors->has('password')) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = 'password wronge';
                }
                
            } else {
                if (!empty($data['image'])) {
                    $info['image'] = uploadBaseImage($data['image']);
                }
                $info['username'] = $data['username'];
                $info['phone'] = $data['phone'];
                $info['email'] = $data['email'];
                $info['country_id'] = $data['country_id'];
                $info['area_id'] = $data['area_id'];
                // 
                $info['password'] = Hash::make($data['password']);
                $data = [];
                $data['user_id'] = User::insertGetId($info);
                $user = User::find($data['user_id']);
                $data['token'] = csrf_token();
                \App\Tokens::insert($data);
                Mail::send('auth.emails.active', $data, function ($m) use ($user) {
                    $m->from($this->config->email, $this->config->title);
                    $m->to($user->email, $user->username)->subject('تفعيل حسابك');
                });
                $this->json_arr['code'] = 1;
                $this->json_arr['message'] = trans('activated_mail_sent');
            }
        }
        return Response::json($this->json_arr);
    }

    public function login(Request $request)
    {
        if (request('access_token')) {
            $user = Socialite::driver(request('driver'))->userFromToken(request('access_token'));
            if ($user) {
                $user = User::whereEmail($user->getEmail())->first();
                $token = str_random(60);
                // dd($token);
                $user->update(['api_token' => $token]);
                $this->return_user($user->id);
                $this->json_arr['data']->token = $token;
            } else {
                $this->json_arr['code'] = '400';
                $this->json_arr['message'] = trans('invalid_credintials');
            }
        } elseif ($request->has('username') || $request->has('phone')) {
            if (!$request->has('password')) {
                $this->json_arr['code'] = 0;
                $this->json_arr['message'] = trans('valid.password_required');
            } else {
                if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')]) || Auth::attempt(['phone' => $request->input('username'), 'password' => $request->input('password')])) {

                    if (!Auth::user()->active) {
                        $this->json_arr['code'] = 402;
                        $this->json_arr['message'] = trans('valid.not_activated');
                    } elseif (Auth::user()->block) {
                        $this->json_arr['code'] = 403;
                        $this->json_arr['message'] = trans('valid.blocked_user');
                    } else {
                        $token = str_random(60);
                        // dd($token);
                        User::where('id', Auth::user()->id)->update(['api_token' => $token]);
                        $this->return_user(\Auth::user()->id);
                        $this->json_arr['data']->token = $token;
                    }
                } else {
                    $this->json_arr['code'] = '400';
                    $this->json_arr['message'] = trans('invalid_credintials');
                }
            }
        } else {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = trans('username_phone_required');
        }
        return Response::json($this->json_arr);
    }

    public function forget(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return Response::json(['message' => trans('valid.email_required'), 'code' => 0]);
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return Response::json(['message' => trans('valid.UserNotFound'), 'code' => 0]);
        }
        $data['user_id'] = $user->id;
        $data['token'] = csrf_token();
        \App\Tokens::insert($data);
        $_token = \DB::table('password_resets')->where('email', $user->email)->first();
        if (is_null($_token)) {
            \DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $data['token']
            ]);
        } else {
            \DB::table('password_resets')->where('email', $user->email)->update([
                'token' => $data['token']
            ]);
        }
        unset($data['user_id']);
        $data['user'] = $user;
        Mail::send('auth.emails.password', $data, function ($m) use ($user) {
            $m->from($this->config->email, $this->config->title);
            $m->to($user->email, $user->username)->subject('تفعيل حسابك');
        });
        return Response::json(['message' => trans('success'), 'code' => 1]);
    }

    public function getInfo(Request $request)
    {
        if (!$request->has('profile_id')) {
            $this->json_arr['code'] = 0;
            $this->json_arr['message'] = 'profile_id is required';
        } else {
            $user_id = $request->input('profile_id');
            $data = User::find($user_id);
            if (!$data) {
                $this->json_arr['code'] = 2;
                $this->json_arr['message'] = trans('valid.UserNotFound');
            } else {
                $this->return_user($user_id);
            }
        }
        return Response::json($this->json_arr);
    }

    public function actions(Request $request, $action = null)
    {
        $all = $request->except('api_token');
        if ($action == 'rate') {
            $rules = ['user_id' => 'required', 'rated_id' => 'required', 'type' => 'required'];
            $validator = Validator::make($all, $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $message) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = $message[0];
                }
                return Response::json($this->json_arr);
            }
            if (!\App\User::find($request->input('rated_id'))) {
                $this->json_arr['code'] = 2;
                $this->json_arr['message'] = trans('valid.UserNotFound');
                return Response::json($this->json_arr);
            }
            $user_id = $request->input('user_id');
            $rated_id = $request->input('rated_id');
            $type = $request->input('type');
            $info = ['user_rated' => $rated_id, 'user_id' => $user_id];
            $data = ['user_rated' => $rated_id, 'user_id' => $user_id, 'type' => $type];
            $rate = \App\Rates::where($info);
            if ($rate->first()) {
                if ($rate->first()->type != $type) {
                    $rate->delete();
                    \App\Rates::insert($data);
                    $user = \App\User::where('id', $rated_id);
                    $type ? $user->increment('rate', 1) : $user->decrement('rate', 1);
                }
            } else {
                \App\Rates::insert($data);
                $user = \App\User::where('id', $rated_id);
                $type ? $user->increment('rate', 1) : $user->decrement('rate', 1);
            }
            $this->return_user($rated_id);
        }
        if ($action == 'follow') {
            $rules = ['user_id' => 'required', 'followed_id' => 'required'];
            $validator = Validator::make($all, $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $message) {
                    $this->json_arr['code'] = 0;
                    $this->json_arr['message'] = $message[0];
                }
                return Response::json($this->json_arr);
            }
            if (!\App\User::find($request->input('followed_id'))) {
                $this->json_arr['code'] = 2;
                $this->json_arr['message'] = trans('valid.UserNotFound');
                return Response::json($this->json_arr);
            }
            $data['user_id'] = $request->input('followed_id');
            $data['follower_id'] = $request->input('user_id');
            // dd($data);
            $is = \App\Followers::where($data)->first();
            if ($is) {
                \App\Followers::where($data)->delete();
            } else {
                \App\Followers::insert($data);
            }
        }
        if ($action == 'edit') {
            $data = $request->except('api_token');
            $user = User::where('api_token', $request->input('api_token'))->first();
            $rules = [
                'phone' => 'required|unique:users,phone,'.$user->id, 
                'email' => 'required|email|unique:users,email,'.$user->id
            ];
    		$validator = Validator()->make($data, $rules);
    		if ($validator->fails()) {
    			foreach ($validator->errors()->messages() as $message) {
    				$this->json_arr['code'] = 0;
    				$this->json_arr['message'] = $message[0];
    			}
    			return Response::json($this->json_arr);
    		}
           
            if ($request->has('password')) {
                if ($data['password'] != '') {
                    $data['password'] = Hash::make($data['password']);
                } else {
                    unset($data['password']);
                }
            }
            $wallpaper = $request->file('wallpaper');
            if ($request->has('image')) {
                $data['image'] = uploadBaseImage($request['image']);
            }
            User::where('id', $user->id)->update($data);
            $this->return_user($user->id);
        }
        return Response::json($this->json_arr);
    }

    public function contacts(Request $request)
    {
        if (!$request->has('type')) {
            $this->json_arr['code'] = 1;
            $this->json_arr['message'] = 'type required';
        }
        if (!$request->has('value')) {
            $this->json_arr['code'] = 1;
            $this->json_arr['message'] = 'value required';
        }
        $user = \App\User::find($request->input('user_id'));
        $types = $request->input('type');
        $i = 0;
        $data = $request->all();
        // dd($data);
        foreach ($types as $tp) {
            $id = $data['id'][$i];
            $type = $data['type'][$i];
            $value = $data['value'][$i];
            if ($id) {
                if ($value != '') {
                    \App\User_contacts::where('id', $id)->update(['user_id' => $user->id, 'type' => $type, 'value' => $value]);
                }
            } else {
                if ($value != '') {
                    \App\User_contacts::insert(['user_id' => $user->id, 'type' => $type, 'value' => $value]);
                }
            }
            $i++;
        }
        $this->return_user($user->id);
        return Response::json($this->json_arr);
    }

    public function notfs(Request $request)
    {
        $user = \App\User::where('api_token', $request->input('api_token'))->first();
        if (!$user) {
            return Response::json(['message' => trans('valid.UserNotFound')]);
        }
        $notfs = $user->notfs()->orderBy('id','DESC')->get();
        foreach ($notfs as $nt) {
            $id = explode('/', $nt->link);
            if(array_key_exists(4,$id)) {
                $id = $id[4];
                $nt->link = '/adv/' . $id;
                $nt->text = strip_tags($nt->text);
            }
        }
        return Response::json(['message' => trans('valid.success'), 'data' => $notfs]);
    }

    public function notfsCheck(Request $request)
    {
        $user = \App\User::where('api_token', $request->input('api_token'))->first();
        if (!$user) {
            return Response::json(['message' => trans('valid.UserNotFound')]);
        }
        $notfs = $user->notfs()->where('seen', 0)->exists();
        $chat  = \App\Chat::where('to', $user->id)->where('seen', 0)->exists();
        return Response::json(['haveNotifcation' => $notfs,'hasMessage'=>$chat]);
    }

    public function notfsType(Request $request,$type='notfs')
    {
        $user = \App\User::where('api_token', $request->input('api_token'))->first();
        if (!$user) {
            return Response::json(['message' => trans('valid.UserNotFound')]);
        }
        if($type == 'notfs') {
            $user->notfs()->update([
                'seen'  => 1
                ]);
        } else {
            \App\Chat::where('to', $user->id)->update([
                'seen'  => 1
                ]);
        }
        return Response::json(['status' => 1]);
    }

    public function msgs(Request $request)
    {
        $user = \App\User::where('api_token', $request->input('api_token'))->first();
        if (!$user) {
            return Response::json(['message' => trans('valid.UserNotFound')]);
        }
        $msgs = $user->msgs;
        return Response::json(['message' => trans('valid.success'), 'data' => $msgs]);
    }

    public function followers(Request $request)
    {
        $user = \App\User::where('api_token', $request->input('api_token'))->first();
        $followers = \App\Followers::where('follower_id', $user->id)->pluck('user_id')->toArray();
        $followings = \App\Followers::where('user_id', $user->id)->pluck('follower_id')->toArray();
        $followers = \App\User::whereIn('id', $followers)->get(['id', 'username', 'image']);
        foreach ($followers as $data) {
            $data->image = url('/') . $data->image;
        }
        $followings = \App\User::whereIn('id', $followings)->get(['id', 'username', 'image']);
        foreach ($followings as $data) {
            $data->image = url('/') . $data->image;
        }
        return Response::json(['followers' => $followers, 'followings' => $followings]);
    }

    public function favors(Request $request)
    {
        $user = \App\User::where('api_token', $request->input('api_token'))->first();
        $advs = $user->likes_advs()->where('is_deleted',0)->orderBy('id', 'desc')->paginate(15);
        $_advs = [];
        foreach ($advs as $ad) {
            $_advs[] = $this->show_advs_data($ad);
        }

        $this->json_arr['data']['advs']      = $_advs;
        $this->json_arr['data']['pagnation'] = api_model_set_pagenation($advs);
        return Response::json($this->json_arr);
    }


    public function allfav($user_id)
    {
        $user = \App\User::where('id', $user_id)->first();
        $advs = $user->likes_advs()->where('is_deleted',0)->orderBy('id', 'desc')->paginate(15);
        $_advs = [];
        foreach ($advs as $ad) {
            $_advs[] = $this->show_advs_data($ad);
        }

        $dd['advs']      = $_advs;
        $dd['pagnation'] = api_model_set_pagenation($advs);
        return Response::json(["message" => "success", 'code' => 1, 'advs' => $dd]);
    }

    public function insert_fav($user_id, $adv_id)
    {
        $check = Likes::where(['user_id' => $user_id, 'advs_id' => $adv_id])->first();
        if (count($check) > 0) {
            return Response::json(["message" => "false", 'code' => 0, 'msg' => 'تم إضافه من قبل']);
        }
        Likes::create(['user_id' => $user_id, 'advs_id' => $adv_id, 'type' => 1]);
        return Response::json(["message" => "success", 'code' => 1, 'msg' => 'تم إضافه الي المفضله']);
    }

    public function delete_fav($user_id, $adv_id)
    {
        $check = Likes::where(['user_id' => $user_id, 'advs_id' => $adv_id])->first();
        if (count($check) == 0) {
            return Response::json(["message" => "false", 'code' => 0, 'msg' => 'هذا الإعلان غير موجد في المفضله']);
        }
        Likes::where([
            'user_id' => $user_id,
            'advs_id' => $adv_id,
        ])->delete();
        return Response::json(["message" => "success", 'code' => 1, 'msg' => 'تم حذف من المفضله']);
    }

    public function allrate($user_id)
    {
        $rate  = \App\Rates::where('user_id', $user_id)->get();
        // dd($rate);
        $count = $total = 0;
        if (count($rate) > 0) {
            foreach ($rate as $val) {
                // $c = $val->rate;
                $count = $count + $val->rate;
            }
            $total = $count / count($rate);
        }
        return Response::json(["message" => "success", "code" => 1, "rate" => (int) $total]);
    }

    public function addrate($user_id)
    {
        $Request = Request()->all();
        $Request['user_id'] = $user_id;
        // dd($Request);
        unset($Request['api_token']);
        $check  = \App\Rates::where($Request)->first();
        if (!is_null($check)) {
            return Response::json(["message" => "false", "code" => 0, "rate" => 'تم التقيم من قبل']);
        }
        \App\Rates::create($Request);
        return Response::json(["message" => "success", "code" => 1, "rate" => 'شكرا لك علي التقيم']);
    }

    public function return_user($user_id)
    {
        $data = User::find($user_id);
        $rates = \App\Rates::where('user_rated',$data->id)->count();
        $rate  = \App\Rates::where('user_rated',$data->id)->sum('rate');
        if($rates == 0) {
            $data->rate = 0;
        } else {
            $data->rate = $rate / $rates;
        }
        $data->getType()->first() ? $data->type = $data->getType()->first()->name : $data->type = '';
        $data->roles()->first() ? $data->role = $data->roles()->first()->name : $data->role = '';
        $data->country()->first() ? $data->country = $data->country()->first()->name : $data->country = '';
        $data->area()->first() ? $data->area = $data->area()->first()->name : $data->area = '';
        $data->image = url('/') . '/' . $data->image;
        $data->wallpaper = url('/') . $data->wallpaper;
        $data->check_documentation = $data->check_doc;
        if (isset($_POST['user_id'])) {
            $follow = \App\Followers::where(['user_id' => $user_id, 'follower_id' => $_POST['user_id']])->first();
            $follow ? $data->follow = 1 : $data->follow = 0;
        }

        $data->contacts = \App\User_contacts::where('user_id', $user_id)->get();
        $advs = $data->advs()->where('is_deleted',0)->orderBy('id', 'desc')->take(15)->get();
        if (!empty($advs)) {
            foreach ($advs as $ad) {
                $ad = $this->show_advs_data($ad);
            }
        }

        $data->advs = $advs;
        $liked_advs = $data->likes_advs()->where('is_deleted',0)->orderBy('id', 'desc')->take(15)->get();
        if (!empty($liked_advs)) {
            foreach ($liked_advs as $ad) {
                $ad = $this->show_advs_data($ad);
            }
        }
        $data->liked_advs = $liked_advs;
        unset($data->block, $data->role_id, $data->created_at, $data->updated_at);

        $this->json_arr['data'] = $data;
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
        $data->user->image = url('/') . $data->user->image;
        $data->user->check_documentation = $data->user->check_doc;
        $data->details = $output;
        // dd($data);
        $data->dept = $data->getdept()->first()->name;
        $data->country = $data->getcountry()->first()->name;
        $data->area = $data->getarea()->first()->name;
        $data->time_ago = time_ago($data->created_at);
        $link = route('advertise.show', [$data->id, $data->slug]);
        // require_once('googl-php-master/Googl.class.php');
        // $googl = new Googl('AIzaSyDGYH1WajbEd1Wvq_-VSy2YrKYG5YbG45E');
        // $data->link = $googl->shorten($link);
        // unset($googl);
        $like = \App\Likes::where(['advs_id' => $data->id, 'user_id' => request('user_id')])->first();
        $like ? $data->like = 1 : $data->like = 0;
        $data->imgs = $data->images()->get(['image']);
        $comments = $data->comments;
        foreach ($comments as $ct) {
            $ct->user = $ct->user()->first(['id', 'phone', 'username', 'image']);
            $ct->user->image = url('/') . $ct->user->image;
        }
        $data->comments = $comments;
        unset($data['user_id'], $data['closed'], $data['paid']);
        return $data;
    }

    public function refresh_token()
    {
        $Request = Request()->all();
        if (empty($Request['profile_id'])) {
            return Response::json(["message" => "false", "code" => 0, "profile_id" => 'required']);
        }
        $user = User::find($Request['profile_id']);
        return Response::json(["message" => "success", "code" => 1, "api_token" => $user->api_token]);
    }
}
