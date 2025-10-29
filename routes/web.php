<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return view('login');
});


Route::get('/dashboard', function () {
    return view('layout.layout-dashboard');
});

Route::get('/logout', [SessionController::class, 'logout']);

