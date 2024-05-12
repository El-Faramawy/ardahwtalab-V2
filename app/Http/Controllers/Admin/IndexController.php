<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Advs_config;
use App\Models\Message;
use Auth;

class IndexController extends Controller {

    private $site_config;
    private $contacts;
    private $sms;
    private $mail;
    private $systems;

    public function __construct() {
        $this->site_config = DB::table('site_config')->where('id', 1);
        $this->contacts = DB::table('site_contacts');
        $this->sms = DB::table('site_sms')->where('id', 1);
        $this->mail = DB::table('site_mail')->where('id', 1);
        $this->systems = DB::table('site_systems');
    }

    public function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }
    // Dexter
     public function site_Message(Request $request) {
          $getData = \App\Models\Message::first();
         if($request->isMethod('post')){
             // update
             $getData->message = $request['content'];
             $getData->save();
             return redirect()->route('message')->with('true',' ');

         }else{
             return view('admin.config.message', ['data' => $getData]);
         }


    }
/////////////////////////////////////////////////////////////////
    // Dexter

    public function home() {
        $data['advs'] = \App\Models\Advs::where(['active' => 1])->orderBy('id', 'desc')->take(5)->get();
        $data['not_advs'] = \App\Models\Advs::where(['active' => 0])->orderBy('id', 'desc')->take(5)->get();
        $data['users'] = \App\Models\User::where(['active' => 1])->orderBy('id', 'desc')->take(5)->get();
        $advs = \App\Models\Advs::groupBy('user_id')->get();
        $most_users = [];
        foreach ($advs as $ad) {
            $most_users[] = ['username' => $ad->user->username, 'count' => \App\Models\Advs::where('user_id', $ad->user_id)->count()];
        }
        usort($most_users, $this->build_sorter('count'));
        $data['most_users'] = array_reverse($most_users);
        return view('admin.home', $data);
    }

    public function remove(Request $request) {
        $data = $request->except('_token');
        if($data['table'] == 'advs') {
            $adv = DB::table('' . $data['table'] . '')->where('id', $data['id'])->first();
            if(!is_null($adv)) {
                if($adv->is_deleted == 1) {
                    DB::table('' . $data['table'] . '')->where('id', $data['id'])->delete();
                } else {
                    DB::table('' . $data['table'] . '')->where('id', $data['id'])->update(['is_deleted'=>1]);
                }
            }
        } else {
            DB::table('' . $data['table'] . '')->where('id', $data['id'])->delete();
        }
        return 1;
    }

    public function site_config(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.site_config', ['info' => $this->site_config->first()]);
        }
        $logo = $request->file('logo');
        $favicon = $request->file('favicon');
        $logo ? $data['logo'] = uploadImage($logo, null, null) : '';
        $favicon ? $data['favicon'] = uploadImage($favicon, 50, 50) : '';
        $this->site_config->update($data);
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

    public function contacts(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.contacts', ['contacts' => $this->contacts->get()]);
        }
        $this->contacts->truncate();
        $i = 0;
        foreach ($data['type'] as $tp) {
            if ($data['value'][$i] && $data['value'][$i] != '' && $data['value'][$i] != ' ') {
                $this->contacts->insert([
                    'type' => $data['type'][$i],
                    'class' => $data['class'][$i],
                    'value' => $data['value'][$i]
                ]);
            }
            $i++;
        }
        return redirect()->back()->with('true', "تم التعديل بنجاح");
    }

    public function systems(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.systems', ['systems' => $this->systems->get()]);
        }
        foreach ($data as $key => $active) {
            DB::table('site_systems')->where('type', $key)->update(['active' => $active]);
        }
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

    public function sms(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.sms', ['info' => $this->sms->first()]);
        }
        $this->sms->update($data);
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

    public function mail(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.mail', ['info' => $this->mail->first()]);
        }
        $this->mail->update($data);
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

    public function apps(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.apps', ['info' => $this->site_config->first()]);
        }
        $this->site_config->update($data);
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

    public function close(Request $request) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.close', ['info' => $this->site_config->first()]);
        }
        $request->has('close') ? $data['close'] = '1' : $data['close'] = '0';
        $this->site_config->update($data);
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

    public function advs_config(Request $request, $view) {
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.advs.' . $view . '', ['info' => Advs_config::first()]);
        }
        $view == 'commision' ? $request->has('commision') ? '' : $data['commision'] = 0 : '';
        $view == 'show' ? $request->has('similar') ? '' : $data['similar'] = 0 : '';
        $view == 'show' ? $request->has('update_ads') ? '' : $data['update_ads'] = 0 : '';
        $view == 'start' ? $request->has('start_page') ? '' : $data['start_page'] = 0 : '';
        if ($view == 'slideshow') {
            $request->has('slide_show') ? '' : $data['slide_show'] = 0;
            $data['slide_show_depts'] = implode(',', $data['slide_show_depts']);
        }
        if ($view == 'watermark') {
            $request->has('watermark') ? '' : $data['watermark'] = 0;
            $image = $request->file('watermark_image');
            $image ? $data['watermark_image'] = uploadImage($image,false,false) : '';
        }

        Advs_config::first()->update($data);
        return view('admin.config.advs.' . $view . '', ['true' => 1, 'info' => Advs_config::first()]);
    }

    public function pays(Request $request) {
        $data = $request->all();
        $info['pays'] = \App\Models\Pays::orderBy('id', 'desc')->get();
        if (!$data) {
            return view('admin.pays.index', $info);
        }
        $view = $request->input('view');
        if ($view) {
            $data = [];
            $data['info'] = \App\Models\Pays::find($view);
            \App\Models\Pays::where('id', $view)->update(['seen' => 1]);
            return view('admin.pays.show', $data);
        }
        return redirect()->back();
    }

    public function jobs(Request $request) {
        $data = $request->all();
        if (!$data) {
            $info['list'] = \App\Models\Jobs::orderBy('id', 'desc')->get();
            return view('admin.jobs.index', $info);
        }
        $view = $request->input('view');
        if ($view) {
            $data = [];
            $data['info'] = \App\Models\Jobs::find($view);
            return view('admin.jobs.show', $data);
        }
        return redirect()->back();
    }

    public function contactus(Request $request) {
        $data = $request->all();
        $info['msgs'] = \App\Models\Contactus::orderBy('id', 'desc')->get();
        if (!$data) {
            return view('admin.contactus.index', $info);
        }
        $view = $request->input('view');
        if ($view) {
            $data = [];
            \App\Models\contactus::where('id', $view)->update(['seen' => 1]);
            $data['info'] = \App\Models\Contactus::find($view);
            return view('admin.contactus.show', $data);
        }
        return redirect()->back();
    }

    public function lawsuit_txt(Request $request){
        $data = $request->except('_token');
        if (!$data) {
            return view('admin.config.site.lawsuit_txt', ['info' => $this->site_config->first()]);
        }
        $this->site_config->update($data);
        return redirect()->back()->with('true', "تم تعديل الإعدادات بنجاح");
    }

}
