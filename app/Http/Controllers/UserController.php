<?php

namespace App\Http\Controllers;

use App\ShareCode;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $user;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    //
    public function user()
    {
        return $this->user;
    }

    public function token()
    {
        $token = $this->user->api_token;
        //return $token;
        return response()->json(['token' => $token], 200);
    }

    public function setArea(Request $request)
    {
        $this->user->weather_area = $request->city;
        $this->user->save();

        return "更新";
    }

    public function getArea()
    {
        //return $this->user->weather_area;
        return response()->json(["display" => $this->user->weather_display,"area" => $this->user->weather_area]);
    }

    public function display(Request $request)
    {
        $this->user->weather_display = $request->display;
        $this->user->save();
        return $this->user->weather_display;
    }

    public function codeChange()
    {
        ShareCode::where('closet_user_id', $this->user->id)->delete();
        $this->user->share_code = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
        $this->user->save();
        return response()->json(["type" => "success","message" => "更新しました"]);
    }
}
