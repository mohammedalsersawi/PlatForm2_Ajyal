<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
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
        }
        return response()->json([
            'massage' => 'userName OR Passworf Faild',
        ], 401);
    }

    public function softDeletes($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->update([
                'account_status' => 'archived' ,
            ]);
            $user->delete();
            return response()->json([
                'message' => 'User successfully registered',
                'id' => $user->id,
                'status' => 201
            ]);
        } else {
            return response()->json([
                'massage' => 'user Faild',
            ], 401);
        }
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        if ($user) {
            $user->restore();
            $user->update([
                'account_status' => 'active' ,
            ]);
            return response()->json([
                'message' => 'User successfully restore',
                'id' => $user->id,
                'status' => 201
            ]);
        } else {
            return response()->json([
                'massage' => 'user Faild',
            ]);
        }
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        if ($user) {
            $user->forceDelete();
            return response()->json([
                'message' => 'User successfully registered',
                'id' => $user->id,
                'status' => 201
            ]);
        } else {
            return response()->json([
                'massage' => 'user Faild',
            ]);
        }
    }


    // public function logout(Request $request) {
    //     if ($request->user()) {
    //         $user= Auth::guard('sanctum')->user();
    //         $user->tokens()->delete();
    //         return response()->json(['message' => 'User successfully signed out'], 200);
    //     }
    //     return response()->json(['message' => 'Unauthenticated'], 200);
    // }

    public function logout($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if ($token === null) {
            $user->tokens()->delete();
            return response()->json(['message' => 'User successfully signed out', 'status' => 200]);
        } else {
            $user->tokens()->where('id', $token)->delete();
            return response()->json(['message' => 'User successfully signed out vvv', 'status' => 200]);
        }
    }
}
