<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseAttendance;
use App\Models\AttendanceTrainee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttendanceTraineeController extends Controller
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
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'course_attendance_id' => 'required|integer',
    //         'trainee_id' => 'required|integer',
    //         'attendance' => 'required|integer',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     } else {
    //         $CourseAttendance =  AttendanceTrainee::create($request->all());
    //         if ($CourseAttendance) {
    //             return response()->json([
    //                 'message' => 'User successfully registered',
    //                 'user' => $CourseAttendance,
    //                 'status' => 201
    //             ]);
    //         }
    //         return response()->json([
    //             'message' => 'failed',
    //         ], 404);
    //     }
    // }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'day' => 'required',
            'date' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $CourseAttendance =  CourseAttendance::create($request->all());
            $trainees_attendance=json_decode($request->trainees_attendance);
            foreach ($trainees_attendance as $trainees_id=>$Attendance){
                AttendanceTrainee::create([
                   'course_attendance_id'=>$CourseAttendance->id,
                   'trainee_id'=>$trainees_id,
                   'attendance'=>$Attendance
                ]);

        }
      }
      return response()->json([
        'message' => 'successfully',
    ], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


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
            'course_attendance_id' => 'required|integer',
            'trainee_id' => 'required|integer',
            'attendance' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $attendanceTrainee = AttendanceTrainee::where('id', $id)->first();
            if ($attendanceTrainee) {
                $attendanceTrainee->update($request->all());
                return response()->json([
                    'message' => ' successfully update',
                    'user' => $attendanceTrainee,
                    'status' => 201
                ]);
            } else {
                return response()->json([
                    'massage' => 'user Faild',
                ]);
            }
        }
    }





    public function viewdetails(Request $request)
    {
        $b = AttendanceTrainee::paginate(5);
        return $b;
        $course_id = $request->course_id;
        $trainee_id = $request->trainee_id;
        $attendance = DB::table('attendance_trainees')
            ->join('course_attendances', 'course_attendances.id', '=', 'attendance_trainees.course_attendance_id')
            ->selectRaw('count(if(attendance_trainees.attendance = 0, null, 1)) as attended')
            ->selectRaw('count(if(attendance_trainees.attendance = 1, null, 1)) as missed')
            ->where([
                //'attendance_trainees.attendance' => 1,
                'attendance_trainees.trainee_id' => $trainee_id,
                'course_attendances.course_id' => $course_id,

            ])
            ->first();

        return response()->json([
            'message' => ' successfully',
            'Count_Attended' =>  $attendance->attended,
            'CountP_Missed' =>  $attendance->missed,
            'status' => 201
        ]);


        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendanceTrainee = AttendanceTrainee::destroy($id);
        if($attendanceTrainee){
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



    public function viewdetails1()
    {
         $course = CourseAttendance::where('course_id', 1)->first();

        $courseTrainers = $course->trainees()->where('attendance', 1)->get();
        // $courseTrainers = $course->trainees()->get();

        $course['trainers'] = $courseTrainers;
        return $course;

        // $course = CourseAttendance::where('course_id',1 )->count();
        // $courseTrainers = $course->trainees()->where('attendance', 1)->count();
        // return $courseTrainers;

        // return $course->where('attendance', 1)->first();

        // $courseTrainers = $course->trainees()->where('attendance', 1)->get();
        // $courseTrainers = $course->trainees()->get();

        // $course['trainers'] = $courseTrainers;



        //  $w=Course::where('id',1)->exists();
        //  if ($w){
        //             $c=AttendanceTrainee::where('attendance', 1)->where('trainee_id', 1)->with([
        //             'course_attendances' => function ($qurey) {
        //             $qurey->where('course_id',1);
        //             }
        //             ])->count();
        //             }else{
        //                 return 'cccc';
        //             }
        //             return $c;

    }
        }
