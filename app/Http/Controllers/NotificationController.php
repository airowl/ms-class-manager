<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Cache::rememberForever('notifications', function () {
            return Notification::all();
        });
        return response()->json($notifications);
    }

    public function show($id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $notification = Notification::find($id);
        return response()->json($notification);
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
        $newNotification = new Notification;
        $newNotification->title = (string)$request->title;
        $newNotification->alias = (string)Str::of($request->title)->slug('-');
        $newNotification->description = (string)$request->description;
        $newNotification->classroom_id = (string)$request->classroomId;
        $newNotification->save();
    }

    public function update(Request $request, $id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'description' => 'max:500',
            'classroomId' => 'bail|required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $notification = Notification::find($id);
        $notification->title = (string)$request->title;
        $notification->alias = (string)Str::of($request->title)->slug('-');
        $notification->description = (string)$request->description;
        $notification->classroom_id = (string)$request->classroomId;
        $notification->save();
        return response()->json($notification);
    }

    public function destroy($id)
    {
        if (!isset($id)) {
            return response()->json('id is not valid', 400);
        }
        $notification = Notification::find($id);
        $notification->delete();
        return response()->json(["message"=> "{$id} deleted"]);
    }
}
