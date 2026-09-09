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

Route::get('/logout', function () {
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});

Route::get('/adminpass', [CovidController::class, 'adminpass']);
Route::post('/adminpass', [CovidController::class, 'adminenter']);

Route::middleware('admin')->group(function () {
    Route::get('/adminshow', [CovidController::class, 'adminshow']);
});

Route::get('/assessment', [CovidController::class, 'assessmentform']);
Route::post('/assessment', [CovidController::class, 'store1']);
Route::post('/assessment1', [CovidController::class, 'store2']);
Route::post('/assessment2', [CovidController::class, 'finalResult']);
