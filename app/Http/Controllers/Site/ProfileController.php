<?php

namespace App\Http\Controllers\Site;
// use App\Http\Controllers\Controller;

use App\Models\Bids;
use App\Models\Claims;
use App\Models\Comments;
use App\Models\Country;
use App\Models\Followers;
use App\Models\Joins;
use App\Models\Mediation;
use App\Models\Notfs;
use App\Models\Rates;
use App\Models\SiteSystems;
use App\Models\User_contacts;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use \App\Models\User;
use App\Models\Advs;
use App\Models\Contacts;
use Hash;
use Validator;
use App\Models\Images;
use App\Models\Area;
use App\Models\Depts;

use App\Models\CategoryDocumentationForm;
use App\Models\DocumentationForm;

class ProfileController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->middleware('auth')->only('edit');
        Auth::check() ? $this->user = Auth::user() : '';
    }

    public function show($name)
    {
        $user = User::where('id', $name)->first();
        $data['info'] = $user;
        $data['advs'] =Advs::where('user_id', Auth::user()->id)->where('active', 1)->orderBy('id', 'desc')->paginate();
        if (Auth::check()) {
            if (Auth::user()->id == $name) {
                return redirect()->route('users.edit', $name);
            }
        }
        return view('site.user.guest', $data);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $edit = $request->input('edit');
        if ($edit == 'contacts') {
            $types = $request->input('type');
            $info['contacts'] = User_contacts::where('user_id', $user->id)->get();
            if (!$types) {
                return view('site.user.contacts', $info);
            }
        }
        $data['info'] = $user;
        if ($edit == 'shop') {
            return view('site.user.shop', $data);
        }
        if ($edit == 'password') {
            return view('site.user.password', $data);
        }
        $data['country'] = Country::all();
        if (Auth::user()->area_id) {
            $country = Area::find(Auth::user()->area_id)->country_id;
            $data['area'] = Area::where('country_id', $country)->get();
        } else {
            $data['area'] = [];
        }
        return view('site.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $rules = [];
        if (request('phone')) {
            $rules['phone'] = [
                "required",
                "regex:/^(966|971|020)?([0-9]){2}([0-9]){7,8}$/",
                "max:12",
                "min:8",
                "unique:users,phone,{$id}"
            ];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->with('error', trans('valid.' . $errors->get('phone')[0]));
            }
        }
        if ($request->has('password')) {
            if ($data['password'] != '' || $data['password'] != ' ') {
                $rules = ['password-confirmation' => 'same:password'];
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'كلمة المرور الجديدة غير متطابقة');
                }
                //                if (!Hash::check($data['old-password'], Auth::user()->password)) {
                //                    return redirect()->back()->with('error', 'كلمة المرور غير صحيحة');
                //                }
                $data = [];
                $data['password'] = Hash::make($request['password']);
                $data['active'] = 1;
                User::where('id', $id)->update($data);
                return redirect()->route('login')->with('true', 'تم استعادة كلمة المرور يرجى تسجيل الدخول');
            } else {
                unset($data['password']);
            }
        }

        if (!empty($request['image'])) {
            $image = $request->file('image');
            $data['image'] = uploadImage($image);
        } else {
            unset($data['image']);
        }
        $wallpaper = $request->file('wallpaper');
        $wallpaper ? $data['wallpaper'] = '/assets/uplaods/' . uploadImage($wallpaper) : '';
        $user = User::where('id', $id)->first();
        $user->update($data);
        return redirect()->back()->with('true', 'تم تعديل بياناتك بنجاح');
    }

    public function contacts(Request $request)
    {
        $pro = $request->input('type');
        if ($pro == 'remove') {
            $id = $request->input('id');
            User_contacts::where('id', $id)->delete();
            return 1;
        }
        $user = Auth::user();
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
                    User_contacts::where('id', $id)->update(['user_id' => $user->id, 'type' => $type, 'value' => $value]);
                }
            } else {
                if ($value != '') {
                    User_contacts::insert(['user_id' => $user->id, 'type' => $type, 'value' => $value]);
                }
            }
            $i++;
        }
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }

    public function requests($type)
    {
        if ($type == 'sale') {
            $advs = Advs::where('user_id', $this->user->id)->where('type', 1)->where('active', 1)->pluck('id')->toArray();
            $data['title'] = 'طلبات البيع';
        } elseif ($type == 'buy') {
            $advs = Advs::where('user_id', $this->user->id)->where('type', 3)->where('active', 1)->pluck('id')->toArray();
            $data['title'] = 'طلبات الشراء';
        } elseif ($type == 'bids') {
            $data['bids'] = Auth::user()->advs()->where('type', 2)->where('active', 1)->get();
            $data['title'] = 'مزاداتى';
            return view('site.user.bids', $data);
        } else {
            if (is_numeric($type)) {
                \App\Models\Requests::where('id', $type)->update(['status' => 1]);
                return redirect()->back();
            }
        }
        $requests = \App\Models\Requests::whereIn('advs_id', $advs)->get();
        $data['requests'] = [];
        foreach ($requests as $rq) {
            $rq->advertise = Advs::find($rq->advs_id);
            $rq->user = User::find($rq->user_id);
            $data['requests'][] = $rq;
        }
        return view('site.user.requests', $data);
    }

    public function advs($type = null)
    {
        if ($type) {
            if ($type == 'not-active') {
                $data['title'] = $data['titl'] = 'اعلانات بانتظار التفعيل';
                $data['advs'] = Advs::where('user_id', Auth::user()->id)->where('is_deleted',0)->where('active', 0)->orderBy('id', 'desc')->paginate();
                $data['active'] = 0;
            } elseif ($type == 'closed') {
                $data['title'] = $data['titl'] = 'اعلانات مغلقة';
                $data['advs'] =Advs::where('user_id', Auth::user()->id)->where('is_deleted',0)->where('closed', 0)->orderBy('id', 'desc')->paginate();
                $data['closed'] = 1;
            } elseif ($type == 'likes') {
                $data['title'] = $data['titl'] = 'الإعلانات المفضلة';
                $data['advs'] = Auth::user()->likes_advs;
                // return view('site.advs',$info);
            } elseif ($type == 'median') {
                if (!SiteSystems::where('type', 'media')->first()->active) {
                    return redirect()->route('errors', ['type' => 'not_allowed']);
                }
                $data['title'] = $data['titl'] = 'طلبات الوساطة';
                $advs = Advs::where('user_id', $this->user->id)->where('is_deleted',0)->pluck('id')->toArray();
                $advs = Mediation::whereIn('advs_id', $advs)->pluck('advs_id')->toArray();
                $data['advs'] = Advs::whereIn('id', $advs)->orderBy('id', 'desc')->paginate();
            }

            return view('site.user.advs', $data);
        }

        $data['title'] = $data['titl'] = 'اعلاناتى';

        //  if ($this->user) {
        //     $data['advs'] = $this->user->advs()->where('active', 1)->latest()->paginate(9);
        // } else {
        //     // Handle the case where $this->user is null (perhaps redirect to login or show an error message)
        //     return redirect()->route('login');
        // }
        $data['advs'] = Advs::where('user_id', Auth::user()->id)->where('active', 1)->latest()->paginate(9);

        return view('site.user.advs', $data);
    }

    public function follow($id = null)
    {
        if (!$id) {
            $data['followers'] = Followers::where('user_id', Auth::user()->id)->get();
            // $users = \App\Followers::where('user_id', $this->user->id)->get();
            // // dd($users);
            // $data['followers'] = [];
            // foreach ($users as $us) {
            //     $user = \App\User::find($us->follower_id);
            //     if($user) {
            //         $data['followers'][] = $user;
            //     }
            // }
            // dd($data);
            return view('site.user.followers', $data);
        }
        $data = [];
        $data['follower_id'] = $id;
        $data['user_id']     = $this->user->id;
        // dd($data);
        $is = Followers::where($data)->first();
        if ($is) {
            $i = 1;
            Followers::where($data)->delete();
        } else {
            $i = 0;
            Followers::insert($data);
        }
        return $i;
    }

    public function rate($id, $type)
    {
        $info = ['user_rated' => $id, 'user_id' => Auth::user()->id];
        $data = ['user_rated' => $id, 'user_id' => Auth::user()->id, 'type' => $type];
        $rate = Rates::where($info);
        if ($rate->first()) {
            if ($rate->first()->type != $type) {
                $rate->delete();
                Rates::insert($data);
                $user = User::where('id', $id);
                $type ? $user->increment('rate', 1) : $user->decrement('rate', 1);
            }
        } else {
            Rates::insert($data);
            $user = User::where('id', $id);
            $type ? $user->increment('rate', 1) : $user->decrement('rate', 1);
        }
        return User::find($id)->rate;
    }

    public function rate2($id)
    {
        $info = ['user_rated' => $id, 'user_id' => Auth::user()->id];
        $rate = Rates::where($info)->first();
        if($rate) {
            return redirect()->back()->with('true', 'تم تقيم من قبل');
        }
        $info['rate'] = request('rate');
        Rates::create($info);
        return redirect()->back()->with('true', 'شكرأ لك علي التقيم');
    }

    public function timeline()
    {
        $users = $this->user->followers()->pluck('follower_id')->toArray();
        // dd($users);
        // $data['advs'] = [];
        foreach ($users as $val) {
            $data['advs'] = \App\Advs::where(['user_id' => $val])->orderBy('created_at', 'DESC')->paginate();
        }
        $data['title'] = 'اعلانات المتابعين';
        return view('site.advs', $data);
    }

    public function joins()
    {
        $data['joins'] = Joins::where('user_id', $this->user->id)->orderBy('id', 'desc')->get();
        return view('site.user.joins', $data);
    }

    public function claims($type)
    {
        $data['type'] = 'comment';
        if ($type == 'advs') {
            $advs = Claims::where(['user_id' => $this->user->id])->where('advs_id', '!=', null)->pluck('advs_id')->toArray();
            $data['advs'] = \App\Advs::whereIn('id', $advs)->orderBy('id', 'desc')->get();
            $data['title'] = $data['titl'] = 'الاعلانات المبلغ عنها';
        } elseif ($type == 'comments') {
            $comments = Claims::where(['user_id' => $this->user->id])->where('comment_id', '!=', null)->pluck('comment_id')->toArray();
            $advs = Comments::whereIn('id', $comments)->pluck('advs_id')->toArray();
            $data['advs'] = \App\Advs::whereIn('id', $advs)->orderBy('id', 'desc')->get();
            $data['title'] = $data['titl'] = 'التعليق المبلغ عنه';
        }
        return view('site.advs', $data);
    }

    public function list_bids(Request $request)
    {
        $data['bids'] = Bids::where('advs_id', $request->id)->orderBy('id', 'desc')->get();
        return view('site.user.bids-list', $data);
    }

    public function notfs()
    {
        $data['notfs'] = Auth::user()->notfs()->orderBy('id', 'desc')->paginate(5);
        Notfs::where('user_id', Auth::user()->id)->update(['seen' => 1]);
        return view('site.user.notfs', $data);
    }

    public function documentation_form() {
        $data['categories'] = CategoryDocumentationForm::all();
        return view('site.pages.documentation_form', $data);
    }

    public function documentation_form_post() {
        $request = request()->all();
        if(array_key_exists('image',$request)) {
            if(!is_null($request['image']) || $request['image'] != '') {
                if(request()->hasFile('image')) {
                    $request['image'] = uploadImage($request['image']);
                } else {
                    unset($request['image']);
                }
            } else {
                unset($request['image']);
            }
        }
        $request['user_id'] = Auth::user()->id;
        $check = DocumentationForm::where(['user_id'=>Auth::user()->id])->first();
        if(!is_null($check)) {
            return redirect()->back()->with('error', 'تم رفع وثيقة لهذا العضو من قبل شكرا لك');
        }
        DocumentationForm::create($request);
        return redirect()->back()->with('true', 'تم رفع الوثائق بنجاح');
    }
}
