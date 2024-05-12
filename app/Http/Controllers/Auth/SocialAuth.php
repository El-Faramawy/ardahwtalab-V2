<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
class SocialAuth extends Controller
{

    public function getSocialAuth()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function callback()
    {
        $user = Socialite::driver('github')->user();
        dd($user->getEmail());
        // $user->token;
    }
}
