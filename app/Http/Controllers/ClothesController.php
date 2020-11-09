<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clothes;
use App\Category;
use Illuminate\Support\Facades\DB;

class ClothesController extends Controller
{
    //
    public function index()
    {
        $categories = Category::select('name')->get();
        $clothesList = [];
        foreach ($categories as $category) {
            $clothes = Clothes::where('category', $category->name)->where('user_id', 1)->orderBy('created_at', 'desc')->get();
            array_push($clothesList, $clothes);
        }

        return $clothesList;
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $newClothes = new Clothes();
            $newClothes->user_id = 1;
            $newClothes->url = $request->url;
            $newClothes->category = $request->category;
            $newClothes->color = $request->color;
            $newClothes->save();

            //中間テーブルに追加
            $newClothes->tags()->sync($request->tags);
            $newClothes->seasons()->sync($request->seasons);
            DB::commit();
            return $request;
        } catch (\Exception $e) {
            DB::rollback();
            return "エラー：".$e;
        }
    }
}
