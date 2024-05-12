<?php

namespace App\Http\Controllers\Site;

use App\Models\Bids;
use App\Models\Chat;
use App\Models\Comments;
use App\Models\Country;
use App\Models\Rates;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Claims;
use App\Models\Advs;
use App\Models\Notfs;
use DB;

class ActionsController extends Controller {

    private $notfs;

    public function __construct() {
        $this->notfs = [];
    }

    public function bids(Request $request) {
        $data = $request->except('_token');
        $data['user_id'] = Auth::user()->id;
        Bids::insert($data);
        $advs = Advs::where(['id'=>$data['advs_id'],'active'=>1])->first();
        $this->notfs['user_id'] = $advs->user_id;
        $this->notfs['link'] = route('advertise.show', [$advs->id, $advs->slug]);
        $this->notfs['text'] = "قام <b>" . Auth::user()->username . "</b> بالمشاركة بالمزاد الخاص بك";
        Notfs::insert($this->notfs);
        return redirect()->back()->with('success', 'تم اضافة مزادك بنجاح');
    }

    public function comment(Request $request) {
        $data = $request->except('_token');
        $data['user_id'] = Auth::user()->id;
        Comments::insert($data);
        $advs = Advs::where(['id'=>$data['advs_id'],'active'=>1])->first();
        $this->notfs['user_id'] = $advs->user_id;
        $this->notfs['link'] = route('advertise.show', [$advs->id, $advs->slug]);
        $this->notfs['text'] = "علق <b>" . Auth::user()->username . "</b> على <b>" . $advs->title . "</b>";
        Notfs::insert($this->notfs);
        return redirect()->back()->with('true', 'تم اضافة التعليق بنجاح');
    }

    public function like($id, $user = null, $type = null) {
        $advs = Advs::find($id);
        if (!$user) {
            $like = Auth::user()->likes()->where('advs_id', $id)->first();
            if ($like) {
                Auth::user()->likes()->where('advs_id', $id)->delete();
                return back();
            }
            Auth::user()->likes()->create(['advs_id' => $id, 'type' => 1]);
            return back();
        }
        Auth::user()->likes()->where('person_id', $id)->delete();
        Auth::user()->likes()->create(['person_id' => $id, 'type' => $type]);
        $result['likes'] = User::find($id)->mylikes()->where('type', 1)->count();
        $result['dislikes'] = User::find($id)->mylikes()->where('type', 0)->count();
        $this->notfs['user_id'] = $advs->user_id;
        $this->notfs['link'] = route('advertise.show', [$advs->id, $advs->slug]);
        $this->notfs['text'] = "أعجب <b>" . Auth::user()->username . "</b> بالإعلان الخاص بك";
        Notfs::insert($this->notfs);
        return back();
    }

    public function likes() {
        $advs = Auth::user()->likes_advs()->latest()->paginate(12);
        return view('site.user.likes', compact('advs'));
    }

    public function chat(Request $request, $userid = null) {
        // if(!is_numeric($userid)){
        //     $userid = User::where('username',$userid)->firstOrFail()->id;
        // }
        $user = $userid;
        if (!$user) {
            $last = Chat::where('from', Auth::user()->id)->orWhere('to', Auth::user()->id)->orderBy('id', 'desc')->first();
            if ($last) {
                if ($last->from != Auth::user()->id) {
                    $user = User::find($last->from)->username;
                } elseif ($last->to != Auth::user()->id) {
                    $user = User::find($last->to)->username;
                }
            }
        }
        $msg = $request->input('message');
        if (!$msg) {
            if (!$userid) {
                // $data['chat'] = Chat::select(DB::raw('sum(from * to) AS fromto'))->where('from',Auth::user()->id)->orWhere('to',Auth::user()->id)->latest()->groupBy('fromto')->paginate(10);
                $data['chat'] = Chat::where('from', Auth::user()->id)->orWhere('to', Auth::user()->id)->groupBy('from', 'to')->paginate(10);

                return view('site.user.chat', $data);
            }
            $to = Chat::where('from', Auth::user()->id)->pluck('to')->toArray();
            $from = Chat::where('to', Auth::user()->id)->pluck('from')->toArray();
            $all = array_merge($to, $from);
            if ($userid) {
                if (!in_array($userid, $all)) {
                    array_push($all, $userid);
                }
            }
            $users = User::whereIn('id', $all)->orderBy('id', 'desc')->get();
            $data['users'] = [];
            foreach ($users as $us) {
                $us->image = url('/') . $us->image;
                $lastmsg = Chat::where('from', $us->id)->orWhere('to', $us->id)->orderBy('id', 'desc')->first();
                $lastmsg ? $us->lastmsg = $lastmsg->message : '';
                $lastmsg ? $us->lastseen = $lastmsg->seen : '';
                $data['users'][] = $us;
            }
            // dd($data['users']);
            $data['chat'] = [];
            if ($user) {
                $us = Auth::user();
                $this_user = User::where('id', $userid)->first();
                $data['chat'] = Chat::where(function($q1) use ($us ,$this_user){
                    $q1->where( ['from' => $us->id, 'to' => $this_user->id]);
                })->orWhere(function($q2) use ($us ,$this_user){
                    $q2->where( ['to' => $us->id, 'from' => $this_user->id]);
                })
                ->orderBy('created_at')->take(20)->latest()->get();
                $data['user_id'] = $this_user->id;
            }
            $data['user'] = $user;
            $data['chat_user'] = User::find($userid);
            $data['userid'] = $userid;
            return view('site.user.user-chat', $data);
        }
        $info['message'] = $request->input('message');
        $info['to'] = $request->input('to_id');
        $info['from'] = Auth::user()->id;
        $info['created_at'] = date('Y-m-d H:i:s',strtotime('+3 hours'));
        Chat::create($info);
        return redirect()->back()->with('true', 'تم ارسال الرسالة بنجاح');
    }

    public function claim(Request $request, $id) {
        if (!$request->except('_token')) {
            return view('site.advs.claims');
        }
        $data['advs_id'] = Advs::where('slug', $title)->first()->id;
        $data['created_at'] = date('Y-m-d h:i:s');
        $data['text'] = $request->input('text');
        Claims::insert($data);
        return redirect()->back()->with('message', 'تم ابلاغ المشرف');
    }

    public function rates($id) {
        if (request()->isMethod('post')) {
            $data['user_id'] = $id;
            $data['user_rated'] = auth()->user()->id;
            $data['rate'] = request('rate');
            $data['comment'] = request('comment');
            Rates::create($data);
            return redirect()->back()->with('true', 'تم اضافة تقييمك بنجاح');
        }
        return redirect('/');
    }

    public function getAreas($country_id) {
        return Country::find($country_id)->area->all();
    }

}
