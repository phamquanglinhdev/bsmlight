<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ResetPasswordController;
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

Route::get('/forgot-password', [ResetPasswordController::class, "forgotPasswordView"])->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, "sendPasswordConfirmation"])->name('password.send');
Route::get('/reset-password', [ResetPasswordController::class, "resetPasswordView"])->name('password');
Route::post('/reset-password', [ResetPasswordController::class, "updatePasswordWithToken"])->name('password.update');


Route::get('/login', [AuthenticateController::class, "loginView"])->name('login');
Route::get('/register', [AuthenticateController::class, "registerView"])->name('registration');
Route::post('/register', [AuthenticateController::class, "register"])->name('register');
Route::post('/login', [AuthenticateController::class, "login"])->name('authentication');
Route::get('/logout', [AuthenticateController::class, "logout"])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/verification', [AuthenticateController::class, 'verificationView']);
    Route::post('/update_email', [AuthenticateController::class, 'updateEmail']);
    Route::get('/resend_email', [AuthenticateController::class, 'sendVerificationEmail']);
    Route::post('/verify', [AuthenticateController::class, 'verify']);

    Route::middleware(['greeting'])->group(function () {

        Route::get('/', function () {
            return view('welcome');
        });

        Route::prefix('student')->group(function () {

            Route::get('/create', [StudentController::class, "create"])->name('student.create');
            Route::post('/store', [StudentController::class, "store"])->name('student.store');
            Route::get('/list', [StudentController::class, "list"])->name('student.list');
            Route::get('/edit/{id}', [StudentController::class, "edit", "id"])->name('student.edit');
            Route::post('/update/{id}', [StudentController::class, "update", "id"])->name('student.update');
            Route::get('/delete/{id}', [StudentController::class, "delete", "id"])->name('student.delete');
        });
    });
});
