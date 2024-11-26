<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::middleware('guest')->group(function () {
    Route::get('/auth/redirect', function () {
        return Socialite::driver('laravelpassport')->redirect();
    });

    Route::get('/auth/callback', function () {
        $laravelpassportUser = Socialite::driver('laravelpassport')->user();

        $user = \App\Models\User::updateOrCreate([
            'laravelpassport_id' => $laravelpassportUser->id,
        ], [
            'name' => $laravelpassportUser->name,
            'email' => $laravelpassportUser->email,
            'password' => Hash::make('password'),
            'laravelpassport_token' => $laravelpassportUser->token,
            'laravelpassport_refresh_token' => $laravelpassportUser->refreshToken,
        ]);

        Auth::login($user);

        return to_route('dashboard');

        // id
        // nickname
        // name
        // email
        // avatar
    });

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
