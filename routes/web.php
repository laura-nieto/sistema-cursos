<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\BranchOfficeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassDayController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

//Auth marcaba un error por no reconocer a Auth, así que escribi
// use Illuminate\Support\Facades\Auth; verificar si funciona
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('academias', AcademyController::class);

Route::resource('sucursales', BranchOfficeController::class);

Route::resource('cursos', CourseController::class);

Route::get('inscripcion/{id}',[CourseController::class,'inscripcion'])->name('cursos.inscripcion');

Route::resource('horarios', ClassDayController::class);

Route::resource('estudiantes', StudentController::class);

Route::resource('roles',RoleController::class);

Route::resource('usuarios',UserController::class);

// Route::resource('/courses',CourseController::class);