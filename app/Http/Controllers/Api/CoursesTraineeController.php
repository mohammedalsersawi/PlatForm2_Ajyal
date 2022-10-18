<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CoursesTrainee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoursesTraineeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $workouts =  CoursesTrainee::create($data);
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
            $workout = CoursesTrainee::where('id', $id)->first();
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
       $workout = CoursesTrainee::destroy($id);
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

