<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Coach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoachController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required',
            'phone' => 'required',
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
            $data['password'] = bcrypt($request->password);
            $user =  User::create($data);
            $user_id =  User::latest()->first()->id;


            $data_coach = [
                'user_id' => $user_id,
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
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required',
            'phone' => 'required',
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
            $coach = Coach::where('user_id', $id)->first();
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
