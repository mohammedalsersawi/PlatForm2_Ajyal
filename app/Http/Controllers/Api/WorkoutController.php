<?php

namespace App\Http\Controllers\Api;

use App\Models\Workouts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'course_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);

        }else {

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
}

