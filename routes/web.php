<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    Route::get('/listing',[StudentController::class, 'studentListing'])->name('listing');

    Route::post('/add', [StudentController::class, 'addStudentData'])->name('student.add');
    Route::post('/getstudentData',[StudentController::class, 'getstudentData'])->name('student.data');
    Route::post('/deleteStudentData',[StudentController::class, 'deleteStudentData'])->name('student.delete');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

});
