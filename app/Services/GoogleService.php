<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGoogle;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleService
{
    function __construct(
        protected Socialite $socialite,
        protected User $user,
        protected UserGoogle $userGoogle
    ) {}
    function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    function callback()
    {
        $googleUser = $this->socialite->driver('google')->user();

        // Users Table
        $user = $this->user->updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);
        $this->userGoogle->updateOrCreate([
            "user_id" => $user->id
        ], [
            "avatar" => $googleUser->avatar,
            "avatar_original" => $googleUser->avatar_original,
            "name" => $googleUser->name
        ]);

        $login = Auth::login($user);
        if ($login) return redirect("/");
    }

    function getToken(string $userId) {}
}
