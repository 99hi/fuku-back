<?php

namespace App\Http\Controllers;

use App\Calendar;
use Auth;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    private $user_id;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            return $next($request);
        });
    }

    public function index()
    {
        $event = Calendar::where('user_id', $this->user_id)->with(['coordination' => function ($q) {
            $q->select('id', 'url');
        }])->get();

        return $event;
    }

    public function add(Request $request)
    {
        $newEvent = new Calendar();
        $newEvent->user_id = $this->user_id;
        $newEvent->name = $request->name;
        $newEvent->start = $request->start;
        $newEvent->color = $request->color;
        $newEvent->coordinations_id = $request->selected["id"];
        $newEvent->save();

        return response()->json(['message' => "登録しました"]);
    }

    public function delete(Request $request)
    {
        Calendar::where('id', $request->id)->delete();

        return response()->json(['message' => "削除しました"]);
    }
}
