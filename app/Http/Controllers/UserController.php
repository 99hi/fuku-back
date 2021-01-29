<?php

namespace App\Http\Controllers;

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
    public function user() {
        return $this->user;
    }

    public function token() {
        $token = $this->user->api_token;
        //return $token;
        return response()->json(['token' => $token], 200);
    }

}
