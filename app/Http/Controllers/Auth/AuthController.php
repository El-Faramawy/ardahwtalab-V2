<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Area;
use App\Models\Country;
use App\Models\Pages;
use App\Models\Site_mail;
use App\Models\SiteConfig;
use App\Models\Tokens;
use App\Models\User;
use Auth;
use Config;
use DB;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Socialite;
use Validator;

class AuthController extends Controller
{
    private $country;
    private $config;
    private $sms;

    public function __construct()
    {
        $this->country = Country::orderBy('id', 'desc')->get();
        $this->config = SiteConfig::first();
        $this->sms = DB::table('site_sms')->first();
        $mail = Site_mail::first();
        Config::set('mail.driver', $mail->driver);
        Config::set('mail.host', $mail->host);
        Config::set('mail.port', $mail->port);
        Config::set('mail.address', $mail->email);
        Config::set('mail.name', SiteConfig::first()->title);
        Config::set('mail.encryption', $mail->encryption);
        Config::set('mail.username', $mail->email);
        Config::set('mail.password', $mail->password);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $data = $request->except('_token');
        if (!$data) {
            return view('auth.login');
        }
        if (Auth::attempt(['email' => $data['username'], 'password' => $data['password']]) || Auth::attempt(['phone' => $data['username'], 'password' => $data['password']])) {
            $user = Auth::user();
            if (!Auth::user()->active) {
                $user->update(['online' => 0]);
                Auth::logout();
                return redirect()->route('users.active')->with('error', 'لم يتم تفعيل حسابك الى الان');
            }
            if (Auth::user()->block) {
                $user->update(['online' => 0]);
                Auth::logout();
                return redirect()->back()->with('error', 'تم حجبك من الإدارة ان كان هناك مشكلة يرجى التاوصل معنا');
            }
            $user->update(['online' => 1]);
            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('error', 'خطأ فى كلمة المرور أو اسم المستخدم');
        }
    }

    public function signup(Request $request)
    {
        $data = $request->except('_token');
        $infoo['country'] = $this->country;
        $infoo['area'] = Area::all();
        if (!$data) {
            $policy = Pages::where('type', 'policy')->first();
            return view('auth.signup', compact('infoo', 'policy'));
        }
        $validator = Validator::make($data, [
            'username' => 'unique:users',
            'email' => 'unique:users',
            'confirm-password' => 'same:password',
            "phone" => [
                "required",
                "regex:/^(966|971|020)?([0-9]){2}([0-9]){7,8}$/",
                "max:10",
                "min:8",
                "unique:users"
            ],
        ]);
        if ($validator->fails()) {
            $thiserror = [];
            $thiserror['error'] = [];
            $errors = $validator->errors();
            if ($errors->has('username')) {
                array_push($thiserror['error'], 'هذا الاسم مستخدم من قبل');
            }
            if ($errors->has('email')) {
                array_push($thiserror['error'], 'هذا البريد الالكترونى مستخدم من قبل');
            }
            if ($errors->has('confirm-password')) {
                array_push($thiserror['error'], 'كلمة المرور غير متطابقة');
            }
            if ($errors->has('phone')) {
                array_push($thiserror['error'], trans('valid.' . $errors->get('phone')[0]));
            }
            return redirect()->back()->with($thiserror)->withInput();
        }
        $info['username'] = $data['username'];
        $info['phone'] = $data['phone'];
        $info['email'] = $data['email'];
        $image = $request->file('image');
        $image ? $info['image'] = uploadImage($image) : '';
        // $info['country_id']=$data['country_id'];
        // $info['area_id']=$data['area'];
        $info['password'] = Hash::make($data['password']);
        $data = [];
        $data['user_id'] = User::insertGetId($info);
        // $data['user_id']=85;
        $user = User::find($data['user_id']);
        $data['token'] = csrf_token();
        \App\Models\Tokens::insert($data);
        if ($this->config->active_by == 'email') {


            $to = $user->email;
            $subject = "My subject";
            $txt = 'تفعيل حسابك';

            $link = route('auth.active', [$user->id, $data['token']]);
            $link = '<a href="' . $link . '">اضغط هنا لتفعيل حسابك الآن</a>';

            $msg = "لتفعيل حساب " . site_config()->title . " " . $link . "";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: team@ardhwatalab.com" . "\r\n" .
                "CC: fenix.p2h@hotmail.com";

            mail($to, $subject, $msg, $headers);
//            Mail::send('auth.emails.password', $data, function ($mail) use ($user,$txt) {
//                $mail->to($user->email, $user->username)
//                    ->subject($txt);
//            });

            return back()->with([
                'title' => 'تم تسجيل حسابك بنجاح',
                'text' => 'تم ارسال رابط التفعيل إلى بريدك الإلكترونى'
            ]);
        } else {
            $link = route('auth.active', [$user->id, $data['token']]);
            /*

                        require_once('googl-shorten/Googl.class.php');
                        $googl = new Googl('AIzaSyCKMmdsiMk2_tWFobRK9lci_Po4GxMi8RI');
                        $link = $googl->shorten($link);
                        $link = explode('//', $link)[1];
                        // dd($link);
                        unset($googl);
            */
            $link = '<a href="' . $link . '">اضغط هنا لتفعيل حسابك الآن</a>';
            $msg = "لتفعيل حساب " . site_config()->title . " " . $link . "";
            /* //$res = send_sms($this->sms->username, $this->sms->password, $info['phone'], $this->sms->sender, $msg);
             //
             $to      =  $info['email'];
             $subject = 'Active Your Account.';
             $message = $msg;
             $headers = 'Content-type: text/html; charset=iso-8859-1
             From: team@ardhwatalab.com.sa' . "\r\n" .
             'Reply-To: team@ardhwatalab.com.sa' . "\r\n" .
             'X-Mailer: PHP/';



               mail($to, $subject, $message, $headers);
               */


            $to = $info['email'];
            $subject = "My subject";
            $txt = $msg;

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: team@ardhwatalab.com" . "\r\n"; // info@ardhwatalab.com.sa

            mail($to, $subject, $txt, $headers);

            //

            $_msg = 'تم ارسال رابط التفعيل الى بريدك الإلكتروني';
        }
        return back()->with('success', $_msg);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->update(['online' => 0]);
        Auth::logout();
        return redirect()->route('home');
    }

