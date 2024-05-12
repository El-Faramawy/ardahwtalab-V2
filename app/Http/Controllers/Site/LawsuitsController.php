<?php

namespace App\Http\Controllers\Site;

use App\Models\Area;
use App\Http\Controllers\Controller;
use App\Models\LawCategory;
use App\Models\Lawsuit;
use App\Models\Lawyer;
use App\Models\Notfs;
use App\Models\SiteConfig;
use Config;

class LawsuitsController extends Controller
{
    private $config;
    private $sms;
    public function __construct()
    {
        $this->config = SiteConfig::first();
        $this->sms = \DB::table('site_sms')->first();
        $this->middleware('auth')->except(['accept' , 'reject']);
        // $this->middleware('auth:lawyer')->only(['accept', 'reject']);
    }
    public function index()
    {
        $rows = auth()->user()->lawsuits()->latest()->paginate(20);
        return view('site.lawsuits.index', compact('rows'));
    }

    public function create($category_id)
    {
        $category = LawCategory::findOrFail($category_id);
        $categories = LawCategory::where('parent_id', 0)->get();
        $areas = Area::where('country_id', '!=', null)->get();
        return view('site.lawsuits.create', get_defined_vars());
    }

    public function get_childs()
    {
        $childs = LawCategory::find(request('id'))->childs;
        if (count($childs)) {
            $text = "<select class='form-control selectpicker' name='category_id' data-live-search='true'>";
            foreach ($childs as $child) {
                $text .= "<option value='{$child->id}'>{$child->name}</option>";
            }
            $text .= "</select>";
            return $text;
        }
    }

    public function store()
    {

        if (!request('content') || request('content') == '') {
            return back()->with('error', 'يجب ادخال وصف الطلب أولاً');
        }

        $data = request()->all();
        $array = [];
        if(isset($data['file'])){
            foreach($data['file'] as $file){
                $logo = time()+rand(0,99999) . '.' . $file->extension();
                $file->move(('files'.'/'.date('Y-m-d').'/'), $logo);
                $image1 = '/files/'.'/'.date('Y-m-d').'/'. $logo;
                array_push($array,secure_asset($image1));
            }

          $data['files']  = json_encode($array);

        }

        $data['category_id'] = $data['category_id'] ?? null;
        auth()->user()->lawsuits()->create($data);
        return redirect()->route('lawsuits.index')->with([
            'title' => 'تم استقبال طلبكم بنجاح ',
            'text' => 'سيتم مراجعة طلبكم من قبل مشرف الموقع والرد عليكم فى أقرب وقت ممكن ... علماً بأنه يمكنكم متابعة حالة الطلب عن طريق لوحة التحكم الخاصة بكم .'
        ]);
    }


    public function show($id)
    {
        $law = Lawsuit::findOrFail($id);
        return view('site.lawsuits.show', ['law' => $law]);
    }

