<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workouts;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id  '=>'required',
            'course_id  '=>'required',
        ]);

        $data = $request->all();
        $workouts =  Workouts::create($data);
        if($workouts) {
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $workouts,
                'status'=>201
            ]);
        }
        return response()->json([
            'message' => 'failed',
        ], 404);
    }

    }


