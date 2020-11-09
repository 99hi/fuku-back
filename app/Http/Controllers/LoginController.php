<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    //
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
 
    //Callback処理
    public function handleProviderCallback($social)
    {
        //ソーシャルサービス（情報）を取得
        $userSocial = Socialite::driver($social)->stateless()->user();
        //emailで登録を調べる
        $user = User::where(['account_id' => $userSocial->getId()])->first();
 
        //登録（email）の有無で分岐
        if($user){
 
            //登録あればそのままログイン（2回目以降）
            Auth::login($user);
            return redirect('/ok1');
 
        }else{
 
            //なければ登録（初回）
            $newuser = new User;
            $newuser->name = $userSocial->getName();
            $newuser->email = $userSocial->getId();
            $newuser->provider = $social;
            $newuser->save();
 
            //そのままログイン
            Auth::login($newuser);
            return redirect('/ok2');
 
        }
    }
}
