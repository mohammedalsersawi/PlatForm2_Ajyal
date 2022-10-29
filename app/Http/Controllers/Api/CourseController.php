<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Coach;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AttendanceTrainee;
use App\Models\CourseAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->type == 'Coach') {
            $coach = Coach::where('user_id', $user->id)->first();
            $courses_coach_id = $coach->user_id;
            $items = Course::where('courses_coach_id', $courses_coach_id)->latest()->paginate(15);
            return response()->json([
                'current_Page' => $items->currentPage(),
                'total_Page' => $items->total(),
                'per_page' => $items->perPage(),
                'next_Page' =>  $items->nextPageUrl(),
                'prev_page' => $items->previousPageUrl(),
                'data' => $items->items(),
                'status' => 201
            ]);
        } elseif ($user->type == 'Admin') {
            $items = Course::latest()->paginate(15);
            return response()->json([
                'current_Page' => $items->currentPage(),
                'total_Page' => $items->total(),
                'per_page' => $items->perPage(),
                'next_Page' =>  $items->nextPageUrl(),
                'prev_page' => $items->previousPageUrl(),
                'data' => $items->items(),
                'status' => 201
            ]);
        }
    }

    public function show($id)
    {
        $course = Course::with(['trainees'])->findOrFail($id);
        return $course;
    }

    public function show_allcourses()
    {
        $items = Course::latest()->paginate(15);
            return response()->json([
                'current_Page' => $items->currentPage(),
                'total_Page' => $items->total(),
                'per_page' => $items->perPage(),
                'next_Page' =>  $items->nextPageUrl(),
                'prev_page' => $items->previousPageUrl(),
                'data' => $items->items(),
                'status' => 201
            ]);
    }


    public function showday($id)
    {
        $day_Course = CourseAttendance::where('course_id', $id)->paginate(15);
        return response()->json([
            'current_Page' => $day_Course->currentPage(),
            'total_Page' => $day_Course->total(),
            'per_page' => $day_Course->perPage(),
            'next_Page' => $day_Course->nextPageUrl(),
            'prev_page' => $day_Course->previousPageUrl(),
            'data' => $day_Course->items(),
            'status' => 201
        ]);
    }
    public function show_trainee_Course($id)
    {
        // $AttendanceTrainee = AttendanceTrainee::where('course_attendance_id' , $id)->with(['trainees'])->get();
        $AttendanceTrainee = AttendanceTrainee::with('trainee:user_id,name')->where('course_attendance_id', $id)->get();
        return $AttendanceTrainee;
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'courses_coach_id' => 'required',
            'time' => 'required',
            'classification' => 'required',
            'start_date' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            if ($image = $request->file('image')) {
                $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                $Path = 'uploads/Course';
                $image->move($Path, $newfile);
            }
            $course =  Course::create([
                'name' => $request->name,
                'courses_coach_id' => $request->courses_coach_id,
                'time' => $request->time,
                'classification' => $request->classification,
                'start_date' => $request->start_date,
                'link' => $request->link,
                'image' => "/uploads/Course/$newfile",
            ]);
            if ($course) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $course,
                    'status' => 201
                ]);
            }
            return response()->json([
                'message' => 'failed',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'courses_coach_id' => 'required|integer',
            'time' => 'required',
            'classification' => 'required',
            'start_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $course = Course::where('id', $id)->first();
            if ($course) {
                if ($image = $request->file('image')) {
                    File::delete(public_path($course->image));
                    $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                    $Path = 'uploads/Course';
                    $image->move($Path, $newfile);
                    $course->update([
                        'image' => "/uploads/Course/$newfile",
                    ]);
                    $course->update([
                        'name' => $request->name,
                        'courses_coach_id' => $request->courses_coach_id,
                        'time' => $request->time,
                        'classification' => $request->classification,
                        'start_date' => $request->start_date,
                        'link' => $request->link,
                    ]);
                    return response()->json([
                        'message' => ' successfully update',
                        'user' => $course,
                        'status' => 201
                    ]);
                } else {
                    $course->update([
                        'name' => $request->name,
                        'courses_coach_id' => $request->courses_coach_id,
                        'time' => $request->time,
                        'classification' => $request->classification,
                        'start_date' => $request->start_date,
                        'link' => $request->link,
                    ]);
                    return response()->json([
                        'message' => ' successfully update',
                        'user' => $course,
                        'status' => 201
                    ]);
                }
            }else {

            }
        }
    }


    public function destroy($id)
    {
        $course = Course::where('id', $id)->first();
        File::delete(public_path($course->image));
        $course = Course::destroy($id);

        if ($course) {
            return response()->json([
                'message' => 'course deleted successfully',
                'status' => 201
            ]);
        } else {
            return response()->json([
                'massage' => 'user Faild',
            ]);
        }
    }
}
