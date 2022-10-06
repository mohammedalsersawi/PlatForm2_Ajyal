<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AdminController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|string|email|max:255|unique:users,email',
            'password'=>'required|min:6',
            'name'=>'required|string|between:2,100',
            'national_id '=>'required',
            'phone  '=>'required',
            'address  '=>'required',
        ]);
        $data= [
            'email' => $request->email,
            'type' => "Admin",
        ];
        $data['password']=bcrypt($request->password);
        $user =  User::create($data);
        $user_id =  User::latest()->first()->id;

        $imagename = 'admin_' . time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/admin'), $imagename);
        $data_admin = [
            'user_id' => $user_id,
            'name' => $request->name,
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagename,
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
