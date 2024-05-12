<?php

namespace App\Http\Controllers\Api;

use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Advs;
use App\Sliders;
use Auth;
use App\Likes;
use App\Paymethods;
use Validator;
use Watermark;
use Googl;

//use Response;
class HomeController extends Controller
{
    private $notfs;
    public $json_arr;
    public $api_config;
    public $site_config;

    public function __construct()
    {
        $this->notfs = [];
        $this->json_arr['message'] = 'success';
        $this->json_arr['code'] = 1;
        $this->api_config = \App\Advs_config::first();
        $this->site_config = \App\SiteConfig::first();
    }

    public function commision()
    {
        $array['commision']['commision']        = (int) $this->api_config->commision;
        $array['commision']['commision_seller'] = $this->api_config->commision_seller;
        $array['commision']['commision_buyer']  = $this->api_config->commision_buyer;
        $array['pay']                           = Paymethods::all();
        return response()->json(['data' => $array]);
    }

    public function pay_methods()
    {
        // pay_methods
        $pay = Paymethods::all();
        return response()->json(['data' => $pay]);
    }

    public function BankTransfer()
    {
        $Request = Request()->all();
        $rules   = [
            'user_id'       => 'required',
            'name'          => 'required',
            'bank'          => 'required',
            'send_date'     => 'required',
            'send_data'     => 'required',
            'notes'         => 'required',
        ];
        $validator = Validator::make($Request, $rules);
        if ($validator->fails()) {
            $x = 0;
            foreach ($validator->errors()->toArray() as $k => $v) {
                $errors[$x]['key'] = $k;
                $errors[$x]['value'] = $v[0];
                $x++;
            }
            $data = [];
            return response()->json(['success' => 0, 'errors' => $errors]);
        } else {
            \App\Pays::insert(request()->only([
                'user_id',
                'name',
                'bank',
                'send_date',
                'send_data',
                'notes',
            ]));
            $errors = [];
            return response()->json(['success' => 1, 'errors' => $errors]);
        }
    }

