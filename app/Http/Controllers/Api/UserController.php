<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name);
            return response()->json([
                'token' => $token->plainTextToken,
                'user' => $user,
                'status' => 201

            ]);
        }
        return response()->json($validator->errors(), 422);
    }

    public function softDeletes($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return response()->json([
            'message' => 'User successfully registered',
            'id' => $user->id,
            'status' => 201
        ]);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        $user->restore();
        return response()->json([
            'message' => 'User successfully registered',
            'id' => $user->id,
            'status' => 201
        ]);
    }
    public function forceDelete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->forceDelete();
            return response()->json([
                'message' => 'User successfully registered',
                'id' => $user->id,
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'فشلت العملية',
            ]);
        }
    }
}