    public function getarea(Request $request)
    {
        $country = $request->input('country');
        $area = Area::where('country_id', $country)->orderBy('id', 'desc')->get();
        return view('ajax.area')->with('area', $area);
    }

    public function user_active(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return view('auth.active');
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'لا يوجد مستخدم لهذا البريد');
        }
        $data['user_id'] = $user->id;
        $data['token'] = csrf_token();
        Tokens::insert($data);
        if ($this->config->active_by == 'sms') {
            Mail::send('auth.emails.active', $data, function ($m) use ($user) {
                $m->from('support@adam-medical.com', $this->config->title);
                $m->to($user->email, $user->username)->subject('تفعيل حسابك');
            });
        } else {
            $link = route('auth.active', [$user->id, $data['token']]);
            $msg = "لتفعيل حساب " . site_config()->title . " " . $link . "";
            send_sms($this->sms->username, $this->sms->password, $user->phone, $this->sms->sender, $msg);
        }
        return redirect()->back()->with('true', 'تم ارسال لينك التفعيل');
    }

    public function active($id, $token)
    {
        // dd(Config::get('mail'));
        $is = Tokens::where(['user_id' => $id, 'token' => $token])->first();
        if ($is) {
            User::where('id', $id)->update(['active' => 1]);
            // \App\Tokens::where(['user_id'=>$id,'token'=>$token])->delete();
            if (!Auth::check()) {
                return redirect()->route('login')->with('success', 'تم تفعيل الحساب يرجى تسجيل الدخول');
            }
            return redirect()->route('home')->with('active-msg', 'تم التفعيل');
        }
        Auth::logout();
        return redirect()->route('login')->with('error', 'هذا الرابط غير صحيح يرجى التأكد');
    }

    public function password_reset()
    {
        $data['user'] = $user = User::where('email', request('email'))->first();
        if (!$user) {
            return back()->with('error', 'هذا البريد غير مسجل لدينا');
        }
        $data['token'] = Str::random(40);
        $user->tokens()->create(['token' => $data['token']]);
        Mail::send('auth.emails.password', $data, function ($mail) use ($user) {
            $mail->to($user->email, $user->username)
                ->subject('استعادة كلمة المرور');
        });
        return back()->with('success', 'تم ارسال رابط استعادة كلمة المرور الى بريدك الإلكتروتى');
    }

    public function reset_password($token)
    {
        $token = Tokens::where('token', $token)->first();
        if (!$token) abort('404');
        $info = $token->user;
        return view('auth.passwords.reset', get_defined_vars());
    }
}
