<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\AuthenticatedUsersOnlyAccess;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ExamManagementController;
use App\Http\Controllers\DataProcessingController;

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
    Route::post('/add-user', [UserProfileController::class, 'addNewUserCommit']);
    Route::get('/view-user/{id}', [UserProfileController::class, 'viewUser']);
    Route::get('/edit-user/{id}', [UserProfileController::class, 'editUser']);
    Route::post('/edit-user', [UserProfileController::class, 'editUserCommit']);
    Route::post('/delete-user/{id}', [UserProfileController::class, 'deleteUserCommit']);

    Route::get('/add-exam', [ExamManagementController::class, 'addNewExam']);
    Route::post('/add-exam', [ExamManagementController::class, 'addNewExamCommit']);
    Route::get('/list-exam', [ExamManagementController::class, 'viewExamList']);
    Route::get('/view-exam/{id}', [ExamManagementController::class, 'viewExam']);
    Route::get('/edit-exam/{id}', [ExamManagementController::class, 'editExam']);
    Route::post('/edit-exam', [ExamManagementController::class, 'editExamCommit']);
    Route::post('/delete-exam/{id}', [ExamManagementController::class, 'deleteExamCommit']);
    Route::get('/set-exam-as-current/{id}', [ExamManagementController::class, 'setExamAsCurrent']);

    Route::get('/config-data-line', [DataProcessingController::class, 'configureRawDataLines']);

});

