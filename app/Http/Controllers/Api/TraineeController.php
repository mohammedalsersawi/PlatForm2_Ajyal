<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Coach;
use App\Models\Course;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AttendanceTrainee;
use App\Models\CourseAttendance;
use App\Models\CoursesTrainee;
use App\Models\FollowFreelance;
use Illuminate\Support\Facades\Validator;

class TraineeController extends Controller
{

    public function index()
    {
        $trainees = Trainee::latest()->paginate(5);
        return response()->json([
            'message' => 'All Trainees',
            'user' => $trainees,
            'status' => 201
        ]);
    }
    public function showFreelance($id)
    {
        $Freelance = FollowFreelance::where('user_id' , $id)->get();
        $Freelancecount = FollowFreelance::where('user_id' , $id)->count();
        if($Freelance){
            return response()->json([
                'message' => 'All Freelance',
                'Freelancecount' => $Freelancecount,
                'Freelance' => $Freelance,
                'status' => 201
            ]);
        }else {
            return response()->json([
                'message' => 'Null',
                'status' => 404
        ]);
        }
    }
    public function showcourse($id)
    {
        $course = Trainee::with(['courses'])->findOrFail($id);
        if($course){
            return response()->json([
                'message' => 'All Course',
                'user' => $course,
                'status' => 201
            ]);
        }else {
            return response()->json([
                'message' => 'Null',
                'status' => 404
        ]);
        }
    }

    // public function showday(Request $request , $id)
    // {
    //     $day = CourseAttendance::where('course_id', $id)->get();
    //     return $day->traineesco;

    //     $course = CourseAttendance::where('course_id', 2)->with(['cococ'])->get();
    //     return $course;


    //     $u_count = AttendanceTrainee::where('trainee_id' , $id)->count();
    //     return $u_count;


    // }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $data = [
                'email' => $request->email,
                'type' => 'Trainee',
            ];
            $data['password'] = bcrypt($request->national_id);
            $user =  User::create($data);
            $user_id =  User::latest()->first()->id;


            $data_trainee = [
                'user_id' => $user_id,
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
            ];
            $trainee =  Trainee::create($data_trainee);
            if ($trainee) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $trainee,
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
            'email' => 'required',
            'name' => 'required',
            'national_id' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $user = User::where('id', $id)->first();
            $user->update([
                'email' => $request->email,
                'password' => bcrypt($request->national_id),
            ]);

            $trainee = Trainee::where('user_id', $id)->first();
            $trainee->update([
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
            ]);

            if ($trainee) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $trainee,
                    'status' => 201
                ]);
            }
        }
    }



}
