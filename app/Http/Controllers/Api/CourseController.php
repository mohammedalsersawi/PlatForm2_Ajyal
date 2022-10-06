<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'coach_id '=>'required',
            'time'=>'required',
            'classification '=>'required',
            'start_date  '=>'required',
        ]);

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