    public function lawsuit_lawyer_show($id)
    {

        $lawyers = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $id)->where('choose', 1)->get();
        return view('site.lawsuits.lawsuit_lawyer_show', ['lawyers' => $lawyers]);
    }

    public function lawsuit_lawyer_show_admin($lawsuit, $lawyer)
    {
        $lawyer = \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit)->where('lawyer_id', $lawyer)->first();
        return view('site.lawsuits.lawsuit_lawyer_show_admin', ['lawyer' => $lawyer]);
    }

    public function approve_lawyer_choose($id)
    {
        $lawsuit = \DB::table('lawsuit_lawyer')->where('id', $id);
        $lawsuit->update(['approved' => 1]);
        Lawsuit::find($lawsuit->first()->lawsuit_id)->update(['status' => 'wait_payment']);
        $lawsuit_lawyer = $lawsuit->first();
        $lawyer = Lawyer::find($lawsuit_lawyer->lawyer_id);
        $lawsuit = $data['lawsuit'] = Lawsuit::find($lawsuit_lawyer->lawsuit_id);
        $notfs['user_id'] = $lawsuit->user_id;
        $notfs['link'] = route('lawsuits.index');
        $notfs['text'] = "تم تعيين محامي لمتابعة الدعوى الخاصة بك يرجي الدفع للتواصل مع المحامي";
        Notfs::insert($notfs);

        // Send mail
        $data['lawyer'] = $lawyer;
        $data['text']   = str_replace(['[NAME]','[EMAIL]'],[$lawyer->fullname,$lawyer->email],$this->config->appoint_msg);
        \Mail::send('emails.lawsuit_approved' , $data , function($m) use($lawyer){
            // $m->from($this->config->email, $this->config->title);
            $m->to($lawyer->email, $lawyer->fullname)->subject(" إشعار بإسناد طلب العميل");
        });
        \Mail::send('emails.appoint', $data, function ($m) use ($lawsuit) {
            // $m->from($this->config->email, $this->config->title);
            $m->to($lawsuit->user->email, $lawsuit->user->username)->subject("إشعار بإسناد الطلب");
        });

        return back()->with('success', 'تم تعيين المحامى');
    }

    public function accept($id, $token)
    {
        $lawyer = Lawyer::whereToken($token)->first();
        $Dexter = Lawsuit::find($id);

        $data = [
            'lawsuit_id'    =>  $id,
            'lawyer_id'     =>  $lawyer->id
        ];
        if ($case = \DB::table('lawsuit_lawyer')->where($data)->where('status', '!=', 'pending')->first()) {
            return redirect()->to('/')->with('warning', 'سبق الرد على هذه الرسالة ، علماً بأن القبول أو الرفض لا يرتب أي التزام عليكم');
        }
        if (request()->isMethod('get')) {
            $type = 'accept';
            $title = "نموذج الموافقة على تولي الدعوي";
            return view('site.lawsuits.action',['data'=>$Dexter,'title'=>'نموذج الموافقة على تولي الدعوي'] );
            // return view('site.lawsuits.action',get_defined_vars() );
        }
        $lawsuit = \DB::table('lawsuit_lawyer')->where($data)->first();

        if (!$lawsuit) \App::abort(404);
        $Dexter->update(['notes' => request('notes')]);
        \DB::table('lawsuit_lawyer')->where($data)->update([
            'status' => 'accepted',
            'fees' => request('fees'),

            'percentage' => request('percentage')
        ]);
        return redirect()->to('/')->with('success', 'تم إرسال الموافقة للمشرف وسيتم مراجعتها والتأكيد عليها');
    }

    public function reject($id, $token)
    {
        $lawyer = Lawyer::whereToken($token)->first();
        if(!$lawyer) abort('404');
        $data = [
            'lawsuit_id'    =>  $id,
            'lawyer_id'     =>  $lawyer->id
        ];
        if ($case = \DB::table('lawsuit_lawyer')->where($data)->where('status', '!=', 'pending')->first()) {
            return redirect()->to('/')->with('warning', 'سبق الرد على هذه الرسالة ، علماً بأن القبول أو الرفض لا يرتب أي التزام عليكم');
        }
        $lawsuit = \DB::table('lawsuit_lawyer')->where($data)->first();
        if (!$lawsuit) abort(404);
        \DB::table('lawsuit_lawyer')->where($data)->update(['status' => 'rejected']);
        return redirect()->to('/')->with('success', 'تم رفض طلب الوساطة بنجاح');
    }

    public function payment_for_lawyer($id)
    {
        $lawsuit = auth()->user()->lawsuits()->findOrFail($id);
        session()->put('lawsuit', $lawsuit);
        $total = $lawsuit->category->cost;
        $user = auth()->user();
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
            "CallBackUrl" => route('payment_callback'),
            "Language" => 1,
        ];
        $myfatoora = new \App\Http\Controllers\MyFatoora;
        $result = $myfatoora->createProductInvoice($invoice_params);
        // dd($result);
        return isset($result['RedirectUrl']) ? redirect()->to($result['RedirectUrl']) : back()->with('error', (string) $result["Message"]);
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
        return redirect()->route('lawyer.show', $lawsuit->lawyer()->first()->id);
    }
}
