<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class HomeworkController extends Controller
{
    public function index()
    {
        $homeworks = Cache::rememberForever('homeworks', function () {
            return Homework::all();
        });
        return response()->json($homeworks);
    }

    public function show($id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $homework = Homework::find($id);
        return response()->json($homework);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'description' => 'max:500',
            'classroomId' => 'bail|required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newHomework = new Homework;
        $newHomework->title = (string)$request->title;
        $newHomework->alias = (string)Str::of($request->title)->slug('-');
        $newHomework->description = (string)$request->description;
        $newHomework->classroom_id = (string)$request->classroomId;
        $newHomework->save();
        return response()->json($newHomework);
    }

    public function update(Request $request, $id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'description' => 'max:500'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $homework = Homework::find($id);
        $homework->title = (string)$request->title;
        $homework->alias = (string)Str::of($request->title)->slug('-');
        $homework->description = (string)$request->description;
        $homework->save();
        return response()->json($homework);
    }

    public function destroy($id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $homework = Homework::find($id);
        $homework->delete();
        return response()->json(['message' => '{$id} deleted']);
    }
}
