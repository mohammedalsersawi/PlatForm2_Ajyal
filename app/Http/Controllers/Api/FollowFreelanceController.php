<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FollowFreelance;
use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FollowFreelanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        $followfreelance = FollowFreelance::where('user_id', $user->id)->get();
        if ($followfreelance) {
            return response()->json([
                'message' => 'followfreelance',
                'user' => $followfreelance,
                'status' => 201
            ]);
        }else {
            return response()->json([
                'message' => 'failed',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Platform' => 'required|string',
            'title' => 'required|string',
            'details' => 'required|string',
            'budget' => 'required|string',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
        $user = Auth::guard('sanctum')->user();
        $followfreelance = FollowFreelance::create([
                'user_id' => $user->id,
                'Platform' => $request->Platform,
                'title' => $request->title,
                'details' => $request->details,
                'budget' => $request->budget,
                'date' => $request->date,
        ]);
        $total_income = Trainee::where('user_id', $user->id)->first();
        $old_income = $total_income->total_income;
        $new_income = $old_income + $request->budget;
        $total_income->update([
            'total_income' => $new_income,
        ]);
        if ($followfreelance) {
            return response()->json([
                'message' => 'followfreelance successfully added',
                'user' => $followfreelance,
                'status' => 201
            ]);
        }
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return FollowFreelance::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'Platform' => 'required|string',
            'title' => 'required|string',
            'details' => 'required|string',
            'budget' => 'required|string',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $followfreelance = FollowFreelance::where('id', $id)->first();
            if ($followfreelance) {
                $followfreelance->update([
                'Platform' => $request->Platform,
                'title' => $request->title,
                'details' => $request->details,
                'budget' => $request->budget,
                'date' => $request->date,
                ]);
                return response()->json([
                    'message' => 'User successfully update',
                    'user' => $followfreelance,
                    'status' => 201
                ]);
            }else {
                return response()->json([
                    'message' => 'failed',
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
