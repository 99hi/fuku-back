<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Auth;

class LoginController extends Controller
{
    //
    public function guestLogin()
    {
        $user = User::where('provider', 'test')->first();
        Auth::login($user);
        return response()->json([
            'redirect_url' => env('CLIENT_BASE_URL').'/auth/social-callback?token='. $user->api_token
        ]);
    }
}
