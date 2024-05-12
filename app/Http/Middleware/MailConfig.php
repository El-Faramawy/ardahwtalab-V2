<?php

namespace App\Http\Middleware;

use Config;

class MailConfig
{
    public function handle($request , $next)
    {
        
        

        
        $mail = \App\Site_mail::first();
        Config::set('mail.driver', $mail->driver);
        Config::set('mail.host', $mail->host);
        Config::set('mail.port', $mail->port);
        Config::set('mail.address', $mail->email);
        Config::set('mail.name', \App\SiteConfig::first()->title);
        Config::set('mail.encryption', $mail->encryption);
        Config::set('mail.username', $mail->email);
        Config::set('mail.password', $mail->password);

        return  $next($request);
    }
}
