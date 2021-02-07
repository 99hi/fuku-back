<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller
{
    public function redirect($service)
    {
        $redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json([
        'redirect_url' => $redirectUrl
    ]);
    }

    public function callback($service)
    {
        $serviceUser = Socialite::driver($service)->stateless()->user();

        $user = User::where(['account_id' => $serviceUser->getId()])->first();
    

        if ($user) {
 
            //登録あればそのままログイン（2回目以降）
            Auth::login($user);

            return redirect(env('CLIENT_BASE_URL').'/auth/social-callback?token='. $user->api_token);
        } else {

            //なければ登録（初回）
            $newuser = new User;
            $newuser->name = $serviceUser->getName();
            $newuser->account_id = $serviceUser->getId();
            $newuser->provider = $service;
            $newuser->api_token = mb_substr($serviceUser->token, 0, 30);
            $newuser->share_code = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
            $newuser->picture = $serviceUser->avatar;
            $newuser->weather_display = false;
            $newuser->weather_area = "山口";
            $newuser->save();

            //そのままログイン
            Auth::login($newuser);

            return redirect(env('CLIENT_BASE_URL').'/auth/social-callback?token='. $newuser->api_token);
        }
    }
}
