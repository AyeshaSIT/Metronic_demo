<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\FrontendAudioCallController;
use App\Http\Controllers\Apps\CallUserManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\PermissionManagementController;


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

Route::get('/audiocallmain', function () {
    return view('audiocallmain');
})->middleware(['auth', 'verified'])->name('audiocallmain');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/call-users', CallUserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
    Route::name('call-insights.')->group(function () {

        Route::get('/call-insights/', [FrontendAudioCallController::class, 'index'])->name('f-audiocalls.index');
        Route::get('/call-insights/create', [FrontendAudioCallController::class, 'create'])->name('f-audiocalls.create');
        Route::post('/call-insights', [FrontendAudioCallController::class, 'store'])->name('f-audiocalls.store');
        Route::get('/call-insights/{id}', [FrontendAudioCallController::class, 'show'])->name('f-audiocalls.show');
        Route::delete('/call-insights/{id}', [FrontendAudioCallController::class, 'destroy'])->name('f-audiocalls.destroy');

    });

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
