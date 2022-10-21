<?php

namespace App\Http\Controllers\Api;

use App\Models\Latestnew;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class LatestnewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Latestnew =  Latestnew::latest()->paginate(5);
        return response()->json([
            'message' => 'All Latestnew',
            'user' => $Latestnew,
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
            'image' => 'required',
            'title' => 'required',
            'details' => 'required',
            'created_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            if ($image = $request->file('image')) {
                $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                $Path = 'uploads/latestnew';
                $image->move($Path, $newfile);
            }
            $latestnew = Latestnew::create([
                'title' => $request->title,
                'details' => $request->details,
                'created_date' => $request->created_date,
                'image' => $newfile,

            ]);
            if ($latestnew) {
                return response()->json([
                    'message' => 'latestnew successfully added',
                    'user' => $latestnew,
                    'status' => 201
                ]);
            }
            return response()->json([
                'message' => 'failed',
            ], 404);
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
        $latestnew = Latestnew::where('id', $id)->first();
        if ($latestnew) {
            return response()->json([
                'message' => 'User successfully get',
                'user' => $latestnew,
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
            'created_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $latestnew = Latestnew::where('id', $id)->first();
            if ($latestnew) {
                if ($image = $request->file('image')) {
                    File::delete(public_path('uploads/latestnew/' . $latestnew->image));
                    $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                    $Path = 'uploads/latestnew';
                    $image->move($Path, $newfile);
                }

                $latestnew->update([
                    'title' => $request->title,
                    'details' => $request->details,
                    'created_date' => $request->created_date,
                    'image' => $newfile,
                ]);

                return response()->json([
                    'message' => 'User successfully registered',
                    'user' => $latestnew,
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
        $latestnew = Latestnew::where('id', $id)->first();
        if ($latestnew) {
            $latestnew->delete();
            File::delete(public_path('uploads/latestnew/' . $latestnew->image));
            return response()->json([
                'message' => 'deleted successfully',
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 404
            ], 404);
        }
    }
}
