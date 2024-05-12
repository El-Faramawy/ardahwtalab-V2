<?php

namespace App\Http\Controllers;

use App\Models\Advs_config;
use App\Models\Site_mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $json_arr;
    public $api_config;
    public function __construct(){
        date_default_timezone_set('Asia/Riyadh');
        $mail= Site_mail::first();
        \Config::set('mail.driver',$mail->driver);
        \Config::set('mail.host',$mail->host);
        \Config::set('mail.port',$mail->port);
        \Config::set('mail.address',$mail->email);
        \Config::set('mail.name', getSiteConfig('title'));
        \Config::set('mail.encryption',$mail->encryption);
        \Config::set('mail.username',$mail->email);
        \Config::set('mail.password',$mail->password);
        // dd(Config::get('mail'));

        $this->json_arr['message']='success';
        $this->json_arr['code']=1;
        $this->api_config= Advs_config::first();
    }
}
