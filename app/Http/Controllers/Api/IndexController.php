<?php

namespace App\Http\Controllers\Api;

use App\Advs;
use App\Depts;
use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redis;
use DB;

class IndexController extends Controller
{
	public function contactus(Request $request)
	{
		$info['contacts'] = \App\SiteContacts::all();
		$info['purposes'] = ['اتصال عام', 'طلب خاص', 'شكوى', 'اقتراح'];
		$info['important'] = ['عادى', 'متوسط', 'هام'];
		$data = $request->except('api_token');
		if (!$data) {
			return Response::json(compact('info'));
		}
		$rules = ['subject' => 'required', 'email' => 'required', 'purpose' => 'required', 'important' => 'required', 'msg' => 'required'];
		$validator = Validator()->make($data, $rules);
		if ($validator->fails()) {
			foreach ($validator->errors()->messages() as $message) {
				$this->json_arr['code'] = 0;
				$this->json_arr['message'] = $message[0];
			}
			return Response::json($this->json_arr);
		}
		\App\Contactus::insert($data);
		return Response::json(['message' => 'success', 'code' => 1]);
	}
	public function country()
	{
		return Response::json(['data' => \App\Country::all(), 'code' => 1]);
	}
	public function area()
	{
		if (!request()->has('country_id')) {
			return Response::json(['message' => 'country_id required', 'code' => 0]);
		}

		$this->json_arr['data'] = \App\Area::where('country_id', request('country_id'))->get(['id', 'name']);
		return Response::json($this->json_arr);
	}
	public function types()
	{
		return Response::json(['data' => \App\Operations::get(['id', 'name']), 'code' => 1]);
	}
	public function props()
	{
		$info = Advs::find(request('item_id')) ?? null;
		if (request()->has('dept_id')) {
			$super_parent = Depts::find(request('dept_id'))->super_parent;
			$props = \App\Props::where(['dept_id' => $super_parent->id, 'parent' => NULL])->orderBy('title_id', 'asc')->orderBy('id', 'asc')->get(['id', 'name', 'input','main']);
			foreach ($props as $pr) {
				$pr->value = $info->options[$pr->id] ?? '';
				$pr->types = $pr->input == 'input' ? [] : \App\PropTypes::where('prop_id', $pr->id)->get(['id', 'name']);
			}
			$data['childs'] = Depts::find(request('dept_id'))->childs()->get(['id' , 'name']);
			$data['props'] = $props;
			return Response::json(['data' => $data, 'code' => 1]);
		}
		return Response::json(['message' => 'dept_id required', 'code' => 0]);
	}
	public function cats()
	{
		if (request('dept_id')) {
			$cat = \App\Depts::with('childs')->where('parent_id', request('dept_id'))->select(['id', 'name', 'image'])->paginate(15);
		} else {
			$cat = \App\Depts::with('childs')->where('parent_id', null)->select(['id', 'name', 'image'])->paginate(15);
		}
		// $data = [];
		// foreach ($cat as $dt) {
		// 	// 			//$dt->image ? $dt->image=url('/').$dt->image : ''; 
		// 	// 			$type=\App\Props::where(['dept_id'=>$dt->id,'main'=>1])->first();
		// 	// 			//$dt->subs=\App\PropTypes::where('prop_id',$type->id)->get(['name','id']);
		// 	$data[] = $dt;
		// }
		$this->json_arr['pagnation'] = api_model_set_pagenation($cat);
		$this->json_arr['cats'] = $cat;
		return Response::json($this->json_arr);
	}

