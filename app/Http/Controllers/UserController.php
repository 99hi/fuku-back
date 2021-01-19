<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function user() {
        return Auth::user();
    }

    public function token() {
        $user = Auth::user();
        $token = $user->api_token;
        //return $token;
        return response()->json(['token' => $token], 200);
    }

}