    public function index(Request $request, $type = null)
    {
        //    $sliders = new Sliders;
        //    $this->json_arr['data']['slider'] =  $sliders->where(['active' => 1])->orderBy('id', 'desc')->get();
        //    $this->json_arr['data']['paypal'] =  $this->site_config->paypal;

        $where = [];
        // if ($type == 'sale') {
        //     $where['type'] = 1;
        // } elseif ($type == 'buy') {
        //     $where['type'] = 3;
        // } elseif ($type == 'bid') {
        //     $where['type'] = 2;
        // }
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
        if (!empty($where)) {
            $advs = $advs->where($where);
        }
        $data = $advs->where('is_deleted',0)->orderBy('id', 'DESC')->paginate(15);
        foreach ($data as $dt) {
            // dd($dt);
            $dt = $this->show_advs_data($dt);
        }
        foreach ($data as $key => $da) {
            $this->json_arr['data'][$key] = $da;
            // $main_image = 'no_image';
            // if($image = $da->imgs->first() ){
            //     $main_image = $image->image;
            // }


            // $this->json_arr['data']['advs'][$key]['main_image'] = $main_image;
        }

        $this->json_arr['pagnation'] = api_model_set_pagenation($data);
        // empty($this->json_arr['data']) ? $this->json_arr['data'] = [] : '';
        // $whatsapp = \App\SiteContacts::where('type' , 'whats')->first();
        // $this->json_arr['data']['whatsapp'] = $whatsapp ? $whatsapp->value : '';
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
        $data->user->image = url('/') . $data->user->image;
        $data->user->check_documentation = $data->user->check_doc;
        
        $rates = \App\Rates::where('user_rated',$data->user->id)->count();
        $rate  = \App\Rates::where('user_rated',$data->user->id)->sum('rate');
        if($rates == 0) {
            $data->user->rate = 0;
        } else {
            $data->user->rate = $rate / $rates;    
        }
        
        
        
        $data->main_options = $data->main_options;
        $data->details = $output;
        $data->dept = $data->getdept()->first()->name;
        $data->country = $data->getcountry()->first()->name;
        $data->area = $data->getarea()->first()->name;
        $data->time_ago = time_ago($data->created_at);
        $link = route('advertise.show', [$data->id, $data->slug]);
        // require_once('googl-php-master/Googl.class.php');
        // $googl = new Googl('AIzaSyDGYH1WajbEd1Wvq_-VSy2YrKYG5YbG45E');
        // $data->link = $googl->shorten($link);
        // unset($googl);
        $data->link = $link;
        $like = Likes::where(['advs_id' => $data->id, 'user_id' => request('user_id')])->first();
        $like ? $data->like = 1 : $data->like = 0;
        $data->main_image = $data->image;
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
    
    public function commision_store() {
        $request = request()->all();
        if(empty($request)) {
            return response()->json([
                'success'   => 0, 
                'errors'    => ['error'=>'برجاء إدخال كافه البيانات المطلوبة'],
                'data'      => []
            ]);
        }
        if(!array_key_exists('price',$request)) {
            return response()->json([
                'success'   => 0, 
                'errors'    => ['error'=>'برجاء إدخال سعر الإعلان'],
                'data'      => []
            ]);
        }
        if(!array_key_exists('user_id',$request)) {
            return response()->json([
                'success'   => 0, 
                'errors'    => ['error'=>'برجاء إدخال رقم المستخدم'],
                'data'      => []
            ]);
        }
        if($request['price'] == '') {
            return response()->json([
                'success'   => 0, 
                'errors'    => ['error'=>'برجاء إدخال سعر الإعلان'],
                'data'      => []
            ]);
        }
        $adv = null;
        if(array_key_exists('adv_id',$request) && $request['adv_id'] != '') {
            $adv = \App\Advs::find($request['adv_id']);
            if(is_null($adv)) {
                return response()->json([
                    'success'   => 0, 
                    'errors'    => ['error'=>'هذا الإعلان غير موجود لدينا'],
                    'data'      => []
                ]);
            }
            if($adv->is_deleted == 1) {
                return response()->json([
                    'success'   => 0, 
                    'errors'    => ['error'=>'هذا الإعلان تم مسحه بيانات الموقع'],
                    'data'      => []
                ]);
            }
            if($adv->active == 0) {
                return response()->json([
                    'success'   => 0, 
                    'errors'    => ['error'=>'هذا الإعلان لم يتم تفعيلة'],
                    'data'      => []
                ]);
            }
        }
        $user = \App\User::find($request['user_id']);
        if(!$user) {
            return response()->json([
                'success'   => 0, 
                'errors'    => ['error'=>'هذا المستخدم غير موجود لدينا'],
                'data'      => []
            ]);
        }
        $commision_store = [
            'user_id'   => $user->id,
            'adv_id'    => (is_null($adv)) ? 0 : $adv->id,
            'price'     => $request['price'],
            ];
        session()->put('commision_store', $commision_store);
        $products[] = [
            "ProductId" => null,
            "ProductName" => "حساب العمولة",
            "Quantity" => (int)1,
            "UnitPrice" => (float)$request['price'],
        ];
        $invoice_params = [
            "InvoiceValue" => (float)$request['price'],
            "CustomerName" => $user->username,
            "CountryCodeId" => 1,
            "CustomerMobile" => $user->phone,
            "CustomerEmail" => $user->email,
            "DisplayCurrencyId" => 1,
            "SendInvoiceOption" => 1,
            'DisplayCurrencyIsoAlpha' => 'SAR',
            'CountryCodeId' => '+966',
            'DisplayCurrencyId' => 2,
            "InvoiceItemsCreate" => $products,
            "CallBackUrl" => route('commision.back'),
            "Language"=> 1,
        ];
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $result = $myfatoora->createProductInvoice($invoice_params);
        
        
        if(isset($result['RedirectUrl'])) {
            return response()->json([
                'success'   => 1, 
                'errors'    => [],
                'data'      => $result['RedirectUrl']
            ]);
        } else {
            return response()->json([
                'success'   => 0, 
                'errors'    => ['link'=>(string) $result["Message"]],
                'data'      => []
            ]);
        }
    }
}