	public function cats_advs($id)
	{
		$cat = Depts::find($id);
		$this->json_arr['childs'] = $cat->childs;
		$data = $cat->all_advs()->where('is_deleted',0)->latest()->paginate(15);
		foreach ($data as $dt) {
			$dt = $this->show_advs_data($dt);
		}
		foreach ($data as $da) {
			$this->json_arr['advs'][] = $da;
		}
		// $this->json_arr['pagnation'] = api_model_set_pagenation($cat);
		return Response::json($this->json_arr);
	}
	public function joins()
	{
		$this->json_arr['data'] = \App\Jointypes::all();
		return Response::json($this->json_arr);
	}
	public function banking()
	{
		$data = \App\Paymethods::all();
		foreach ($data as $dt) {
			$dt->image ? $dt->image = url('/') . $dt->image : '';
		}
		$this->json_arr['data'] = $data;
		return Response::json($this->json_arr);
	}
	public function pages()
	{
		$this->json_arr['data'] = \App\Pages::all();
		return Response::json($this->json_arr);
	}
	public function page()
	{
		$this->json_arr['page'] = \App\Pages::where('title', request('title'))->first();
		return Response::json($this->json_arr);
	}
	public function transfer(Request $request)
	{
		$data = $request->except('api_token');
		if (!isset($data['name'])) {
			$this->json_arr['code'] = '0';
			$this->json_arr['message'] = 'name required';
		} elseif (!isset($data['bank'])) {
			$this->json_arr['code'] = '0';
			$this->json_arr['message'] = 'bank required';
		} elseif (!isset($data['send_date'])) {
			$this->json_arr['code'] = '0';
			$this->json_arr['message'] = 'send_date required';
		} elseif (!isset($data['send_data'])) {
			$this->json_arr['code'] = '0';
			$this->json_arr['message'] = 'send_data required';
		} else {
			\App\Pays::insert($data);
		}
		return Response::json($this->json_arr);
	}

	public function blacklist(Request $request)
	{

		if (!$request->has('word')) {
			$this->json_arr['code'] = 0;
			$this->json_arr['message'] = 'word required';
		} else {
			$this->json_arr['data'] = ['found' => 0];
			if (\App\User::where(['block' => 1, 'username' => $request->input('word')])->orWhere(['block' => 1, 'email' => $request->input('word')])->orWhere(['block' => 1, 'phone' => $request->input('word')])->first()) {
				$this->json_arr['data'] = ['found' => 1];
			}
		}
		return Response::json($this->json_arr);
	}


	public function chat(Request $request)
	{
		$user = \App\User::where('api_token', request('api_token'))->first(['id', 'username', 'image']);
		$user->image = url('/') . $user->image;
		$other = request('user_id');
		$to_id = request('to_id');
		$from_id = request('from_id');
		$message = request('message');
		
		//dd($other,$to_id,$from_id,$message);
		
		
		if ($other) {
			$other = \App\User::where('id', $other)->first(['id', 'username', 'image']);
			$other->image = url('/') . $other->image;
			$last = \App\Chat::where(['from' => $user->id, 'to' => $other->id])->orWhere(['to' => $user->id, 'from' => $other->id])->orderBy('id', 'desc')->take(20)->get();
			$lasts = [];
			foreach ($last as $lt) {
				if ($lt->from == $user->id) {
					$lt->from = $user;
				} else {
					$lt->from = $other;
				}

				if ($lt->to == $user->id) {
					$lt->to = $user;
				} else {
					$lt->to = $other;
				}
				$lasts[] = $lt;
			}
			$lasts = array_reverse($lasts);
			$data['last'] = $lasts;
			return Response::json(compact('data'));
		} elseif ($message && $from_id && $to_id) {
			$info['message'] = $message;
			$info['to'] = $to_id;
			$info['from'] = $from_id;
			\App\Chat::insert($info);
			// require(base_path('vendor/predis/predis/autoload.php'));
			$info['to'] = \App\User::where('id', $info['to'])->first(['id', 'username', 'image']);
			$info['to']->image = url('/') . $info['to']->image;
			$info['from'] = \App\User::where('id', $info['from'])->first(['id', 'username', 'image']);
			$info['from']->image = url('/') . $info['from']->image;
			$info['event'] = request('event');
			// Redis::publish('data-channel',json_encode($info));
			return Response::json(['message' => 'success', 'code' => 1]);
		}
		$all_chat = \App\Chat::where('from', $user->id)->orWhere('to', $user->id)->orderBy('id', 'desc')->get();
		$arrs = [];
		$chats = [];
		foreach ($all_chat as $all) {
			if ($all->from != $user->id) {
				if (!in_array($all->from, $arrs)) {
					$all->from_user = \App\User::where('id', $all->from)->first(['id', 'username', 'image']);
					$all->from_user->image = url('/') . $all->from_user->image;
					$all->to_user = $user;
					$arrs[] = $all->from;
					$chats[] = $all;
				}
			}
			if ($all->to != $user->id) {
				if (!in_array($all->to, $arrs)) {
					$all->to_user = \App\User::where('id', $all->to)->first(['id', 'username', 'image']);
					$all->to_user->image = url('/') . $all->to_user->image;
					$all->from_user = $user;
					$arrs[] = $all->to;
					$chats[] = $all;
				}
			}
			if ($all->from_user && $all->to_user) {
				$event = DB::table('chat_events')->where(['one' => $all->from, 'two' => $all->to])->orWhere(['two' => $all->from, 'one' => $all->to])->first();
				if (!$event) {
					$event = uniqid();
					DB::table('chat_events')->insert(['one' => $all->from, 'two' => $all->to, 'event' => $event]);
					$all->event = $event;
				} else {
					$all->event = $event->event;
				}
			}
			unset($all->to, $all->from);
		}
		return Response::json(['data' => $chats, 'code' => 1]);
	}

