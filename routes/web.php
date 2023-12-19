<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupporterController;
use App\Http\Controllers\TeacherController;
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

Route::get('/forgot_password', [ResetPasswordController::class, "forgotPasswordView"])->name('password.request');
Route::post('/forgot_password', [ResetPasswordController::class, "sendPasswordConfirmation"])->name('password.send');
Route::get('/reset_password', [ResetPasswordController::class, "resetPasswordView"])->name('password');
Route::post('/reset_password', [ResetPasswordController::class, "updatePasswordWithToken"])->name('password.update');


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

    Route::middleware(['greeting','host'])->group(function () {

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

        Route::prefix('teacher')->group(function () {

            Route::get('/create', [TeacherController::class, "create"])->name('teacher.create');
            Route::post('/store', [TeacherController::class, "store"])->name('teacher.store');
            Route::get('/list', [TeacherController::class, "list"])->name('teacher.list');
            Route::get('/edit/{id}', [TeacherController::class, "edit", "id"])->name('teacher.edit');
            Route::post('/update/{id}', [TeacherController::class, "update", "id"])->name('teacher.update');
            Route::get('/delete/{id}', [TeacherController::class, "delete", "id"])->name('teacher.delete');
        });

        Route::prefix('supporter')->group(function () {

            Route::get('/create', [SupporterController::class, "create"])->name('supporter.create');
            Route::post('/store', [SupporterController::class, "store"])->name('supporter.store');
            Route::get('/list', [SupporterController::class, "list"])->name('supporter.list');
            Route::get('/edit/{id}', [SupporterController::class, "edit", "id"])->name('supporter.edit');
            Route::post('/update/{id}', [SupporterController::class, "update", "id"])->name('supporter.update');
            Route::get('/delete/{id}', [SupporterController::class, "delete", "id"])->name('supporter.delete');
        });

        Route::prefix('staff')->group(function () {

            Route::get('/create', [StaffController::class, "create"])->name('staff.create');
            Route::post('/store', [StaffController::class, "store"])->name('staff.store');
            Route::get('/list', [StaffController::class, "list"])->name('staff.list');
            Route::get('/edit/{id}', [StaffController::class, "edit", "id"])->name('staff.edit');
            Route::post('/update/{id}', [StaffController::class, "update", "id"])->name('staff.update');
            Route::get('/delete/{id}', [StaffController::class, "delete", "id"])->name('staff.delete');
        });

        Route::prefix('branch')->withoutMiddleware(['host'])->group(function () {

            Route::get('/create', [BranchController::class, "create"])->name('branch.create');
            Route::get('/access/{branchId}', [BranchController::class, "access","branchId"])->name('branch.access');
            Route::post('/store', [BranchController::class, "store"])->name('branch.store');
            Route::get('/list', [BranchController::class, "list"])->name('branch.list');
            Route::get('/edit/{id}', [BranchController::class, "edit", "id"])->name('branch.edit');
            Route::post('/update/{id}', [BranchController::class, "update", "id"])->name('branch.update');
            Route::get('/delete/{id}', [BranchController::class, "destroy", "id"])->name('branch.delete');
        });
    });
});
