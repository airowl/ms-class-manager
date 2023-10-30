<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Cache::rememberForever('classrooms', function () {
            return Classroom::all();
        });
        return response()->json($classrooms);
    }

    public function show($id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $classroom = Classroom::find($id);
        return response()->json($classroom);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'description' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newClass = new Classroom;
        $newClass->title = (string)$request->title;
        $newClass->alias = (string)Str::of($request->title)->slug('-');
        $newClass->teacher_id = (string)$request->teacher_id;
        $newClass->subject = (string)$request->subject;
        $newClass->description = (string)$request->description;
        $newClass->save();
        return response()->json($newClass);
    }

    public function update(Request $request, $id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'description' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $class = Classroom::find($id);
        $class->title = (string)$request->title;
        $class->alias = (string)Str::of($request->title)->slug('-');
        $class->subject = (string)$request->subject;
        $class->description = (string)$request->description;
        $class->save();
        return response()->json($class);
    }

    public function destroy($id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $classroom = Classroom::find($id);
        $classroom->delete();
        return response()->json(["message"=> "{$id} deleted"]);
    }
}
