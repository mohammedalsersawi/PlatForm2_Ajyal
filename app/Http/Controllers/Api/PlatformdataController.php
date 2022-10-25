<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Trainee;
use Illuminate\Support\Str;
use App\Models\Latestupdate;
use App\Models\Platformdata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PlatformdataController extends Controller
{

    public function index()
    {
        $Platformdata =  Platformdata::latest()->paginate(15);
        return response()->json([
            'current_Page' => $Platformdata->currentPage(),
            'total_Page' => $Platformdata->total(),
            'per_page' => $Platformdata->perPage(),
            'next_Page' => $Platformdata->nextPageUrl(),
            'prev_page' => $Platformdata->previousPageUrl(),
            'data' => $Platformdata->items(),
            'status' => 201
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            if ($image = $request->file('value')) {
                $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                $Path = 'uploads/latestnew';
                $image->move($Path, $newfile);
               $hero_image =  Platformdata::create([
                    'key' => $request->key,
                    'value' => "/uploads/latestnew/$newfile",
                ]);
                return response()->json([
                    'message' => 'latestupdate successfully added',
                    'Platformdata' => $hero_image,
                    'status' => 201
                ]);
            }else {
            $Platformdata = Platformdata::create($request->all());
            if ($Platformdata) {
                return response()->json([
                    'message' => 'latestupdate successfully added',
                    'Platformdata' => $Platformdata,
                    'status' => 201
                ]);
            }
        }
    }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {


            if ($image = $request->file('value')) {
                $hero_image = Platformdata::where('key', 'hero_image')->first();
                File::delete(public_path($hero_image->value));
                $newfile =  Str::random(30) . '.' . $image->getClientOriginalName();
                $Path = 'uploads/latestnew';
                $image->move($Path, $newfile);
                $hero_image->update([
                    'value' => "/uploads/latestnew/$newfile",
                ]);
                return response()->json([
                    'message' => 'latestupdate successfully added',
                    'Platformdata' => $hero_image,
                    'status' => 201
                ]);
            }else {
            $Platformdata = Platformdata::where('id', $id)->first();
            if ($Platformdata) {
                $Platformdata->update([
                    'key' => $request->key,
                    'value' => $request->value,
                ]);
                return response()->json([
                    'message' => 'User successfully registered',
                    'Platformdata' => $Platformdata,
                    'status' => 201
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                ], 404);
            }
        }
    }
    }

    public function destroy($id)
    {
        $Platformdata = Platformdata::where('id', $id)->first();
        if ($Platformdata) {
            $Platformdata->delete();
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


    public function statistics()
    {
        $count_male = Trainee::where('gender', 'male')->count();
        $count_female = Trainee::where('gender', 'female')->count();
        $count_course = Course::all()->count();
        $count_activities = Latestupdate::all()->count();
        return response()->json([
            'message' => 'User successfully registered',
            'Platformdata' => [
                'count_male' =>  $count_male,
                'count_female' => $count_female,
                'count_course' => $count_course,
                'count_activities' => $count_activities,
            ],
            'status' => 201
        ]);
    }
}
