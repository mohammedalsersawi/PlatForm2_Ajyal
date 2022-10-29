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
use App\Http\Controllers\Api\PlatformdataController;

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
Route::middleware(['guest:sanctum'])->prefix('login')->group(function () {
    Route::post('user/login', [UserController::class, 'login']);
});


Route::middleware(['auth:sanctum'])->prefix('profile')->group(function () {
    Route::post('/profile', [UserController::class, 'profile']);
    Route::post('/changeprofile', [UserController::class, 'changeprofile']);
    Route::put('/changepassword', [UserController::class, 'changepassword']);
    Route::get('user/logout', [UserController::class, 'logout']);
});

// Route::middleware(['auth:sanctum' , 'admin'])->prefix('admin')->group(function () {
Route::prefix('admin')->group(function () {
    Route::post('admin', [AdminController::class, 'store']); //ADD
    Route::post('update/admin/{id}', [AdminController::class, 'update']); //ADD


    Route::post('coach', [CoachController::class, 'store']); //ADD
    Route::put('update/coach/{user_id}', [CoachController::class, 'update']); //ADD
    Route::get('coach', [CoachController::class, 'index']); //ADD
    Route::get('coach/{user_id}', [CoachController::class, 'show']); //ADD
    Route::get('coachs', [CoachController::class, 'show_coachs']); //ADD


    Route::post('trainee', [TraineeController::class, 'store']); //ADD
    Route::put('update/trainee/{user_id}', [TraineeController::class, 'update']); //ADD
    Route::get('trainee', [TraineeController::class, 'index']); //ADD
    Route::get('trainee/{user_id}', [TraineeController::class, 'show']); //ADD

    Route::post('add/featured', [TraineeController::class, 'add_featured']); //ADD
    Route::post('update/featured', [TraineeController::class, 'update_featured']); //ADD


    Route::delete('/userSoftDeletes/{id}', [UserController::class, 'softDeletes']);  //softDeletes
    Route::put('/user/{id}/restore', [UserController::class, 'restore']);
    Route::delete('/userForceDelete/{id}', [UserController::class, 'forceDelete']);  // forceDelete

    Route::apiResource('course', CourseController::class)->except('update');
    Route::post('course/{id}', [CourseController::class, 'update']);
    Route::get('showday/{id}', [CourseController::class, 'showday']);
    Route::get('showday/trainee/{id}', [CourseController::class, 'show_trainee_Course']);




    Route::apiResource('workout', CoursesTraineeController::class);
    Route::apiResource('CourseAttendance', CourseAttendanceController::class);
    Route::apiResource('AttendanceTrainee', AttendanceTraineeController::class);
    Route::post('update/attendance', [AttendanceTraineeController::class, 'update_attendance_trainee']);




    Route::post('latestnew', [LatestnewController::class, 'store']);
    Route::post('latestnew/{id}', [LatestnewController::class, 'update']);
    Route::delete('latestnew/{id}', [LatestnewController::class, 'destroy']);



    Route::apiResource('latestupdate', LatestupdateController::class)->except('index');
    Route::apiResource('Platformdata', PlatformdataController::class)->except('update' , 'index');
    Route::post('Platformdata/{id}', [PlatformdataController::class, 'update']);

    Route::get('show/freelances', [FollowFreelanceController::class, 'show_freelances']);




});

Route::middleware(['auth:sanctum' , 'admin',  'coach'])->prefix('coach')->group(function () {
    Route::apiResource('CourseAttendance', CourseAttendanceController::class);
    Route::apiResource('AttendanceTrainee', AttendanceTraineeController::class);
    Route::get('course', [CourseController::class, 'show']); //ADD


});

Route::middleware(['auth:sanctum'])->prefix('trainee')->group(function () {
    Route::apiResource('followfreelance', FollowFreelanceController::class);
});


Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
 Route::get('show/Freelance/job/{id}', [TraineeController::class, 'showFreelance']); //ADD
 Route::get('show/course/{id}', [TraineeController::class, 'showcourse']); //ADD
 Route::get('viewdetails/{course_id}/{trainee_id?}', [AttendanceTraineeController::class, 'viewdetails']); //ADD
 Route::get('latestupdate', [LatestupdateController::class, 'index']);

});

Route::prefix('ajyal')->group(function () {
    Route::get('latestnew', [LatestnewController::class, 'index']);
    Route::get('latestnew/{id}', [LatestnewController::class, 'show']);
    Route::get('Platformdata', [PlatformdataController::class, 'index']);
    Route::get('statistics', [PlatformdataController::class, 'statistics']);
    Route::get('featured/trainee', [PlatformdataController::class, 'featured_trainee']);
    Route::get('show/allcourses', [CourseController::class, 'show_allcourses']);

});
