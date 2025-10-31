<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\AuthenticatedUsersOnlyAccess;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {

    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return view('login');

});

Route::get('/logout', [SessionController::class, 'logout']);
Route::post('/login', [SessionController::class, 'processLogin']);


Route::middleware([AuthenticatedUsersOnlyAccess::class])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    });

    Route::get('/profile', [UserProfileController::class, 'viewUserProfile']);

});

