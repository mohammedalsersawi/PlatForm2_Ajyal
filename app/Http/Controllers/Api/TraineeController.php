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
        $trainees = Trainee::with('users:id,email')->latest()->paginate();
        return response()->json([
            'current_Page' => $trainees->currentPage(),
            'total_Page' => $trainees->total(),
            'per_page' => $trainees->perPage(),
            'next_Page' => $trainees->nextPageUrl(),
            'prev_page' => $trainees->previousPageUrl(),
            'data' => $trainees->items(),
             'status' => 201
        ]);
    }
    public function showFreelance($id)
    {
        $Freelance = FollowFreelance::where('user_id' , $id)->get();
        $Freelancecount = FollowFreelance::where('user_id' , $id)->count();
        if($Freelance){
            return response()->json([
                'current_Page' => $Freelance->currentPage(),
                'total_Page' => $Freelance->total(),
                'per_page' => $Freelance->perPage(),
                'next_Page' => $Freelance->nextPageUrl(),
                'prev_page' => $Freelance->previousPageUrl(),
                'data' => $Freelance->items(),
                'Freelancecount' => $Freelancecount,
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
                'current_Page' => $course->currentPage(),
                'total_Page' => $course->total(),
                'per_page' => $course->perPage(),
                'next_Page' => $course->nextPageUrl(),
                'prev_page' => $course->previousPageUrl(),
                'data' => $course->items(),
                 'status' => 201
            ]);
        }else {
            return response()->json([
                'message' => 'Null',
                'status' => 404
        ]);
        }
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required|min:9|max:9|regex:/[0-9]{9}/',
            'phone' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
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
        $trainee = Trainee::where('user_id', $id)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$trainee->usre_id,
            'name' => 'required',
            'national_id' => 'required',
            'phone' => 'required|unique:trainees,phone,'.$trainee->usre_id,
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
            }else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 404
                ]);
            }
        }
    }



}
