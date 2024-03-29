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
        $items = FollowFreelance::where('user_id', $user->id)->latest()->paginate(15);
        if ($items) {
            return response()->json([
                'current_Page' => $items->currentPage(),
                'total_Page' => $items->total(),
                'per_page' => $items->perPage(),
                'next_Page' => $items->nextPageUrl(),
                'prev_page' => $items->previousPageUrl(),
                'data' => $items->items(),
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
            ], 404);
        }
    }

    public function show_freelances()
    {
        $show_freelances = FollowFreelance::with('trainee:user_id,name')
            ->orderByRaw('user_id')
            ->latest()->paginate(15);
        if ($show_freelances) {
            return response()->json([
                'current_Page' => $show_freelances->currentPage(),
                'total_Page' => $show_freelances->total(),
                'per_page' => $show_freelances->perPage(),
                'next_Page' => $show_freelances->nextPageUrl(),
                'prev_page' => $show_freelances->previousPageUrl(),
                'data' => $show_freelances->items(),
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 404,
            ]);
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

        $items = FollowFreelance::find($id);
        if ($items) {
            return response()->json([
                'message' => 'followfreelance successfully get',
                'FollowFreelance' => $items,
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 404

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            $user = Auth::guard('sanctum')->user();
            $total_income_tra = Trainee::where('user_id', $user->id)->first();
            $total_income = $total_income_tra->total_income;
            $old_income = $followfreelance->budget;
            $update_income = $total_income - $old_income;
            $new_income = $update_income + $request->budget;
            $total_income_tra->update([
                'total_income' => $new_income,
            ]);
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
            } else {
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
        $user = Auth::guard('sanctum')->user();
        $total_income_tra = Trainee::where('user_id', $user->id)->first();
        $total_income = $total_income_tra->total_income;
        $FollowFreelance = FollowFreelance::where('id', $id)->first();
        $old_income = $FollowFreelance->budget;
        $new_income = $total_income - $old_income;
        $total_income_tra->update([
            'total_income' => $new_income,
        ]);
        $course = FollowFreelance::destroy($id);

        if ($course) {
            return response()->json([
                'message' => 'FollowFreelance deleted successfully',
                'status' => 201
            ]);
        } else {
            return response()->json([
                'massage' => 'Faild',
            ]);
        }
    }
}
