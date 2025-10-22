<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetectionlogsController;
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

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DetectionlogsController::class, 'dashboard']);
    Route::get('/detectionlogs', [DetectionlogsController::class, 'index'])->name('detectionlogs.index');
    Route::get('/detectionlogs/stats', [DetectionlogsController::class, 'stats'])->name('detectionlogs.stats');
    Route::get('/detectionlogs/stats-per-pc', [DetectionlogsController::class, 'statsPerPc'])->name('detectionlogs.stats_pc');
    Route::get('/detectionlog/{param}/showdetail', [DetectionlogsController::class, 'showDetail'])->name('detectionlogs.showdetail');
    Route::get('/detectionlogs/live-data', [DetectionlogsController::class, 'getLiveLogs'])->name('detectionlogs.livedata');
    Route::get('/export-logs', [DetectionlogsController::class, 'export'])->name('detectionlogs.export');
    Route::get('/export-clean', [DetectionlogsController::class, 'exportClean'])->name('detectionlogs.export_clean');
    // Clean PC aggregated list (AJAX for modal)
    Route::get('/detectionlogs/clean-list', [DetectionlogsController::class, 'cleanList'])->name('detectionlogs.clean');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

