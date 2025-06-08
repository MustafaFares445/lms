<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MyCourseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => 'home'] , function(){
    Route::get('/recently-added' , [HomePageController::class , 'recentlyAdded']);
    Route::get('/my-courses' , [HomePageController::class , 'myCourses'])->middleware('auth:sanctum');
    Route::get('/top-teachers' , [HomePageController::class , 'topTeachers']);
});

Route::get('/ad' , AdController::class);


Route::prefix('/courses')->group(function(){
    Route::get('/my-courses' , MyCourseController::class);

    Route::get('' , [CourseController::class , 'index']);
    Route::get('/grouped-by-year' , [CourseController::class , 'groupedByYear']);
    Route::get('/{course:slug}' , [CourseController::class , 'show']);
    Route::get('/{course:slug}/teachers' , [CourseController::class , 'getCourseTeachers']);
    Route::get('/sessions/{courseSession}/quiz-questions' , [CourseSessionController::class , 'getQuizQuestions']);
});
