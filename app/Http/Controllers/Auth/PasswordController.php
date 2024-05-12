<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Config;

class PasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    public function showResetForm($token = null) {

        if (is_null($token)) {
            return $this->getEmail();
        }
        $email = request('email');
        $_token = \DB::table('password_resets')->where('token', $token)->where('email', $email)->first();
        if ($_token) {
            $info = User::where('email', $_token->email)->first();
        } else {
            die('bad request');
        }
        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email', 'info'));
        }

        if (view()->exists('auth.passwords.reset')) {
            return view('auth.passwords.reset')->with(compact('token', 'email', 'info'));
        }

        return view('auth.reset')->with(compact('token', 'email', 'info'));
    }

}
