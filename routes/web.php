<?php

use App\Http\Controllers\StudentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo-page', function () {
    return view('accordion');
});

Route::prefix('student')->group(function () {
    Route::get('/create', [StudentController::class, "create"])->name('student.create');
    Route::post('/store', [StudentController::class, "store"])->name('student.store');
    Route::get('/list', [StudentController::class, "list"])->name('student.list');
    Route::get('/edit/{id}', [StudentController::class, "edit", "id"])->name('student.edit');
    Route::post('/update/{id}', [StudentController::class, "update", "id"])->name('student.update');
    Route::get('/delete/{id}', [StudentController::class, "delete", "id"])->name('student.delete');
});
