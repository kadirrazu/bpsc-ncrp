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
    Route::get('/change-password', [UserProfileController::class, 'passwordChangeWindow']);
    Route::post('/change-password', [UserProfileController::class, 'passwordChangeCommit']);

    Route::get('/list-user', [UserProfileController::class, 'getUserList']);
    Route::get('/add-user', [UserProfileController::class, 'addNewUser']);
    Route::get('/view-user', [UserProfileController::class, 'viewUser']);
    Route::get('/edit-user', [UserProfileController::class, 'editUser']);
    Route::get('/delete-user', [UserProfileController::class, 'deleteUser']);

});

