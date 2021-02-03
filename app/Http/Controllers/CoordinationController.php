<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clothes;
use App\Coordination;
use App\ClothesCoordination;
use App\Season;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Tag;

class CoordinationController extends Controller
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
        $coordination = Coordination::select('id', 'url')->where('user_id', $this->user_id)->with('seasons')->with('tags:name')->with(['clothes' => function ($q) {
            $q->select('id', 'url', 'category', 'color', 'x', 'y', 'width', 'height');
        }])->orderBy('created_at', 'desc')->get();

        return $coordination;
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $newCoordination = new Coordination();
            $newCoordination->user_id = $this->user_id;
            $newCoordination->cloudinary_id = $request->cloudinary_id;
            $newCoordination->url = $request->url;
            $newCoordination->save();

            $tagList = [];
            foreach ($request->tags as $tag) {
                // 普通に新しいのが来たら新規作成する動き
                $record = Tag::firstOrCreate(['name' => $tag, 'user_id' => $this->user_id, 'which' => "coordinations"]);
                array_push($tagList, $record->id);
            }

            $newCoordination->tags()->sync($tagList);
            $newCoordination->seasons()->sync($request->seasons);

            foreach ($request->clothesList as $clothes) {
                $newCoordinateClothes = new ClothesCoordination();
                $newCoordinateClothes->coordinations_id = $newCoordination->id;
                $newCoordinateClothes->clothes_id = $clothes['id'];
                $newCoordinateClothes->x = $clothes['x'];
                $newCoordinateClothes->y = $clothes['y'];
                $newCoordinateClothes->width = $clothes['w'];
                $newCoordinateClothes->height = $clothes['h'];

                $newCoordinateClothes->save();
            }
            DB::commit();
            return $newCoordination;
        } catch (\Exception $e) {
            DB::rollback();
            return "エラー：".$e;
        }
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $updateCoordination = Coordination::where('id', $id)->first();

            //中間テーブル削除
            $updateCoordination->tags()->detach();
            $updateCoordination->seasons()->detach();

            //中間テーブル登録
            $addTags = [];
            foreach ($request->data['tags'] as $tag) {
                $record = Tag::firstOrCreate(['name' => $tag, 'user_id' => $this->user_id, 'which' => "coordinations"]);
                array_push($addTags, $record->id);
            };
            $updateCoordination->tags()->sync($addTags);

            $addSeasons = [];
            foreach ($request->data['seasons'] as $season) {
                $seasonId = Season::select('id')->where('name', $season)->value('id');
                array_push($addSeasons, $seasonId);
            };
            $updateCoordination->seasons()->sync($addSeasons);

            $updateCoordination->save();

            DB::commit();
            return "更新しました";
        } catch (\Exception $e) {
            DB::rollback();
            return "エラー：".$e;
        }
    }

    public function delete($id)
    {
        $coordination = Coordination::find($id);
        $coordination->delete();

        return response()->json(['message' => "削除しました"]);
    }
}
