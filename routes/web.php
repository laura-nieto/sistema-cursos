<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\BranchOfficeController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassDayController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TypeCourseController;
use App\Http\Controllers\UserController;

//Auth marcaba un error por no reconocer a Auth, así que escribi
// use Illuminate\Support\Facades\Auth; verificar si funciona
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('academias', AcademyController::class);

Route::resource('sucursales', BranchOfficeController::class);

Route::resource('cursos', CourseController::class);

Route::get('inscripcion/{id}',[CourseController::class,'inscripcion'])->name('cursos.inscripcion');
Route::post('inscripcion/{id}/cursos',[CourseController::class,'elegirCurso'])->name('cursos.elegir');
Route::post('inscripcion/{id}/curso/{idCurso}',[CourseController::class,'inscribir'])->name('cursos.inscribir');
Route::delete('curso/{id}/alumno/{idAlumno}',[CourseController::class,'bajaAlumno'])->name('cursos.bajaAlumno');
// Ruta de inscripcion cuando se pre-elije el curso
Route::get('inscripcion/{id}/alumnos',[CourseController::class,'inscripcionAlumnos'])->name('alumnos.inscripcion');

Route::get('dia/{id}',[ClassDayController::class,'vistaPresentes']);
Route::post('dia/{id}',[ClassDayController::class,'guardarPresentes']);
Route::get('dia/{classDay}/edit',[ClassDayController::class,'editarPresentes']);
Route::post('dia/{classDay}/edit',[ClassDayController::class,'updatePresentes']);
Route::get('presentes/dia/{id}',[ClassDayController::class,'verPresentes']);

Route::resource('horarios', ClassDayController::class);

Route::resource('estudiantes', StudentController::class);

Route::resource('roles',RoleController::class);

Route::resource('usuarios',UserController::class);

Route::resource('tipo_cursos',TypeCourseController::class);

// LLAMADA AXIOS
Route::post('tipo_curso/{id}',[ConsultasController::class,'obtenerAcademias']);
Route::post('tipo_curso/{id}/academia/{idAcademia}',[ConsultasController::class,'obtenerSucursales']);

//PRUEBAS CERTIFICADOS
Route::post('certificar/{course}',[CertificateController::class,'certificar'])->name('certificar');