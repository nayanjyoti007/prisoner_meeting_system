<?php

use App\Http\Controllers\District\CenterController;
use App\Http\Controllers\District\ChangePasswordController;
use App\Http\Controllers\District\DashboardController;
use App\Http\Controllers\District\ExternalController;
use App\Http\Controllers\District\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'login'])->name('login');
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::post('/login-submit', [IndexController::class, 'loginSubmit'])->name('login.submit');
Route::get('/logout', [IndexController::class, 'logout'])->name('logout');

Route::get('/register', [IndexController::class, 'register'])->name('register');



Route::group(['middleware' => 'auth:district', 'prefix' => 'district', 'as' => 'district.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/first-password-change-submit', [DashboardController::class, 'firstChangePasswordSubmit'])->name('firstChangePasswordSubmit');
    Route::post('/is-send-otp', [IndexController::class, 'isSendOtp'])->name('is-send-otp');


    Route::middleware(['auth', 'first_password_change'])->group(function () {

        Route::get('/profile', [IndexController::class, 'form'])->name('profile');
        Route::post('/submit', [IndexController::class, 'submit'])->name('profile.submit');


        Route::get('center/list', [CenterController::class, 'list'])->name('center.list');

        Route::group(['prefix' => 'external', 'as' => 'external.'], function () {
            Route::get('/', [ExternalController::class, 'all'])->name('all');
            Route::get('list/{center_id}', [ExternalController::class, 'list'])->name('list');
            Route::get('form/{id?}', [ExternalController::class, 'form'])->name('form');
            Route::get('form-single/{id}', [ExternalController::class, 'formSingle'])->name('form-single');
            Route::post('form-single-post', [ExternalController::class, 'formSinglePost'])->name('form-single-post');
            Route::post('submit', [ExternalController::class, 'submit'])->name('submit');
            Route::get('status', [ExternalController::class, 'status'])->name('status');

            Route::get('delete', [ExternalController::class, 'delete'])->name('delete');
            Route::get('center-delete', [ExternalController::class, 'externalCenterDelete'])->name('center-delete');

            Route::any('add', [ExternalController::class, 'addExternal'])->name('add-external');
            Route::get('get-subject-ajax/{cid}', [ExternalController::class, 'getSubjectAjax'])->name('get-subject-ajax');


            Route::get('appointment/{ext_id}', [ExternalController::class, 'appointment'])->name('appointment');

        });


        Route::get('/change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('changePasswordForm');
        Route::post('/change-password-submit', [ChangePasswordController::class, 'changePassword'])->name('changePasswordSubmit');
    });
});

Route::any('/forgot-password', [IndexController::class, 'forgot'])->name('forgot');
Route::post('/is-details', [IndexController::class, 'isDetails'])->name('is-details');


Route::get('apt/{ext_id}', [ExternalController::class, 'aptMsg'])->name('apt-msg');
