<?php

use App\Http\Controllers\Visitor\ChangePasswordController;
use App\Http\Controllers\Visitor\DashboardController;
use App\Http\Controllers\Visitor\FamilyMembersController;
use App\Http\Controllers\Visitor\IndexController;
use App\Http\Controllers\Visitor\NotificationController;
use App\Http\Controllers\Visitor\RegisterController;
use App\Http\Controllers\Visitor\SendingMeetingRequestsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::post('/login-submit', [IndexController::class, 'loginSubmit'])->name('visitor.login-submit');
Route::get('/logout', [IndexController::class, 'logout'])->name('visitor.logout');

Route::get('/register', [IndexController::class, 'register'])->name('register');
Route::post('/register-submit', [RegisterController::class, 'submitRegister'])->name('register-submit');

Route::group(['middleware' => 'auth:visitor', 'as' => 'visitor.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/kyc-update', [DashboardController::class, 'kycUpdate'])->name('kyc-update');

    Route::get('/change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('changePasswordForm');
    Route::post('/change-password-submit', [ChangePasswordController::class, 'changePassword'])->name('changePasswordSubmit');

    Route::get('/notification', [NotificationController::class, 'notification'])->name('notification');
    Route::get('/notification-details/{id}', [NotificationController::class, 'notificationDetails'])->name('notification-details');
    Route::get('notification-remove-form-dashboard', [NotificationController::class, 'notificationRemoveDashboard'])->name('notification-remove-form-dashboard');



    Route::middleware(['auth', 'visitor_kyc.approved'])->group(function () {
        Route::get('/apply-meeting', [DashboardController::class, 'apply']);
        Route::get('/meeting-history', [DashboardController::class, 'history']);

        //Family Members Route
        Route::group(['prefix' => 'family-member', 'as' => 'family-member.'], function () {
            Route::get('list', [FamilyMembersController::class, 'list'])->name('list');
            Route::get('form/{id?}', [FamilyMembersController::class, 'form'])->name('form');
            Route::post('submit', [FamilyMembersController::class, 'submit'])->name('submit');
            Route::get('status/{id}', [FamilyMembersController::class, 'status'])->name('status');
            Route::get('delete', [FamilyMembersController::class, 'delete'])->name('delete');
        });


        //Sending Meeting Requests Route
        Route::group(['prefix' => 'sending-meeting-request', 'as' => 'sending-meeting-request.'], function () {
            Route::get('list', [SendingMeetingRequestsController::class, 'requestlist'])->name('list');
            Route::get('form/{id?}', [SendingMeetingRequestsController::class, 'requestform'])->name('form');
            Route::get('details/{id}', [SendingMeetingRequestsController::class, 'requestDetails'])->name('details');
            Route::post('submit', [SendingMeetingRequestsController::class, 'requestMeeting'])->name('submit');
            Route::get('status/{id}', [SendingMeetingRequestsController::class, 'status'])->name('status');
            Route::get('delete', [SendingMeetingRequestsController::class, 'delete'])->name('delete');
        });
    });
});
