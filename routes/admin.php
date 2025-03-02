<?php

use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExternalController;
use App\Http\Controllers\Admin\Import\CenterImportController;
use App\Http\Controllers\Admin\Import\DistrictImportController;
use App\Http\Controllers\Admin\Import\StudentImportController;
use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::group(['namespace' => 'Admin'], function () {

    Route::get('/admin/login', [IndexController::class, 'login'])->name('admin.login');
    Route::post('/admin/login-submit', [IndexController::class, 'loginSubmit'])->name('admin.login.submit');
    Route::get('/admin/logout', [IndexController::class, 'logout'])->name('admin.logout');

    //CACHE CLEAR
    Route::get('/cache/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return back();
    })->name('admin.cache.clear');

    Route::get('/foo', function () {
        Artisan::call('storage:link');
    });


    Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/scanner', [DashboardController::class, 'scanner'])->name('scanner');
        Route::get('/scanner-update/{id}', [DashboardController::class, 'scannerUpdate'])->name('scanner-update');

        Route::get('/pending-visitor-account-kyc-verification', [DashboardController::class, 'kycVerification'])->name('pending-visitor-account-kyc-verification');
        Route::get('/pending-visitor-account-kyc-verification-details/{id}', [DashboardController::class, 'kycVerificationDetails']);
        Route::post('/pending-visitor-account-kyc-verification-status-update', [DashboardController::class, 'kycVerificationStatusUpdate'])->name('pending-visitor-account-kyc-verification-status-update');


        Route::get('/pending-member-kyc-verification', [DashboardController::class, 'memberkycVerification'])->name('pending-members-kyc-verification');
        Route::get('/pending-member-kyc-verification-details/{id}', [DashboardController::class, 'memberkycVerificationDetails']);
        Route::post('/pending-member-kyc-verification-status-update', [DashboardController::class, 'memberkycVerificationStatusUpdate'])->name('pending-members-kyc-verification-status-update');


        Route::get('/pending-request', [DashboardController::class, 'request'])->name('pending-request');
        Route::get('/pending-request-details/{id}', [DashboardController::class, 'requestDetails']);
        Route::post('/pending-request-status-update', [DashboardController::class, 'requestStatusUpdate'])->name('pending-request-status-update');
        Route::get('pending-request/details/{id}', [DashboardController::class, 'requestDetails'])->name('details');
        Route::get('pending-request/status-update-model/{id}', [DashboardController::class, 'requestStatusUpdateModel']);
        Route::post('pending-meeting-request-status-update', [DashboardController::class, 'requestStatusUpdate'])->name('pending-meeting-request-status-update');




                   Route::group(['prefix' => 'meeting-request', 'as' => 'meeting-request.'], function () {
                    Route::get('approved', [DashboardController::class, 'approved'])->name('approved-request');
                   });














        //        // Start Routing Admin Role & Permission Syestem
        //        // Start Routing Admin Role & Permission Syestem
        //
        //        // Route::group(['prefix' => 'master', 'middleware' => 'permission:manage.role'], function () {
        //        Route::group(['prefix' => 'master'], function () {
        //
        //
        //            Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
        //                Route::get('all', [RoleController::class, 'allPermission'])->name('allPermission');
        //                Route::get('add', [RoleController::class, 'addPermission'])->name('addPermission');
        //                Route::post('store', [RoleController::class, 'storePermission'])->name('storePermission');
        //                Route::get('edit/{id}', [RoleController::class, 'editPermission'])->name('editPermission');
        //                Route::post('update', [RoleController::class, 'updatePermission'])->name('updatePermission');
        //                Route::get('delete', [RoleController::class, 'deletePermission'])->name('deletePermission');
        //            });
        //
        //            Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
        //                Route::get('all', [RoleController::class, 'allRole'])->name('allRole');
        //                Route::get('add', [RoleController::class, 'addRole'])->name('addRole');
        //                Route::post('store', [RoleController::class, 'storeRole'])->name('storeRole');
        //                Route::get('edit/{id}', [RoleController::class, 'editRole'])->name('editRole');
        //                Route::post('update', [RoleController::class, 'updateRole'])->name('updateRole');
        //                Route::get('delete', [RoleController::class, 'deleteRole'])->name('deleteRole');
        //            });
        //
        //            Route::get('all/role/permission', [RoleController::class, 'allRolePermission'])->name('allRolePermission');
        //            Route::get('add/role/permission', [RoleController::class, 'addRolePermission'])->name('addRolePermission');
        //            Route::post('store/role/permission', [RoleController::class, 'storeRolePermission'])->name('storeRolePermission');
        //            Route::get('edit/role/permission/{id}', [RoleController::class, 'editRolePermission'])->name('editRolePermission');
        //            Route::post('update/role/permission/{id}', [RoleController::class, 'updateRolePermission'])->name('updateRolePermission');
        //            Route::get('delete/role/permission', [RoleController::class, 'deleteRolePermission'])->name('deleteRolePermission');
        //
        //
        //            Route::group(['prefix' => 'crateadmin', 'as' => 'crateadmin.'], function () {
        //                Route::get('list', [RoleController::class, 'list'])->name('list');
        //                Route::get('form/{id?}', [RoleController::class, 'form'])->name('form');
        //                Route::post('submit', [RoleController::class, 'submit'])->name('submit');
        //                Route::get('status/{id}', [RoleController::class, 'status'])->name('status');
        //                Route::get('delete', [RoleController::class, 'delete'])->name('delete');
        //            });
        //        });
        //
        //        // End Routing Admin Role & Permission Syestem
        //        // End Routing Admin Role & Permission Syestem


    });
});
