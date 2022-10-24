<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function index()
    {


        $user = Auth::guard('sanctum')->user();
        $coach = Coach::where('user_id', $user->id)->first();
        if ($user->type == 'Coach') {
            $courses_coach_id = $coach->user_id;
            $items = Course::where('courses_coach_id' , $courses_coach_id)->latest()->paginate(15);
            $next_Page = $items->nextPageUrl();
                $prev_page = $items->previousPageUrl();
                $next_Page =$next_Page[-1];
                $next_Page = (int)$next_Page;
                $prev_page = $prev_page[-1];
                $prev_page = (int)$prev_page;
                return response()->json([
                    'current_Page' => $items->currentPage(),
                    'total_Page' => $items->total(),
                    'per_page' => $items->perPage(),
                    'next_Page' => $next_Page,
                    'prev_page' => $prev_page,
                    'data' => $items->items(),
                    'status' => 201
                ]);

        } elseif ($user->type == 'Admin') {
            $items = Course::latest()->paginate(15);
            $next_Page = $items->nextPageUrl();
                $prev_page = $items->previousPageUrl();
                $next_Page =$next_Page[-1];
                $next_Page = (int)$next_Page;
                $prev_page = $prev_page[-1];
                $prev_page = (int)$prev_page;
                return response()->json([
                    'current_Page' => $items->currentPage(),
                    'total_Page' => $items->total(),
                    'per_page' => $items->perPage(),
                    'next_Page' => $next_Page,
                    'prev_page' => $prev_page,
                    'data' => $items->items(),
                    'status' => 201
                ]);
        }
    }

    public function show($id)
    {

        $items = Course::with(['trainees'])->findOrFail($id)->latest()->paginate(15);
        return response()->json([
            'current_Page' => $items->currentPage(),
            'total_Page' => $items->total(),
            'per_page' => $items->perPage(),
            'next_Page' => $items->nextPageUrl(),
            'prev_page' => $items->previousPageUrl(),
            'data' => $items->items(),
             'status' => 201
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'courses_coach_id' => 'required',
            'time' => 'required',
            'classification' => 'required',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $data = $request->all();
            $course =  Course::create([
                'name' => $request->name,
                'courses_coach_id' => $request->courses_coach_id,
                'time' => $request->time,
                'classification' => $request->classification,
                'start_date' => $request->start_date,
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
                $course->update($request->all());
                return response()->json([
                    'message' => ' successfully update',
                    'user' => $course,
                    'status' => 201
                ]);
            } else {
                return response()->json([
                    'massage' => 'user Faild',
                ]);
            }
        }
    }

    public function destroy($id)
    {
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
