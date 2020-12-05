<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clothes;
use App\Category;
use App\Season;
use App\Tag;
use Illuminate\Support\Facades\DB;

class ClothesController extends Controller
{
    //
    public function index()
    {
        $categories = Category::select('name')->get();
        $clothesList = [];
        foreach ($categories as $category) {
            $clothes = Clothes::select('id', 'url', 'category', 'color', 'cloudinary_id', 'created_at', 'updated_at')
                                ->with('seasons:name')
                                ->with('tags:name')
                                ->where('category', $category->name)
                                ->where('user_id', 1)
                                ->orderBy('created_at', 'desc')
                                ->get();
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
            $newClothes->cloudinary_id = $request->cloudinary_id;
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

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $updateClothes = Clothes::where('id', $id)->first();

            $updateClothes->category = $request->data['category'];
            $updateClothes->color = $request->data['color'];

            //中間テーブル削除
            $updateClothes->tags()->detach();
            $updateClothes->seasons()->detach();

            //中間テーブル登録
            $addTags = [];
            foreach ($request->data['tags'] as $tag) {
                $tagId = Tag::select('id')->where('name', $tag)->value('id');
                array_push($addTags, $tagId);
            };
            $updateClothes->tags()->sync($addTags);

            $addSeasons = [];
            foreach ($request->data['seasons'] as $season) {
                $seasonId = Season::select('id')->where('name', $season)->value('id');
                array_push($addSeasons, $seasonId);
            };
            $updateClothes->seasons()->sync($addSeasons);

            $updateClothes->save();

            DB::commit();
            return "更新しました";
        } catch (\Exception $e) {
            DB::rollback();
            return "エラー：".$e;
        }
    }

    public function clothesCoordinations($id)
    {
        $coordinations = Clothes::select('id')->with('coordinations')->where('id', $id)->get();
        return $coordinations;
    }
}
