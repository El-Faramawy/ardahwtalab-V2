<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LawCategory;
use App\Lawsuit;

class LawsuitController extends Controller
{
    public function categories()
    {
        return response()->json(['code' => 1, 'message' => '', 'data' => LawCategory::where('parent_id', 0)->with('childs')->get()]);
    }

    public function txt()
    {
        return response()->json(['code' => 1, 'message' => '', 'data' => \App\SiteConfig::first()->lawsuit_txt]);
    }

    public function mylawsuits()
    {
        $user = auth('api')->user();
        $lawsuits = $user->lawsuits()->with('category' , 'area' , 'lawyer')->latest()->get();
        $array = [];
        $loop  = 0;
        foreach($lawsuits as $lawsuit) {
            $array[$loop] = $lawsuit;
            if(count($lawsuit->lawyer) > 0) {
                $array[$loop]->ChooseLawyer = $lawsuit->lawyer[0]->id;
            } else {
                $array[$loop]->ChooseLawyer = 0;
            }
            $loop++;
        }
        return response()->json(['code' => 1, 'message' => '', 'data' => $array]);
    }

    public function show($id)
    {
        $user = auth('api')->user();
        $lawsuit = $user->lawsuits()->with('category' , 'area' , 'lawyer')->findOrFail($id);
        $link = $this->payment($user,$id);
        return response()->json(['code' => 1, 'message' => '', 'data' => $lawsuit,'link'=>$link]);
    }

    public function lawsuit_lawyer($id)
    {
        $check   = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $id)->where('status','!=','pending')->where('approved', 1)->first();
        $lawyers = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $id)->where('status','!=','pending')->where('choose', 1)->get();
        $data = [
                'lawyers'   =>  $lawyers,
                'check'     =>  (!is_null($check)) ? $check->id : 0,
            ];
        return response()->json(['code' => 1, 'message' => '', 'data' => $data]);
    }

    public function lawyer_choose($lawyer_id,$lawsuit_id)
    {
        $lawyers = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit_id)->where('choose', 1)->get();
        $check   = 0;
        foreach($lawyers as $lawyer) {
            if($lawyer->approved == 1) {
              $check = 1;  
            }
        }
        if($check == 1) {
            return response()->json(['code' => 0, 'message' => 'تم إختيار محامي لهذه القضيه من قبل']);
        }
        \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit_id)->where('lawyer_id', $lawyer_id)->update(['approved'=>1]);
        \DB::table('lawsuits')->where('id', $lawsuit_id)->update(['status'=>'wait_payment']);
        return response()->json(['code' => 1, 'message' => '']);
    }

    public function create()
    {
        $validator = \Validator::make(request()->all(), [
            'category_id'   =>  'required|exists:law_categories,id',
            'area_id'   =>  'required|exists:area,id',
            'address'   =>  'required',
            'content'   =>  'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'message' => 'invalid data', 'data' => $validator->errors()]);
        }
        auth('api')->user()->lawsuits()->create(request()->all());
        return response()->json(['code' => 1, 'message' => 'تم انشاء الدعوي بنجاح', 'data' => null]);
    }
    
    public function payment($user,$id) {
        $lawsuit = $user->lawsuits()->findOrFail($id);
        session()->put('lawsuit', $lawsuit);
        $total = $lawsuit->category->cost;
        $products = [];
        $products[] = [
            "ProductId" => null,
            "ProductName" => "إظهار بيانات المحامى",
            "Quantity" => 1,
            "UnitPrice" => $total,
        ];
        $invoice_params = [
            "InvoiceValue" => $total,
            "CustomerName" => $user->username,
            "CustomerMobile" => $user->phone,
            "CustomerEmail" => $user->email,
            "SendInvoiceOption" => 1,
            'DisplayCurrencyIsoAlpha' => 'SAR',
            'CountryCodeId' => '+966',
            'DisplayCurrencyId' => 2,
            "InvoiceItemsCreate" => $products,
            "CallBackUrl" => url('api/payment_callback'),
            "Language" => 1,
        ];
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $result = $myfatoora->createProductInvoice($invoice_params);
        return isset($result['RedirectUrl']) ? $result['RedirectUrl'] : url('/');
    }
    
    public function payment_callback($data = null)
    {
        $lawsuit = session('lawsuit');
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $callback = $myfatoora->callback();
        if ($callback == 'faliure') {
            return redirect()->to('/')->with('error', "فشل عملية الدفع");
        }
        $lawsuit->update(['status' => 'lawyer_hired']);
        session()->forget('lawsuit');
        return response()->json(['code' => 1, 'message' => 'تم الدفع بنجاح', 'data' => null]);
    }
}
