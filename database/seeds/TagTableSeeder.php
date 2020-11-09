<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Tag::insert([
           [ 'id' => 1,
           'user_id' => 1,
            'name' => 'コート'],
            [ 'id' => 2,
            'user_id' => 1,
            'name' => 'ジャケット'],
            [ 'id' => 3,
            'user_id' => 1,
            'name' => 'ベスト'],
            [ 'id' => 4,
            'user_id' => 1,
            'name' => 'パーカー'],
            [ 'id' => 5,
            'user_id' => 1,
            'name' => 'スウェット'],
            [ 'id' => 6,
            'user_id' => 1,
            'name' => 'ニット'],
            [ 'id' => 7,
            'user_id' => 1,
            'name' => 'Tシャツ'],
            [ 'id' => 8,
            'user_id' => 1,
            'name' => 'シャツ'],
        ]);
    }
}
