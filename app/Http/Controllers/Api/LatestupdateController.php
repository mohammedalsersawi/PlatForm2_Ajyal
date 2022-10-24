<?php

namespace App\Http\Controllers\Api;

use App\Models\Latestupdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class LatestupdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $items =  Latestupdate::latest()->paginate(15);
       return response()->json([
        'current_Page' => $items->currentPage(),
        'total_Page' => $items->total(),
        'per_page' => $items->perPage(),
        'next_Page' => $items->nextPageUrl(),
        'prev_page' => $items->previousPageUrl(),
        'data' => $items->items(),
         'status' => 201
    ]);
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
            'title' => 'required|string',
            'details' => 'required|string',
            'sending_date' => 'required|date',
            'start_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $latestupdate = Latestupdate::create($request->all());
            if ($latestupdate) {
                return response()->json([
                    'message' => 'latestupdate successfully added',
                    'user' => $latestupdate,
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
        $latestupdate = Latestupdate::where('id', $id)->first();
        if ($latestupdate) {
            return response()->json([
                'message' => 'User successfully get',
                'user' => $latestupdate,
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
            ], 404);
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
            'title' => 'required',
            'details' => 'required',
            'sending_date' => 'required',
            'start_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $latestupdate = Latestupdate::where('id', $id)->first();
            if ($latestupdate) {
                $latestupdate->update([
                    'title' => $request->title,
                    'details' => $request->details,
                    'sending_date' => $request->sending_date,
                    'start_date' => $request->start_date,
                ]);
                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $latestupdate,
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
        $latestupdate = Latestupdate::where('id', $id)->first();
        if ($latestupdate) {
            $latestupdate->delete();
            return response()->json([
                'message' => 'deleted successfully',
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 404
            ]);
        }
    }
}
