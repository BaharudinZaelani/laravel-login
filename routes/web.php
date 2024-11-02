<?php

use App\Services\GoogleService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login-page');
})->name("home");

// Auth
Route::prefix("auth")->group(function () {
    // Login With Google
    Route::prefix("google")->controller(GoogleService::class)->group(function () {
        Route::get("/redirect", "redirect")->name("login-google");
        Route::get("/callback", "callback")->name("callback-google");
    });
});
