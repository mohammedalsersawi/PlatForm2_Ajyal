<?php

namespace App\Http\Controllers\Api;

use App\Models\Workouts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WorkoutController extends Controller
{
    public function index()
    {
        $workouts = Workouts::withCount(['trainees'])->paginate();
       return $workouts;
    }

    public function show($id)
    {
        $workout = Workouts::where('course_id' , $id)->first();
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trainee_id'=>'required',
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'trainee_id'=>'required',
            'course_id'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $workout = Workouts::where('id', $id)->first();
            if ($workout) {
                $workout->update($request->all());
                return response()->json([
                    'message' => ' successfully update',
                    'user' => $workout,
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
       $workout = Workouts::destroy($id);
        if($workout){
            return response()->json([
                'message' => 'course deleted successfully',
                'status' => 201
            ]);
        }else {
            return response()->json([
                'massage' => 'user Faild',
            ]);
        }
    }
}

