<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Clothes;
use App\ShareCode;
use App\Category;

class ShareCodeController extends Controller
{
    //
    public function show()
    {
        $shareCodes = ShareCode::where('user_id', 1)->get();
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
        $code = "98765432";
        $newShare = new ShareCode;

        $user = User::select('share_code')->where('share_code', $code)->first();
        $newShare->user_id = 1;
        $newShare->share_code = $user->share_code;
        $newShare->share_username = "兄";
        $newShare->save();

        return $newShare;
    }

    public function shareUser()
    {
        $users = ShareCode::where('user_id', 1)->get();

        return $users;
    }
}
