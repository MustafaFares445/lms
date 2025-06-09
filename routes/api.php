<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentQuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UniversityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::apiResource('/universities' , UniversityController::class);
Route::group(['prefix' => 'home'] , function(){
    Route::get('/recently-added' , [HomePageController::class , 'recentlyAdded']);
    Route::get('/my-courses' , [HomePageController::class , 'myCourses'])->middleware('auth:sanctum');
    Route::get('/top-teachers' , [HomePageController::class , 'topTeachers']);
});

Route::get('/ad' , AdController::class);

Route::prefix('/students/quizzes')->group(function(){
    Route::get('' , [StudentQuizController::class , 'index']);
    Route::post('' , [StudentQuizController::class , 'store']);
});

Route::get('/quizzes/subjects' , [QuizController::class , 'getQuizSubjects']);
Route::get('/quizzes/{quiz}/questions' , [QuizController::class , 'getQuizQuestions']);
Route::apiResource('/quizzes' , QuizController::class);

Route::middleware('auth:sanctum')->prefix('/subjects' , function(){
    Route::get('/saved' , [SubjectController::class , 'getSavedSubjects']);
    Route::post('/save' , [SubjectController::class , 'addToSave']);
    Route::delete('/unsave' , [SubjectController::class , 'removeFromSave']);
});

Route::prefix('/courses')->group(function(){
    Route::get('/sessions/{courseSession}/quiz-questions' , [CourseSessionController::class , 'getQuizQuestions'])->middleware('auth:sanctum');
    Route::put('/sessions/{courseSession}/update-progress' , [CourseSessionController::class , 'updateUserProgress'])->middleware('auth:sanctum');

    Route::post('/sessions/{courseSession}/media/{media}/download' , [CourseSessionController::class , 'download'])->middleware('auth:sanctum');
    Route::get('/sessions/{courseSession}' , [CourseSessionController::class , 'show'])->middleware('auth:sanctum');

    Route::get('/my-courses' , MyCourseController::class);

    Route::get('' , [CourseController::class , 'index']);
    Route::get('/grouped-by-year' , [CourseController::class , 'groupedByYear']);
    Route::get('/{course:slug}' , [CourseController::class , 'show']);
    Route::get('/{course:slug}/teachers' , [CourseController::class , 'getCourseTeachers']);
    Route::get('/{course:slug}/sessions' , [CourseController::class , 'getCourseSessions']);

    Route::post('/{course}/save' , [CourseController::class , 'addToSaved']);
    Route::delete('/{course}/unsave' , [CourseController::class , 'removeFromSaved']);
});


