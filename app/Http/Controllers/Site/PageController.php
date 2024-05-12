<?php

namespace App\Http\Controllers\Site;

use App\Models\Advs;
use App\Models\Advs_config;
use App\Models\CommissionReports;
use App\Models\Contactus;
use App\Models\Jobs;
use App\Models\Jointypes;
use App\Models\Paymethods;
use App\Models\Pays;
use App\Models\SiteContacts;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\Subscription ;
use Carbon\Carbon;
use App\Models\Members;

class PageController extends Controller {

    public function getjoins(Request $request, $type) {
        $data['joins'] = Jointypes::all();
        $data['type'] = $type;
        if (!$request->except('_token')) {
            return view('site.pages.request-join', $data);
        }
        $validator = Validator::make($request->all(), ['captcha' => 'captcha']);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'كلمة الكابتشا غير متطابقة');
        }
        $data = $request->except(['_token', 'captcha']);
        $data['user_id'] = Auth::user()->id;
        \App\Joins::insert($data);
        return redirect()->back()->with('message', 'تم ارسال الطلب للمشرف');
    }

    public function joins() {
        $data['jointypes'] = Jointypes::all();
        return view('site.pages.joins', $data);
    }

    public function banking() {
        $data['banks'] = Paymethods::all();
        return view('site.pages.banking', $data);
    }

    public function commision() {
        $data['banks'] = Paymethods::all();
        $data['info'] = Advs_config::first();
        // dd('commision',$data);
        return view('site.pages.commision', $data);
    }

    public function jobs(Request $request) {

        $data = $request->except(['_token', 'file']);
        if (!$data) {
            return view('site.pages.jobs');
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'file' => 'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/*,application/pdf,application/msword,text/html',
                ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد مطلوب',
            'email.email' => 'البريد غير صحيح',
            'mobile.required' => 'الهاتف مطلوب',
            'mobile.numeric' => 'الهاتف غير صحيح',
            'file.mimetypes' => 'الملف المرفق غير صحيح',
                ]
        );
        $jobsDir = public_path() . DIRECTORY_SEPARATOR . 'uplaods' . DIRECTORY_SEPARATOR . 'jobs';
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $request->file('file')->move($jobsDir, $request->file('file')->getClientOriginalName());
            $data['file'] = $request->file('file')->getClientOriginalName();
        }else{
            $data['file'] = '';
        }
        Jobs::insert($data);
        return redirect()->back()->with('message', 'تم ارسال الطلب للمشرف');
    }

    public function transfer(Request $request) {
        $data = $request->except('_token');
        $info['banks'] = \App\Paymethods::all();
        if (!$data) {
            return view('site.pages.transfer', $info);
        }
        $data['user_id'] = Auth::user()->id;
        // dd($data);
        Pays::insert($data);
        return redirect()->back()->with('message', 'تم ارسال الطلب للمشرف');
    }

    public function contactus(Request $request) {
        $info['contacts'] = SiteContacts::all();
        $data = $request->except('_token');
        if (!$data) {
            return view('site.pages.contactus', $info);
        }
        $validator = Validator::make($request->all(), ['captcha' => 'captcha']);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'كلمة التحقق غير متطابقة');
        }
        unset($data['captcha']);
        Contactus::insert($data);
        return redirect()->back()->with('true', 'تم إرسال الرسالة بنجاح');
    }

    public function error($type = null) {
        if ($type == 'not_allowed') {
            return view('errors.not_allowed');
        }
        return view('error.error');
    }

    public function commision_post() {
        $request = request()->all();
    /*     // Members
         if(isset($request['member_id'])){

             $members = Members::findOrFail($request['member_id']);

             $request['price'] = $members->price ;
             $commision_store = [
            'user_id'   => $request['user_id'],
            'member_id'    =>  $request['member_id'],
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
            "CustomerName" => Auth::user()->username,
            "CountryCodeId" => 1,
            "CustomerMobile" => Auth::user()->phone,
            "CustomerEmail" => Auth::user()->email,
            "DisplayCurrencyId" => 1,
            "SendInvoiceOption" => 1,
            'DisplayCurrencyIsoAlpha' => 'SAR',
            'CountryCodeId' => '+966',
            'DisplayCurrencyId' => 2,
            "InvoiceItemsCreate" => $products,
            "CallBackUrl" => route('commision.back'),
            "Language"=> 1,
            "member_id" =>  $request['member_id'] ,
        ];
         //dd($request,$commision_store,$products,$invoice_params);
        // dd($invoice_params);
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $result = $myfatoora->createProductInvoice($invoice_params);
       dd($result , $invoice_params);
        return isset($result['RedirectUrl']) ? redirect()->to($result['RedirectUrl']) : back()->with('error', (string) $result["Message"]);




/////////////////////////////////////////////////////////////////


         }*/

             $subscription = Subscription::findOrFail($request['subscription_id']);
        $advirtise = Advs::findOrFail($request['adv_id']);
        // dd($advirtise);
        // dd($request , $subscription , $advirtise);
        $request['price'] = $subscription->price ;
        $request['adv_price'] = $subscription->price ;
        // dd($request);
        if($request['price'] ==  0){
            $advirtise->update([
                'active' => 1 ,
                'subscription_id' => $subscription->id ,
                'end_date' =>  Carbon::now()->addHour($subscription->duration) ,
                ]);
            return redirect()->route('advertise.show' , ['slug' => $advirtise->slug , 'id' => $advirtise->id]);
        }
        if(empty($request)) {
            return redirect()->back()->withInput()->with('error', 'برجاء إدخال كافه البيانات المطلوبة');
        }
        if(!array_key_exists('price',$request)) {
            return redirect()->back()->withInput()->with('error', 'برجاء إدخال سعر الإعلان');
        }
        if($request['price'] == '') {
            return redirect()->back()->withInput()->with('error', 'برجاء إدخال سعر الإعلان');
        }
        $adv = null;
        if(array_key_exists('adv_id',$request) && $request['adv_id'] != '') {
            $adv = Advs::find($request['adv_id']);
            if(is_null($adv)) {
                return redirect()->back()->withInput()->with('error', 'هذا الإعلان غير موجود لدينا');
            }
            if($adv->is_deleted == 1) {
                return redirect()->back()->withInput()->with('error', 'هذا الإعلان تم مسحه بيانات الموقع');
            }
            if($adv->active == 1) {
                return redirect()->back()->withInput()->with('error', 'هذا الاعلان تم تفعيله');
            }
        }
        $commision_store = [
            'subscription_id' => $subscription->id ,
            'user_id'   => Auth::user()->id,
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
            "CustomerName" => Auth::user()->username,
            "CountryCodeId" => 1,
            "CustomerMobile" => Auth::user()->phone,
            "CustomerEmail" => Auth::user()->email,
            "DisplayCurrencyId" => 1,
            "SendInvoiceOption" => 1,
            'DisplayCurrencyIsoAlpha' => 'SAR',
            'CountryCodeId' => '+966',
            'DisplayCurrencyId' => 2,
            "InvoiceItemsCreate" => $products,
            "CallBackUrl" => route('commision.back'),
            "Language"=> 1,
            "adv_id" =>  $adv->id ,
        ];
        // dd($invoice_params);
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $result = $myfatoora->createProductInvoice($invoice_params);
        // dd($result , $invoice_params);
        return isset($result['RedirectUrl']) ? redirect()->to($result['RedirectUrl']) : back()->with('error', (string) $result["Message"]);





    }

    public function payment_callback($data = null){

        if(is_null($data)) {
            return redirect()->route('home');
        }

        $commision_store = session('commision_store');
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $callback = $myfatoora->callback();
        dump($callback);
        if ($callback == 'faliure') {
            return redirect()->to('/commision')->with('error', "فشل عملية الدفع");
        }
        if($commision_store['adv_id'] == 0) {
            CommissionReports::create([
                'user_id'   => $commision_store['user_id'],
                'order_id'  => request('paymentId',''),
                'price'     => $commision_store['price'],
                ]);
        } else {
            CommissionReports::create([
                'user_id'   => $commision_store['user_id'],
                'adv_id'    => $commision_store['adv_id'],
                'order_id'  => request('paymentId',''),
                'price'     => $commision_store['price'],
                ]);
        }
        session()->forget('commision_store');
        return redirect()->route('commision')->with('true', 'تم الدفع بنجاح');
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    // Dexter
    public function commision_post_Dex() {
        $request = request()->all();
        // Members
             $members = Members::findOrFail($request['member_id']);

             $request['price'] = $members->price ;
             $commision_store = [
            'user_id'   => $request['user_id'],
            'member_id'    =>  $request['member_id'],
            'price'     => $request['price'],
            ];

        session()->put('Member_store', $commision_store);
        $products[] = [
            "ProductId" => null,
            "ProductName" => "حساب العمولة",
            "Quantity" => (int)1,
            "UnitPrice" => (float)$request['price'],
        ];

        $invoice_params = [
            "InvoiceValue" => (float)$request['price'],
            "CustomerName" => Auth::user()->username,
            "CountryCodeId" => 1,
            "CustomerMobile" => Auth::user()->phone,
            "CustomerEmail" => Auth::user()->email,
            "DisplayCurrencyId" => 1,
            "SendInvoiceOption" => 1,
            'DisplayCurrencyIsoAlpha' => 'SAR',
            'CountryCodeId' => '+966',
            'DisplayCurrencyId' => 2,
            "InvoiceItemsCreate" => $products,
            "CallBackUrl" => route('payment_callback_DEx'),
            "Language"=> 1,
            "member_id" =>  $request['member_id'] ,
        ];
         //dd($request,$commision_store,$products,$invoice_params);
        // dd($invoice_params);
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $result = $myfatoora->createProductInvoice($invoice_params);
        return isset($result['RedirectUrl']) ? redirect()->to($result['RedirectUrl']) : back()->with('error', (string) $result["Message"]);

    }

    public function payment_callback_DEx(Request $request,$data = null){

        $commision_store = session('Member_store');

        $members = Members::findOrFail($commision_store['member_id']);

        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $callback = $myfatoora->callback();
       // dd($commision_store,$members,$myfatoora,$callback);
       // dd($callback,$commision_store['user_id'],$members['time']);
       $Time = intval($members['time']);

        if ($callback == 'faliure') {
            return redirect()->to('/members')->with('error', "فشل عملية الدفع");
        }
           /*  \App\CommissionReports::create([
                'user_id'   => $commision_store['user_id'],
                'member_id'    => $commision_store['member_id'],
                'order_id'  => '',
                'price'     => $commision_store['price'],
                ]);*/
          $Time = intval($members['time']);
         // dd($callback,$commision_store,$members['time'],$commision_store['user_id']);
         $newDAte = date('Y-m-d', strtotime('+'.$Time.' months'));
        $user = User::find($commision_store['user_id']);
        $user->Expire_Date = $newDAte;
        $user->save();

        session()->forget('Member_store');
        return redirect()->route('select-members')->with('true', 'تم الدفع بنجاح');
    }

}
