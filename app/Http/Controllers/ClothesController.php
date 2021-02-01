<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clothes;
use App\Category;
use App\Season;
use App\Tag;
use Illuminate\Support\Facades\DB;
use Auth;

class ClothesController extends Controller
{
    private $user_id;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            return $next($request);
        });
    }


    public function index()
    {
        $categories = Category::select('name')->get();
        $clothesList = [];
        foreach ($categories as $category) {
            $clothes = Clothes::select('id', 'url', 'category', 'color', 'cloudinary_id', 'created_at', 'updated_at')
                                ->with('seasons:name')
                                ->with('tags:name')
                                ->where('category', $category->name)
                                ->where('user_id', $this->user_id)
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
            $newClothes->user_id = $this->user_id;
            $newClothes->url = $request->url;
            $newClothes->category = $request->category;
            $newClothes->color = $request->color;
            $newClothes->cloudinary_id = $request->cloudinary_id;
            $newClothes->save();

            $tagList = [];
            foreach ($request->tags as $tag) {
                // 普通に新しいのが来たら新規作成する動き
                $record = Tag::firstOrCreate(['name' => $tag, 'user_id' => $this->user_id, 'which' => "clothes"]);
                array_push($tagList, $record->id);
            }

            //中間テーブルに追加
            $newClothes->tags()->sync($tagList);
            $newClothes->seasons()->sync($request->seasons);
            DB::commit();
            return $tagList;
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
                $record = Tag::firstOrCreate(['name' => $tag, 'user_id' => $this->user_id, 'which' => "clothes"]);
                array_push($addTags, $record->id);
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
