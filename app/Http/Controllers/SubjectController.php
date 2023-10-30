<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Cache::rememberForever('subjects', function () {
            return Subject::all();
        });
        return response()->json($subjects);
    }

    public function show($id)
    {
        $subject = Subject::find($id);
        return response()->json($subject);
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
        $newSubject = new Subject;
        $newSubject->title = (string)$request->title;
        $newSubject->alias = (string)Str::of($request->title)->slug('-');
        $newSubject->description = (string)$request->description;
        $newSubject->save();
        return response()->json($newSubject);
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
        $subject = Subject::find($id);
        $subject->title = (string)$request->title;
        $subject->alias = (string)Str::of($request->title)->slug('-');
        $subject->description = (string)$request->description;
        $subject->save();
        return response()->json($subject);
    }

    public function destroy($id)
    {
        $subject = Subject::find($id);
        $subject->delete();
        return response()->json(["message"=> "{$id} deleted"]);
    }
}
