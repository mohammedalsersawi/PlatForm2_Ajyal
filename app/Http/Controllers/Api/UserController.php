<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Admin;
use App\Models\Coach;
use App\Models\Trainee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
                'account_status' => 'archived',
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
                'account_status' => 'active',
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

    // public function logout($token = null)
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     if ($token === null) {
    //         $user->tokens()->delete();
    //         return response()->json(['message' => 'User successfully signed out', 'status' => 200]);
    //     } else {
    //         $user->tokens()->where('id', $token)->delete();
    //         return response()->json(['message' => 'User successfully signed out vvv', 'status' => 200]);
    //     }
    // }


    public function profile()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->type == 'Admin') {
            $user->admins;
        } elseif ($user->type == 'Coach') {
            $user->coaches;
        } elseif ($user->type == 'Trainee') {
            $user->trainee;
        }

        return response()->json([
            'message' => ' successfully update',
            'user' => $user,
            'status' => 201
        ]);
    }

    public function changeprofile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            // 'password' => 'required|min:6',
            'name' => 'required|string|between:2,100',
            'phone' => 'required',
            'address' => 'required|string|between:2,100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $profile =  User::where('id', $user->id)->update([
                'email' => $request->email,
                // 'password' => bcrypt($request->password),
            ]);
            if ($user->type == 'Admin') {
                $admin = Admin::where('user_id', $user->id)->first();
                if ($image = $request->file('image')) {
                    File::delete(public_path('uploads/imageAdmin/' . $admin->image));
                    $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                    $Path = 'uploads/imageAdmin';
                    $image->move($Path, $newfile);
                }
                $admin->update([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'image' => $newfile,
                ]);
                return $admin;
            } elseif ($user->type == 'Coach') {
                $coach = Coach::where('user_id', $user->id)->first();
                if ($image = $request->file('image')) {
                    File::delete(public_path('uploads/imageCoach/' . $coach->image));
                    $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                    $Path = 'uploads/imageAdmin';
                    $image->move($Path, $newfile);
                }
                $coach->update([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'image' => $newfile,
                ]);
                return $coach;
            } elseif ($user->type == 'Trainee') {
                $trainee = Trainee::where('user_id', $user->id)->first();
                if ($image = $request->file('image')) {
                    File::delete(public_path('uploads/imageCoach/' . $trainee->image));
                    $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                    $Path = 'uploads/imageTrainee';
                    $image->move($Path, $newfile);
                }
                $trainee->update([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'image' => $newfile,
                ]);
                return $trainee;
            }
        }
    }


    public function changepassword(Request $request)
    {
        $request->validate([
            'passwordOld' => 'required|min:6',
            'passwordNew' => 'required|min:6',
            'passwordNew1' => 'required|min:6',
        ]);
        $user = Auth::guard('sanctum')->user();
        $passwordOld = Hash::check($request->passwordOld, $user->password);
        if (!$passwordOld) {
            return 'The password is incorrect';
        } else {
            if ($request->passwordNew == $request->passwordNew1) {
                $newpassword = bcrypt($request->passwordNew);
                $table = User::where('id', $user->id)->update(['password' => $newpassword]);
                if ($table) {
                    return Response()->json([
                        'message' => 'Password successfully changed',
                        'status' => 200,
                    ], 200);
                } else {
                    return Response()->json([
                        'message' => 'NOt Faound',
                    ], 404);
                }
            } else {
                return 'Password is not the same';
            }
        }
    }
}
