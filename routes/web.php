<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;

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
//Student
Route::match(['get', 'post'], '/', 'App\Http\Controllers\Admin\StudentController@index');
Route::match(['get', 'post'], '/add-student', 'App\Http\Controllers\Admin\StudentController@add_student')->name('add_student');
Route::match(['get', 'post'], '/edit-student/{id}', 'App\Http\Controllers\Admin\StudentController@edit_student')->name('edit_student');
Route::match(['get', 'post'], '/delete-student/{id}', 'App\Http\Controllers\Admin\StudentController@delete_student')->name('delete_student');
//Teacher
Route::match(['get', 'post'], '/teacher-list', 'App\Http\Controllers\Admin\TeacherController@index')->name('teacher_list');
Route::match(['get', 'post'], '/add-teacher', 'App\Http\Controllers\Admin\TeacherController@add_teacher')->name('add_teacher');
Route::match(['get', 'post'], '/edit-teacher/{id}', 'App\Http\Controllers\Admin\TeacherController@edit_teacher')->name('edit_teacher');
Route::match(['get', 'post'], '/delete-teacher/{id}', 'App\Http\Controllers\Admin\TeacherController@delete_teacher')->name('delete_teacher');
//marklists
Route::match(['get', 'post'], '/mark-list', 'App\Http\Controllers\Admin\MarksController@index')->name('mark_list');
Route::match(['get', 'post'], '/add-marks', 'App\Http\Controllers\Admin\MarksController@add_marks')->name('add_marks');
Route::match(['get', 'post'], '/edit-marks/{id}', 'App\Http\Controllers\Admin\MarksController@edit_marks')->name('edit_marks');
Route::match(['get', 'post'], '/delete-marks/{id}', 'App\Http\Controllers\Admin\MarksController@delete_marks')->name('delete_marks');