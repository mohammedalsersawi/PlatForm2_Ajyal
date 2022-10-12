<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseAttendance;
use App\Models\Trainee;
use Illuminate\Support\Facades\Validator;

class CourseAttendanceController extends Controller
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'day' => 'required',
            'date' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $CourseAttendance =  CourseAttendance::create($request->all());
            if ($CourseAttendance) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $CourseAttendance,
                    'status' => 201
                ]);
            }
            return response()->json([
                'message' => 'failed',
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course=CourseAttendance::where('id',$id)->first();

        // $courseTrainers = $course->Trainees()->where('attendance',1)->get();
        $courseTrainers = $course->trainees()->get();

        $course['trainers']=$courseTrainers;
        //   $attendance = $course->Trainees()->attendance()->first();


        return $course;

        // $course = CourseAttendance::with(['Trainees'])->where('attendance',1)->findOrFail($id)->get();
        // return response()->json([
        //     'message' => 'User successfully registered',
        //     'user' => $course,
        //     'trainees' => $courseTrainers
        // ]);
        // return response()->json([
        //     'data' => $course,
        //     'status'=>200
        // ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'day' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $courseAttendance = CourseAttendance::where('id', $id)->first();
            if ($courseAttendance) {
                $courseAttendance->update($request->all());
                return response()->json([
                    'message' => ' successfully update',
                    'user' => $courseAttendance,
                    'status' => 201
                ]);
            } else {
                return response()->json([
                    'massage' => 'user Faild',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courseAttendance = CourseAttendance::destroy($id);
        if($courseAttendance){
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
