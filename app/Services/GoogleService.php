<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGoogle;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleService
{
    function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    function callback()
    {
        $googleUser = Socialite::driver('google')->user();
        dd($googleUser);

        // Users Table
        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);
        UserGoogle::updateOrCreate([
            "user_id" => $user_id
        ], [
            "avatar" => $googleUser->avatar,
            "avatar_original" => $googleUser->avatar_original,
            "name" => $googleUser->name
        ]);

        $login = Auth::login($user);
        if ($login) return redirect("/");
    }

    function getToken() {}
}