	public function create_event()
	{
		if (request()->has('user_id') || request()->has('advs_id')) {
			$other = \App\User::where('api_token', request('api_token'))->first();
			if (request()->has('advs_id')) {
				$advs = \App\Advs::find(request('advs_id'));
				if ($other && $advs) {
					if ($other->id != $advs->user_id) {
						$event = DB::table('chat_events')->where(['one' => $other->id, 'two' => $advs->user_id])->orWhere(['two' => $other->id, 'one' => $advs->user_id])->first();
						if (!$event) {
							$eventid = uniqid();
							DB::table('chat_events')->insert(['one' => $other->id, 'two' => $advs->user_id, 'event' => $eventid]);
						} else {
							$eventid = $event->event;
						}
						return Response(['event' => $eventid, 'code' => 1]);
					}
				}
			} else {
				$user = \App\User::find(request('user_id'));
				if ($user) {
					if ($other->id != $user->id) {
						$event = DB::table('chat_events')->where(['one' => $other->id, 'two' => $user->id])->orWhere(['two' => $other->id, 'one' => $user->id])->first();
						if (!$event) {
							$eventid = uniqid();
							DB::table('chat_events')->insert(['one' => $other->id, 'two' => $user->id, 'event' => $eventid]);
						} else {
							$eventid = $event->event;
						}
						return Response(['event' => $eventid, 'code' => 1]);
					}
				}
			}
		}
	} //create event

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

		$dept = $data->getdept()->first();
		$data->dept = $dept->name;
		$data->dept_id = $dept->id;

		$country = $data->getcountry()->first();
		$data->country = $country->name;
		$data->country_id = $country->id;

		$area = $data->getarea()->first();
		$data->area = $area->name;
		$data->area_id = $area->id;

		$data->time_ago = time_ago($data->created_at);
		$link = route('advertise.show', [$data->id, $data->slug]);
		// require_once('googl-php-master/Googl.class.php');
		// $googl = new Googl('AIzaSyDGYH1WajbEd1Wvq_-VSy2YrKYG5YbG45E');
		// $data->link = $googl->shorten($link);
		$data->link = $link;
		// unset($googl);
		$like = \App\Likes::where(['advs_id' => $data->id, 'user_id' => request('user_id')])->first();
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
		unset($data['user_id'], $data['closed'], $data['paid']);
		return $data;
	}
}
