<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Coach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Trainee;

class TraineeController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|string|email|max:255|unique:users,email',
            'name'=>'required|string|between:2,100',
            'national_id '=>'required',
            'phone  '=>'required',
            'address  '=>'required',
            'Specialization  '=>'required',
            'gender  '=>'required',
        ]);
        $data= [
            'email' => $request->email,
            'type' => "Trainee",
        ];
        $data['password']=bcrypt($request->national_id);
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
        if($trainee) {
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $trainee,
                'status'=>201
            ]);
        }
        return response()->json([
            'message' => 'failed',
        ], 404);
    }
}
