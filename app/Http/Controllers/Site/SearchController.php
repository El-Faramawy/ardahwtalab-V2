<?php

namespace App\Http\Controllers\Site;

use App\Models\Advs_config;
use App\Models\Operations;
use App\Models\Props;
use App\Models\PropTypes;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Advs;
use App\Models\Images;
use App\Models\User;
use DB;
use App\Models\Area;
use App\Models\Depts;

class SearchController extends Controller
{

    private $config;

    public function __construct()
    {
        $this->config = Advs_config::first();
    }

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
            // ->when(request('to_date'), function ($query) {
            //     return $query->where('created_at', '<=', request('to_date'));
            // })
            ->when(request('order_type'), function ($query) use ($order_type) {
                if ($order_type == 'min_price') return $query->orderBy('price', 'asc');
                elseif ($order_type == 'max_price') return $query->orderBy('price', 'desc');
                else return $query->orderBy('id', 'desc');
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
        if (!$order_type) $data['advs'] = $data['advs']->latest();
        $data['advs_count'] = $data['advs']->count();
        $data['advs'] = $data['advs']->paginate($this->config->per_page);
        $data['areas']  = Area::where('country_id', '!=', null)->get();
        $data['depts']  =   Depts::where('parent_id', null)->get();
        return view('site.pages.category', $data);
    }

    public function getDetails(Request $request)
    {

        $info = Advs::where('is_deleted',0);
        if (request('item_id')) {
            $info = Advs::find(request('item_id'));
        }
        if ($request->has('dept') && request('dept') != '') {
            $super_parent = Depts::find($request->input('dept'))->super_parent;
            $info= Depts::where('parent_id',$request->input('dept'))->get();

            $props = Props::where(['dept_id' => $super_parent->id, 'parent' => NULL])->get();
            foreach ($props as $pr) {
                $pr->types = PropTypes::where('prop_id', $pr->id)->get();
            }
            return view('ajax.details', ['props' => $props, 'dept' => Depts::find(request('dept')), 'info' => $info]);
        } elseif ($request->has('proptype')) {
            $data = [];
            $parent = PropTypes::where('name', $request->input('proptype'))->first();
            $data['input'] = [];
            if ($parent) {
                $parent = $parent->id;
                $data['proptypes'] = PropTypes::where('parent', $parent)->get();
                $proptype = PropTypes::where('parent', $parent)->first();
                $proptype ? $data['input'] = Props::find($proptype->prop_id) : '';
            }
            $data['info'] = $info;
            return view('ajax.details', $data);
        } elseif ($request->has('type')) {
            $servs = Operations::find($request->input('type'));
            $servs = explode(',', $servs->props);
            return view('ajax.details', ['servs' => $servs]);
        } elseif ($request->has('country')) {
            $area = Area::where('country_id', $request->input('country'))->get();
            return view('ajax.details', ['area' => $area]);
        }
    }

    private function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        $geoIP  = json_decode(file_get_contents("http://api.ipstack.com/{$ip}?access_key=c106ebe2f340b943b99a1e8b254e04f7"), true);
        return [$geoIP['latitude'], $geoIP['longitude']];
    }
}
