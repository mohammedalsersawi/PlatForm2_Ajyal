<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CoachController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TraineeController;
use App\Http\Controllers\Api\WorkoutController;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('admin' , [AdminController::class , 'store']); //ADD
Route::post('coach' , [CoachController::class , 'store']); //ADD
Route::post('trainee' , [TraineeController::class , 'store']); //ADD
Route::post('course' , [CourseController::class , 'store']); //ADD
Route::post('workouts' , [WorkoutController::class , 'store']); //ADD
