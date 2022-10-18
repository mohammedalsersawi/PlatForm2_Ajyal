<?php

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CoachController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TraineeController;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\LatestnewController;
use App\Http\Controllers\Api\LatestupdateController;
use App\Http\Controllers\Api\CourseAttendanceController;
use App\Http\Controllers\Api\AttendanceTraineeController;
use App\Http\Controllers\Api\CoursesTraineeController;
use App\Http\Controllers\Api\FollowFreelanceController;

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

Route::prefix('profile')->group(function () {
    Route::post('/profile', [UserController::class, 'profile']);
    Route::post('/changeprofile', [UserController::class, 'changeprofile']);
    Route::put('/changepassword', [UserController::class, 'changepassword']);
    Route::get('user/logout', [UserController::class, 'logout']);
});

Route::prefix('register')->group(function () {
    Route::post('admin' , [AdminController::class , 'store']); //ADD
    Route::put('update/admin/{id}' , [AdminController::class , 'update']); //ADD
    Route::post('coach' , [CoachController::class , 'store']); //ADD
    Route::put('update/coach/{id}' , [CoachController::class , 'update']); //ADD
    Route::post('trainee' , [TraineeController::class , 'store']); //ADD
    Route::put('update/trainee/{id}' , [TraineeController::class , 'update']); //ADD

});
Route::apiResource('course', CourseController::class);
Route::apiResource('workout', CoursesTraineeController::class);
Route::apiResource('CourseAttendance', CourseAttendanceController::class);
Route::apiResource('AttendanceTrainee', AttendanceTraineeController::class);
Route::apiResource('latestnew', LatestnewController::class);
Route::apiResource('latestupdate', LatestupdateController::class);
Route::apiResource('followfreelance', FollowFreelanceController::class);




