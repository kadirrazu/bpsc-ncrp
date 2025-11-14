<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\AuthenticatedUsersOnlyAccess;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ExamManagementController;
use App\Http\Controllers\DataProcessingController;
use App\Http\Controllers\IssueManagementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResultProcessingController;
use App\Http\Controllers\ConfigurationController;

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

    Route::get('/config-data-line', [DataProcessingController::class, 'configureETypeRawDataLines']);
    Route::get('/configure-data-line-etype', [DataProcessingController::class, 'configureETypeRawDataLines']);
    Route::get('/configure-data-line-htype', [DataProcessingController::class, 'configureHTypeRawDataLines']);
    Route::post('/update-data-line-etype', [DataProcessingController::class, 'updateETypeRawDataLine']);
    Route::post('/update-data-line-htype', [DataProcessingController::class, 'updateHTypeRawDataLine']);

    Route::get('/upload-data-file', [DataProcessingController::class, 'uploadDataFile']);
    Route::post('/upload-data-file', [DataProcessingController::class, 'uploadDataFileProcessor']);
    Route::get('/convert-data-file', [DataProcessingController::class, 'convertDataFile']);
    Route::get('/get-etype-data', [DataProcessingController::class, 'getEtypeData']);
    Route::get('/get-htype-data', [DataProcessingController::class, 'getHtypeData']);
    Route::get('/convert-due-data-files/{exam_id}/{post_code}/{file_type}', [DataProcessingController::class, 'convertDueDataFilesToSQL']);

    Route::get('/generate-issue-status', [IssueManagementController::class, 'generateIssueStatusView']);
    Route::get('/issue-logs', [IssueManagementController::class, 'issueLogsView']);
    Route::get('/mark-regi-issues', [IssueManagementController::class, 'markEtypeRegiIssues']);
    Route::get('/mark-setcode-issues', [IssueManagementController::class, 'markEtypeSetCodeIssues']);
    Route::get('/mark-center-issues', [IssueManagementController::class, 'markEtypeCenterCodeIssues']);
    Route::get('/mark-lithocode-issues', [IssueManagementController::class, 'markEtypeLithoCodeIssues']);
    Route::get('/mark-lithocode-issues-htype', [IssueManagementController::class, 'markHTypeLithoCodeIssues']);
    Route::get('/mark-hexmissmatch-issues-etype', [IssueManagementController::class, 'markETypeHexCodeMissMatchIssues']);
    Route::get('/mark-hexmissmatch-issues-htype', [IssueManagementController::class, 'markHTypeHexCodeMissMatchIssues']);
    Route::get('/mark-hexmissmatch-issues-htype', [IssueManagementController::class, 'markHTypeHexCodeMissMatchIssues']);
    Route::get('/mark-own-hexmissmatch-issues-etype', [IssueManagementController::class, 'markETypeOwnHexCodeMissMatches']);
    Route::get('/mark-own-hexmissmatch-issues-htype', [IssueManagementController::class, 'markHTypeOwnHexCodeMissMatches']);
    Route::get('/hexmissmatch-data-etype', [IssueManagementController::class, 'viewETypeHexCodeMissMatches']);
    Route::get('/hexmissmatch-data-htype', [IssueManagementController::class, 'viewHTypeHexCodeMissMatches']);


    Route::get('/generate-hexcode', [DataProcessingController::class, 'generateHexcodeView']);
    Route::get('/generate-etype-hexcodes/{postcode}', [DataProcessingController::class, 'generateETypeHexcode']);
    Route::get('/generate-htype-hexcodes/{postcode}', [DataProcessingController::class, 'generateHTypeHexcode']);
    Route::get('/solve-data/{issue_type?}/{file_type?}', [DataProcessingController::class, 'solveDataView']);
    Route::get('/solve-data-h/{issue_type?}/{file_type?}', [DataProcessingController::class, 'solveDataViewH']);
    Route::get('/view-issue-data/{id}/{file_type}', [DataProcessingController::class, 'issueDataView']);
    Route::get('/edit-issue-data/{id}/{file_type}', [DataProcessingController::class, 'editIssueDataView']);
    Route::post('/edit-data-processing', [DataProcessingController::class, 'editDataProcessing']);
    Route::post('/edit-data-processing-h', [DataProcessingController::class, 'editDataProcessingH']);

    Route::get('/upload-regi-file', [DataProcessingController::class, 'uploadRegiFileView']);
    Route::post('/upload-regi-file', [DataProcessingController::class, 'uploadRegiFileProcessor']);
    Route::get('/convert-regi-file', [DataProcessingController::class, 'convertRegiFile']);

    Route::get('/upload-answer-file', [ResultProcessingController::class, 'uploadAnswerFileView']);
    Route::post('/upload-answer-file', [ResultProcessingController::class, 'uploadAnsweKeyFileProcessor']);
    Route::get('/convert-answer-file', [ResultProcessingController::class, 'convertAnswerFile']);
    Route::get('/calculate-marks', [ResultProcessingController::class, 'calculateMarks']);
    Route::get('/cut-mark-posting', [ResultProcessingController::class, 'cutMarkPostingView']);
    Route::post('/cut-mark-posting', [ResultProcessingController::class, 'cutMarkPostingProcessor']);
    Route::get('/delete-cut-mark', [ResultProcessingController::class, 'deleteCutMark']);
    Route::get('/generate-result-status', [ResultProcessingController::class, 'generateResultStatus']);

    Route::get('/hexcode-unmatch-report', [ReportController::class, 'hexcodeUnmatchReport']);
    Route::get('/score-frequency-report', [ReportController::class, 'scoreFrequencyReport']);
    Route::get('/eh-balance-report', [ReportController::class, 'ehBalanceReport']);
    Route::get('/answer-key-report', [ReportController::class, 'answerKeyReport']);

    Route::get('/master-configs', [ConfigurationController::class, 'setMasterConfigs']);
    Route::post('/master-configs', [ConfigurationController::class, 'updateMasterConfigs']);

});

