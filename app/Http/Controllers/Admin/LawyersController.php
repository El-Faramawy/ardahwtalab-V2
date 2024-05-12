<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\LawCategory;
use App\Models\Country;
use Illuminate\Validation\Validator;
use Config;

class LawyersController extends Controller
{
    private $country;
    private $config;
    private $sms;
    public function __construct()
    {
        $this->country = \App\Models\Country::orderBy('id', 'desc')->get();
        $this->config = \App\Models\SiteConfig::first();
        $this->sms = \DB::table('site_sms')->first();
        $mail = \App\Models\Site_mail::first();
        Config::set('mail.driver', $mail->driver);
        Config::set('mail.host', $mail->host);
        Config::set('mail.port', $mail->port);
        Config::set('mail.address', $mail->email);
        Config::set('mail.name', \App\Models\SiteConfig::first()->title);
        Config::set('mail.encryption', $mail->encryption);
        Config::set('mail.username', $mail->email);
        Config::set('mail.password', $mail->password);

        $this->middleware('role:lawyers');
    }
    public function index()
    {
        $lawyers = Lawyer::where('status', '!=', -2)->orderBy('id', 'desc')->get();
        return view('admin.lawyers.index', ['rows' => $lawyers]);
    }

    public function requests()
    {
        $lawyers = Lawyer::where('status', -2)->orderBy('id', 'desc')->get();
        return view('admin.lawyers.requests', ['rows' => $lawyers]);
    }
    public function create()
    {
        return view('admin.lawyers.create', ['rows' => Lawyer::all(), 'categories' => LawCategory::all(),'country'=>Country::all()]);
    }
    public function store(Request $request)
    {

        if (Lawyer::whereEmail(request('email'))->exists()) {
            return back()->with('error', 'هذا البريد مسجل من قبل')->withInput();
        }


        $data = $request->except('_token');
        $data['phones'] = array_filter($data['phones']);
        $data['token'] = str_random(60);
        $data['lawyer'] = $lawyer = Lawyer::create($data);


        //dd( $data['lawyer']);

       $mail =  \Mail::send('emails.lawyer', $data, function($message) use ($lawyer){
         $message->to($lawyer->email, $lawyer->fullname)->subject('إشعار من موقع عرض وطلب');
         $message->from($this->config->email,$this->config->title);
      });


       /* $mail = \Mail::send('emails.lawyer', $data, function ($m) use ($lawyer) {
            $m->from($this->config->email, $this->config->title);
            $m->to($lawyer->email, $lawyer->fullname)->subject('إشعار من موقع عرض وطلب');
        });*/
        // dd($mail,$lawyer->email,$lawyer->fullname,$this->config->email,$this->config->title);
        // dd($mail , $lawyer->email, $lawyer->fullname , $this->config->email, $this->config->title);
        return redirect()->route('lawyers.index', ['true' => "تم إضافة المحامى بنجاح وارسال ايميل انشاء كلمة المرور"]);
    }
    public function edit($id)
    {
        $lawyer = Lawyer::find($id);
        if ($process = request('process')) {
            if ($process == 'active') {
                if ($lawyer->status == -2) {
                    $data['lawyer'] = $lawyer;
                    $lawyer->status = 0;
                    $lawyer->token = str_random(60);
                    \Mail::send('emails.lawyer', $data, function ($m) use ($lawyer) {
                        $m->from($this->config->email, $this->config->title);
                        $m->to($lawyer->email, $lawyer->fullname)->subject('تفعيل حسابك وتعيين كلمة المرور');
                    });
                } else {
                    $lawyer->status = 1;
                }
            } elseif ($process == 'block') {
                $lawyer->status = -1;
            }
            $lawyer->save();
            return back();
        }
        $area = \App\Models\Area::where('country_id', $lawyer->country_id)->get();
        return view('admin.lawyers.edit', ['info' => $lawyer, 'rows' => Lawyer::all(), 'categories' => LawCategory::all(),'country'=>Country::all(),'area'=>$area]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $data['phones'] = array_filter($data['phones']);
        Lawyer::findOrFail($id)->update($data);
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }
}
