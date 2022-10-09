<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CoachController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TraineeController;
use App\Http\Controllers\Api\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['guest:sanctum'])->prefix('auth')->group(function () {
    Route::post('user/login',[UserController::class,'login']);
    Route::delete('/userSoftDeletes/{id}',[UserController::class, 'softDeletes']);  //softDeletes
    Route::put('/user/{id}/restore',[UserController::class, 'restore']);
    Route::delete('/userForceDelete/{id}',[UserController::class, 'forceDelete']);  // forceDelete
});


Route::prefix('register')->middleware('auth:sanctum')->group(function () {
    Route::get('user/logout', [UserController::class, 'logout']);
    Route::post('admin' , [AdminController::class , 'store']); //ADD
    Route::put('update/admin/{id}' , [AdminController::class , 'update']); //ADD
    Route::post('coach' , [CoachController::class , 'store']); //ADD
    Route::put('update/coach/{id}' , [CoachController::class , 'update']); //ADD
    Route::post('trainee' , [TraineeController::class , 'store']); //ADD
    Route::put('update/trainee/{id}' , [TraineeController::class , 'update']); //ADD
});
Route::apiResource('course', CourseController::class);
Route::apiResource('workout', WorkoutController::class);

// Route::post('course' , [CourseController::class , 'store']); //ADD
// Route::post('workouts' , [WorkoutController::class , 'store']); //ADD
// Route::get('workouts' , [WorkoutController::class , 'index']); //ADD
