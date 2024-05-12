<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\LawCategory;
use App\Models\Lawyer;

class LawyerController extends Controller
{
    public function login()
    {
        if (request()->isMethod('get')) {
            return view('auth.lawyer_login');
        }
        $data = request()->only(['email', 'password']);
        if (auth('lawyer')->attempt($data)) {
            return redirect()->route('lawyer.lawsuits');
        }
        return back()->with('error', 'البريد الإلكترونى أو كلمة المررو خاطئة');
    }

    public function signup()
    {
        if (request()->isMethod('get')) {
            return view('auth.lawyer_singup', ['categories' => LawCategory::where('parent_id', 0)->get()]);
        }
        $validator = \Validator::make(request()->all(), [
            'fullname' => 'required',
            'email'     =>  'email|required',
            'phones'    =>  'array|required|min:1',
            'category_id'   =>  'required|exists:law_categories,id'
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = request()->all();
        $data['status'] = -2;
        Lawyer::create($data);
        return back()->with('true', 'تم ارسال بياناتك لمشرف الموقع وسيتم مراجعتها والتواصل معك فى أقرب وقت ممكن');
    }

    public function logout()
    {
        auth('lawyer')->logout();
        return redirect()->route('lawyer_login');
    }

    public function active($token)
    {
        $lawyer = Lawyer::whereToken($token)->first();
        if (!$lawyer) abort(404);
        $lawyer->status = 1;
        $lawyer->save();
        return redirect()->to('/')->with('true', 'تم إستلام البيانات بنجاح');
        // if ($password = request('password')) {
        //     $lawyer->password = bcrypt($password);
        //     $lawyer->status = 1;
        //     $lawyer->save();
        //     auth('lawyer')->login($lawyer);
        //     return redirect()->to('/')->with('true', 'تم تفعيل حسابك وتعيين كلمة المرور بنجاح');
        // }
        // return view('site.lawyers.active');
    }


    public function show($id)
    {
        $info = Lawyer::find($id);
        if (!$info) abort(404);
        return view('site.lawyers.show', compact('info'));
    }

    public function lawsuits()
    {
        $lawyer = auth('lawyer')->user();
        $type = request('type');
        $title = "طلبات الوساطة القانوينة";
        if ($type == 'accepted') {
            $title = "طلبات بانتظار تأكيد المشرف";
            $rows = $lawyer->accepted_lawsuits()->get();
        } elseif ($type == 'rejected') {
            $title = "طلبات مرفوضة";
            $rows = $lawyer->rejected_lawsuits()->get();
        } elseif ($type == 'pending') {
            $title = "طلبات جديدة";
            $rows = $lawyer->pending_lawsuits()->get();
        } else {
            $title = "طلباتي";
            $rows = $lawyer->approved_lawsuits()->get();
        }
        return view('site.lawyers.lawsuits', get_defined_vars());
    }
}
