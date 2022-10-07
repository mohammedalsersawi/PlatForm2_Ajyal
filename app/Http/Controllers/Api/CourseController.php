<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'coach_id'=>'required',
            'time'=>'required',
            'classification'=>'required',
            'start_date'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }else {
        $data = $request->all();
        $course =  Course::create($data);
        if($course) {
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $course,
                'status'=>201
            ]);
        }
        return response()->json([
            'message' => 'failed',
        ], 404);
    }

    }

}
