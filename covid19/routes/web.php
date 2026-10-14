<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CovidController;

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
    return view('welcome');
});

Route::get('/adminpass', [CovidController::class, 'adminpass']);
Route::post('/adminpass', [CovidController::class, 'adminenter'])->middleware('throttle:5,1');

Route::middleware('admin')->group(function () {
    Route::get('/adminshow', [CovidController::class, 'adminshow']);
    Route::get('/adminshow/export', [CovidController::class, 'exportCsv'])->name('adminshow.export');
    Route::post('/logout', function () {
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

Route::get('/assessment', [CovidController::class, 'assessmentform']);
Route::post('/assessment', [CovidController::class, 'store1']);
Route::post('/assessment1', [CovidController::class, 'store2']);
Route::post('/assessment2', [CovidController::class, 'finalResult']);
