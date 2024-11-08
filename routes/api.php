<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Models\Subject;
use App\Services\Lecture_Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::Post('login','login')->name('login');
    Route::Post('register','register')->name('register');
    Route::Post('logout','logout')->middleware('auth:api')->name('logout');
    Route::get('get_profile','get_profile')->middleware('auth:api')->name('get_profile');
    Route::post('rest_pass','rest_pass')->name('rest_pass');
    Route::post('new_pass','new_pass')->name('new_pass');
    Route::post('edit_profile','edit_profile')->middleware('auth:api')->name('edit_profile');



});


Route::controller(SectionController::class)->group(function(){
    Route::Post('add_Section','add_Section')->name('add_Section');
    Route::get('get_Section','get_Section')->name('get_Section');


});


Route::controller(SubjectController::class)->group(function(){
    Route::Post('add_Subject','add_Subject')->name('add_Subject');
    Route::get('getSubjects','getSubjects')->name('getSubjects');


});

Route::controller(LectureController::class)->group(function(){
    Route::Post('add_lecture','add_lecture')->name('add_lecture');
    Route::get('get_lectures/{subject_id}','get_lectures')->name('get_lectures');


});
