<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lawyer;

class LawyerController extends Controller
{
    public function login()
    {
        $data = request()->only(['email', 'password']);
        $data['status'] = 1;
        if (auth('lawyer')->attempt($data)) {
            $lawyer = auth('lawyer')->user();
            $lawyer->api_token = str_random(60);
            $lawyer->save();
            $lawyer->category = $lawyer->category;
            return response()->json([
                'code'  =>  1,
                'message'   =>  '',
                'data'  =>  $lawyer
            ]);
        }
        return response()->json([
            'code'  =>  0,
            'message'   =>  'خطأ فى البريد الإلكترونى أو كملة المرور',
            'data'  =>  null
        ]);
    }

    public function signup()
    {
        $validator = \Validator::make(request()->all(), [
            'fullname' => 'required',
            'email'     =>  'email|required',
            'phones'    =>  'array|required|min:1',
            'category_id'   =>  'required|exists:law_categories,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'message' => 'invlaid data', 'data' => $validator->errors()]);
        }
        $data = request()->all();
        $data['status'] = -2;
        Lawyer::create($data);
        return response()->json([
            'code' => 1,
            'message' => 'تم ارسال بياناتك لمشرف الموقع وسيتم مراجعتها والتواصل معك فى أقرب وقت ممكن',
            'data' => null
        ]);
    }


    public function show($token)
    {
        $info = Lawyer::whereToken($token)->first();
        if (!$info) return response()->json(['code' => 0, 'message' => 'هذا المحامى ليس موجود', 'data' => null]);
        return response()->json(['code' => 1, 'message' => '', 'data' => $info]);
    }

    public function showByid($id)
    {
        $info = Lawyer::find($id);
        if (!$info) return response()->json(['code' => 0, 'message' => 'هذا المحامى ليس موجود', 'data' => null]);
        return response()->json(['code' => 1, 'message' => '', 'data' => $info]);
    }

    public function lawsuits()
    {
        $lawyer = auth('lawyer')->user();
        $accepted   = $lawyer->accepted_lawsuits()->get();
        $rejected   = $lawyer->rejected_lawsuits()->get();
        $pending    = $lawyer->pending_lawsuits()->get();
        $approved    = $lawyer->approved_lawsuits()->get();
        return response()->json([
            'code'      => 1,
            'message'   => '',
            'data'      => get_defined_vars()
        ]);
    }

    public function accept($id)
    {
        $data = [
            'lawsuit_id'    =>  $id,
            'lawyer_id'     =>  auth('lawyer')->user()->id
        ];
        $lawsuit = \DB::table('lawsuit_lawyer')->where($data)->first();
        if (!$lawsuit) return response()->json([
            'code' => 0,
            "message" => "هذه الدعوي غير موجودة",
            "data" => null
        ]);
        \DB::table('lawsuit_lawyer')->where($data)->update(['status' => 'accepted']);
        return response()->json([
            "code" => 1,
            "message" => "تم إرسال الموافقة للمشرف وسيتم مراجعتها والتأكيد عليها",
            "data" => null
        ]);
    }

    public function reject($id)
    {
        $data = [
            'lawsuit_id'    =>  $id,
            'lawyer_id'     =>  auth('lawyer')->user()->id
        ];
        $lawsuit = \DB::table('lawsuit_lawyer')->where($data)->first();
        if (!$lawsuit) return response()->json([
            'code' => 0,
            "message" => "هذه الدعوي غير موجودة",
            "data" => null
        ]);
        \DB::table('lawsuit_lawyer')->where($data)->update(['status' => 'rejected']);
        return response()->json([
            "code" => 1,
            "message" => "'تم رفض طلب الوساطة بنجاح'",
            "data" => null
        ]);
    }
}
