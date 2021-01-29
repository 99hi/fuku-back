<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Clothes;
use App\ShareCode;
use App\Category;
use Auth;

class ShareCodeController extends Controller
{
    private $user_id;
    
    public function __construct()
    {
		$this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            return $next($request);
        });
    }

    public function show()
    {
        $shareCodes = ShareCode::where('user_id', $this->user_id)->get();
        if (!$shareCodes) {
            return "ありません";
        }

        $shareCloset = [];
        $categories = Category::select('name')->get();
        foreach ($shareCodes as $shareCode) {
            $clothesList = [];
            foreach ($categories as $category) {
                $clothes = Clothes::select('id', 'url', 'category', 'color', 'cloudinary_id', 'created_at', 'updated_at')
                                ->with('seasons:name')
                                ->with('tags:name')
                                ->where('category', $category->name)
                                ->where('user_id', $shareCode->closet_user_id)
                                ->orderBy('created_at', 'desc')
                                ->get();
                array_push($clothesList, $clothes);
            }
            array_push($shareCloset, $clothesList);
        }
        return $shareCloset;
        //$returnCloset = array($shareCode->share_username => $clothesList);
        //return $returnCloset;
        return $clothesList;
    }

    public function add(Request $request)
    {
        $user = User::where('share_code', $request->share_code)->first();
        if($user) {
            $newShare = new ShareCode;
            $newShare->user_id = $this->user_id;
            $newShare->closet_user_id = $user->id;
            $newShare->share_code = $user->share_code;
            $newShare->share_username = $request->name;
            $newShare->save();

            return response()->json(["type" => "success","message" => "追加しました"]);
        } else {
            return response()->json(["type" => "error","message" => "コードが存在しません"]);
        }
    }

    public function delete(Request $request) {
        ShareCode::where('id', $request->id)->delete();
        return "削除しました";
    }

    public function shareUser()
    {
        $users = ShareCode::where('user_id', $this->user_id)->get();
        return $users;
    }
}
