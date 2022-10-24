<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Coach;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoachController extends Controller
{
    public function index()
    {
        $items = Coach::latest()->paginate(15);
         return response()->json([
            'current_Page' => $items->currentPage(),
            'total_Page' => $items->total(),
            'per_page' => $items->perPage(),
            'next_Page' => $items->nextPageUrl(),
            'prev_page' => $items->previousPageUrl(),
            'data' => $items->items(),
             'status' => 201
        ]);

    }

    public function show($id)
    {
        //  $course = Trainee::with(['courses'])->findOrFail($id);
        // return $course;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required|min:9|max:9|regex:/[0-8]{8}/',
            'phone' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'address' => 'required',
            'Specialization' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $data = [
                'email' => $request->email,
                'type' => "Coach",
            ];
            $data['password'] = bcrypt($request->national_id);
            $user =  User::create($data);
            // $user_id =  User::latest()->first()->id;


            $data_coach = [
                'user_id' => $user->id,
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'Specialization' => $request->Specialization,
                'gender' => $request->gender,
            ];
            $coach =  Coach::create($data_coach);
            if ($coach) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $coach,
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
        $coach = Coach::where('user_id', $id)->first();
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$coach->usre_id,
            'password' => 'required|min:6',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required|unique:courses,national_id,'.$coach->usre_id,
            'phone' => 'required|unique:courses,phone,'.$coach->usre_id,
            'address' => 'required',
            'Specialization' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $user = User::where('id', $id)->first();
            $user->update([
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $coach->update([
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'Specialization' => $request->Specialization,
                'gender' => $request->gender,
            ]);
            if ($coach) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $coach,
                    'status' => 201
                ]);
            }
        }
    }
}
