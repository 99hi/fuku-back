<?php

use Illuminate\Database\Seeder;
use App\ClothesTag;

class Clothes_TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ClothesTag::insert([
            ['clothes_id' => 1,
            'tag_id' => 1],
            ['clothes_id' => 1,
            'tag_id' => 2],
        ]);

    }
}
