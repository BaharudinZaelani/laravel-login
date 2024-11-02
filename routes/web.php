<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('login-page');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name("login-google");

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::updateOrCreate([
        'github_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'github_token' => $googleUser->token,
        'github_refresh_token' => $googleUser->refreshToken,
    ]);
    $login = Auth::login($user);
    if ($login) return redirect("/");
});
