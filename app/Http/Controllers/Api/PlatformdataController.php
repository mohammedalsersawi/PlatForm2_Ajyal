<?php

namespace App\Http\Controllers\Api;

use App\Models\Platformdata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Latestupdate;
use App\Models\Trainee;
use Illuminate\Support\Facades\Validator;

class PlatformdataController extends Controller
{

    public function index()
    {
        $Platformdata =  Platformdata::all();
        return response()->json([
            'message' => 'All Latestupdate',
            'Platformdata' => $Platformdata,
            'status' => 201
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $Platformdata = Platformdata::create($request->all());
            if ($Platformdata) {
                return response()->json([
                    'message' => 'latestupdate successfully added',
                    'Platformdata' => $Platformdata,
                    'status' => 201
                ]);
            }
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $Platformdata = Platformdata::where('id', $id)->first();
            if ($Platformdata) {
                $Platformdata->update([
                    'key' => $request->key,
                    'value' => $request->value,
                ]);
                return response()->json([
                    'message' => 'User successfully registered',
                    'Platformdata' => $Platformdata,
                    'status' => 201
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                ], 404);
            }
        }
    }


    public function destroy($id)
    {
        $Platformdata = Platformdata::where('id', $id)->first();
        if ($Platformdata) {
            $Platformdata->delete();
            return response()->json([
                'message' => 'deleted successfully',
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 404
            ]);
        }
    }


    public function statistics()
    {
        $count_male = Trainee::where('gender', 'male')->count();
        $count_female = Trainee::where('gender', 'female')->count();
        $count_course = Course::all()->count();
        $count_activities = Latestupdate::all()->count();
        return response()->json([
            'message' => 'User successfully registered',
            'Platformdata' => [
                'count_male' =>  $count_male,
                'count_female' => $count_female,
                'count_course' => $count_course,
                'count_activities' => $count_activities,
            ],
            'status' => 201
        ]);
    }
}
