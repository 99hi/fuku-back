<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller{

  protected $auth;

  public function __construct(JWTAuth $auth)
  {
    $this->auth = $auth;
    $this->middleware(['social', 'web']);
  }

  public function redirect($service)
  {

    return Socialite::driver($service)->stateless()->redirect();
  }

  public function callback($service) 
  {
    $serviceUser = Socialite::driver($service)->stateless()->user();

    //dd($serviceUser);
    $user = User::where(['account_id' => $serviceUser->getId()])->first();
    

    if($user){
 
      //登録あればそのままログイン（2回目以降）
      Auth::login($user);

      
      $extra = [
        "userid" => $user->id,
        "username" => $user->name,
      ];
      return redirect(env('CLIENT_BASE_URL').'/auth/social-callback?token='. $this->auth->fromUser($user, $extra));

    }else{

      //なければ登録（初回）
      $newuser = new User;
      $newuser->name = $serviceUser->getName();
      $newuser->account_id = $serviceUser->getId();
      $newuser->provider = $service;
      $newuser->save();

      //そのままログイン
      Auth::login($newuser);
      $extra = [
        "userid" => $newuser->id,
        "username" => $newuser->name,
      ];
      return redirect(env('CLIENT_BASE_URL').'/auth/social-callback?token='. $this->auth->fromUser($newuser, $extra));
    }
  }
}