<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WeightLogController;
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

Route::middleware('auth')->group(function () {
	Route::get('/weight_logs', [WeightLogController::class, 'index'])->name('weight_logs.index');
	Route::get('/weight_logs/search', [WeightLogController::class, 'index'])->name('weight_logs.search');
	Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'editTarget'])->name('weight_logs.target.edit');
	Route::put('/weight_logs/goal_setting', [WeightLogController::class, 'updateTarget'])->name('weight_logs.target.update');
	Route::get('/weight_logs/create', [WeightLogController::class, 'create'])->name('weight_logs.create');
	Route::post('/weight_logs', [WeightLogController::class, 'store'])->name('weight_logs.store');
	Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])->name('weight_logs.show');
	Route::put('/weight_logs/{weightLog}/update', [WeightLogController::class, 'update'])->name('weight_logs.update');
	Route::delete('/weight_logs/{weightLog}/delete', [WeightLogController::class, 'destroy'])->name('weight_logs.delete');
	Route::redirect('/', '/weight_logs');
});
Route::redirect('/register', '/register/step1');
Route::redirect('/register/', '/register/step1');
Route::get('/register/step1', [RegisterController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'storeStep1'])->name('register.step1.store');
Route::get('/register/step2', [RegisterController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [RegisterController::class, 'storeStep2'])->name('register.step2.store');
