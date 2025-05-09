<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;

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
