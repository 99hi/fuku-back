<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Auth;

class TagController extends Controller
{
    private $user_id;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            return $next($request);
        });
    }
    //
    public function clothesTag()
    {
        return Tag::where('user_id', $this->user_id)->where('which', "clothes")->pluck('name');
    }

    public function coordinationTag()
    {
        return Tag::where('user_id', $this->user_id)->where('which', "coordinations")->pluck('name');
    }
}
