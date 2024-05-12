<?php

namespace App\Http\Controllers\Api;

use App\Advs;
use App\Depts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class SearchControl extends Controller
{

    public function search(Request $request)
    {
        if (request('dept_id')) {
            $dept = Depts::find(request('dept_id'));
            return redirect()->route('cats', array_merge([$dept->id, $dept->name], request()->query()));
        }
        $data['title'] = request('keyword') && request('keyword') != '' ? request('keyword') : 'نتائج البحث';
        $dept = $data['current_dept'] = new Depts();
        $order_type = request('order_type');
        $data['advs'] = Advs::where('active', 1)->where('is_deleted',0);
        if ($distance = request('distance')) {
            $lat = $this->getUserIP()[0];
            $lng = $this->getUserIP()[1];
            $data['advs'] = $data['advs']->GetByDistance($lat, $lng, $distance);
        }
        $data['advs'] = $data['advs']
            ->when(request('keyword'), function ($query) {
                return $query->where(function ($query) {
                    $query->where('title', 'like', '%' . request('keyword') . '%')
                        ->orWhere('id', request('keyword'))
                        ->orWhere('options', 'like', '%' . request('keyword') . '%');
                });
            })
            ->when(request('from'), function ($query) {
                return $query->where('price', '>=', (int) request('from'));
            })
            ->when(request('to'), function ($query) {
                return $query->where('price', '>=', (int) request('to'));
            })
            // ->when(request('area'), function ($query) {
            //     return $query->where('area', request('area'));
            // })
            ->when(request('from_date'), function ($query) {
                return $query->where('created_at', '>=', request('from_date'));
            })
            ->when(request('to_date'), function ($query) {
                return $query->where('created_at', '<=', request('to_date'));
            })
            ->when(request('order_type'), function ($query) use ($order_type) {
                if ($order_type == 'min_price') {
                    return $query->orderBy('price', 'asc');
                } elseif ($order_type == 'max_price') {
                    return $query->orderBy('price', 'desc');
                } else {
                    return $query->orderBy('id', 'desc');
                }

            })
            ->when(request('date'), function ($query) {
                switch (request('date')) {
                    case 'week':
                        $date = date('Y-m-d', strtotime('-8 days'));
                        break;
                    case 'month':
                        $date = date('Y-m-d', strtotime('-31 days'));
                        break;
                    case 'year':
                        $date = date('Y-m-d', strtotime('-366 days'));
                        break;
                }
                return $query->where('created_at', '>=', $date);
            });
        if (request('area') && request('area') != 'all') {
            $data['advs']->where('area', request('area'));
        }
        if (!$order_type) {
            $data['advs'] = $data['advs']->latest();
        }
        $advs = $data['advs'];

        $data = $advs->paginate(10);
        foreach ($data as $dt) {
            $dt = $this->show_advs_data($dt);
        }
        $this->json_arr['data'] = [];
        foreach ($data as $da) {
            $this->json_arr['data'][] = $da;
        }
        return Response::json($this->json_arr);
    }

    public function details(Request $request)
    {
        if ($request->has('dept')) {
            $props = \App\Props::where(['dept_id' => $request->input('dept'), 'parent' => null])->get();
            foreach ($props as $pr) {
                $pr->types = \App\PropTypes::where('prop_id', $pr->id)->get();
            }
            $this->json_arr['data'] = $props;
            return Response::json($this->json_arr);
        } elseif ($request->has('proptype')) {
            $data = [];
            $parent = \App\PropTypes::where('name', $request->input('proptype'))->first();
            $data['input'] = [];
            if ($parent) {
                $parent = $parent->id;
                $data['proptypes'] = \App\PropTypes::where('parent', $parent)->get();
                $proptype = \App\PropTypes::where('parent', $parent)->first();
                $proptype ? $data['input'] = \App\Props::find($proptype->prop_id) : '';
            }
            $this->json_arr['data'] = $data;
            return Response::json($this->json_arr);
        } elseif ($request->has('type')) {
            $servs = \App\Operations::find($request->input('type'));
            // $servs=explode(',', $servs->props);
            $this->json_arr['data'] = $servs;
            return Response::json($this->json_arr);
        } elseif ($request->has('country')) {
            $area = \App\Area::where('country_id', $request->input('country'))->get(['id', 'name']);
            $this->json_arr['data'] = $area;
            return Response::json($this->json_arr);
        }
        $data = [];
        $data['depts'] = \App\Depts::all();
        foreach ($data['depts'] as $dp) {
            $dp->image = url('/') . '/' . $dp->image;
        }
        $data['types'] = \App\Operations::all();
        $data['country'] = \App\Country::all();
        return Response::json($data);
    }

    public function show_advs_data($data)
    {
        $data->type = $data->gettype()->first();
        $data->type ? $data->type = $data->type->name : $data->type = "";
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
        $data->dept = $data->getdept()->first()->name;
        $data->country = $data->getcountry()->first()->name;
        $data->area = $data->getarea()->first()->name;
        $data->time_ago = time_ago($data->created_at);
        $like = \App\Likes::where(['advs_id' => $data->id, 'user_id' => request('user_id')])->first();
        $like ? $data->like = 1 : $data->like = 0;
        // $link=route('advertise.show',[$data->id,$data->slug]);
        // require_once('googl-php-master/Googl.class.php');
        // dd('dsda');
        // $googl = new Googl('AIzaSyDGYH1WajbEd1Wvq_-VSy2YrKYG5YbG45E');
        // $data->link=$googl->shorten($link);
        // unset($googl);
        $data->link = $data->link ?? null;
        $data->imgs = $data->images()->get(['image']);
        // $main_image = url('placeholder.png');
        // if ($image = $data->images()->first()) {
        //     $main_image = $image->image;
        // }

        $data['main_image'] = $data->image;
        $comments = $data->comments;
        foreach ($comments as $ct) {
            $ct->user = $ct->user()->first(['id', 'phone', 'username', 'image']);
            $ct->user->image = url('/') . $ct->user->image;
        }
        $data->comments = $comments;
        $imgs = [];
        foreach ($data->imgs as $img) {
            $imgs[] = url('/') . '/' . $img->image;
        }
        $data->imgs = $imgs;
        unset($data['user_id'], $data['closed'], $data['paid']);
        return $data;
    }
}
