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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required|min:9|max:9|regex:/[0-9]{9}/',
            'phone' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'address' => 'required|string|between:2,100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $data = [
                'email' => $request->email,
                'type' => 'Admin',
            ];
            $data['password'] = bcrypt($request->password);
            $user =  User::create($data);
            // $user_id =  User::latest()->first()->id;

            $data_admin = [
                'user_id' => $user->id,
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'address' => $request->address,
            ];
            $admin =  Admin::create($data_admin);
            if ($admin) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $admin,
                    'status' => 201
                ]);
            }
        }
    }



    public function update(Request $request, $id)
    {
        $admin = Admin::where('user_id', $id)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$admin->user_id,
            'password' => 'required|min:6',
            'name' => 'required|string|between:2,100',
            'national_id' => 'required|unique:admins,national_id,'.$admin->user_id,
            'phone' => 'required|unique:admins,phone,'.$admin->user_id,
            'address' => 'required|string|between:2,100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $user = User::where('id', $id)->first();
            $user->update([
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $admin->update([
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            if ($admin) {
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $admin,
                    'status' => 201
                ]);
            }
        }
    }


}
