<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function store(Request $request)
    {


            $validator = Validator::make($request->all(), [
                'email'=>'required|string|email|max:255|unique:users,email',
                'password'=>'required|min:6',
                'name'=>'required|string|between:2,100',
                'national_id'=>'required',
                'phone'=>'required',
                'address'=>'required|string|between:2,100',
            ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);

    }else {
        $data= [
            'email' => $request->email,
            'type' => "Admin",
        ];
        $data['password']=bcrypt($request->password);
        $user =  User::create($data);
        $user_id =  User::latest()->first()->id;


        $data_admin = [
            'user_id' => $user_id,
            'name' => $request->name,
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
        $admin =  Admin::create($data_admin);
        if($admin) {
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $admin,
                'status'=>201
            ]);
        }
        return response()->json([
            'message' => 'failed',
        ], 404);
    }
    }


}
