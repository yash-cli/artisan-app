<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminAnnouncementController;
use App\Http\Controllers\TeacherAnnouncementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::middleware('role:admin')->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::resource('admin/announcements', AdminAnnouncementController::class)->names('admin.announcements');
    });

    Route::middleware('role:teacher|admin')->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
    });

    Route::middleware('role:teacher')->group(function () {
        Route::resource('students', StudentController::class)->except('index');
        Route::resource('teacher/announcements', TeacherAnnouncementController::class)->names('teacher.announcements');
    });

    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
});
