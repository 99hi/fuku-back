<?php

use Illuminate\Database\Seeder;
use App\Clothes;

class ClothesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Clothes::create([
            'user_id' => 1,
            'url' => "https://res.cloudinary.com/clothes-hi/image/upload/v1603676273/no74cv4rcgr06jtu9qn2.png",
            'category' => 'アウター',
            'color' => 'black',
        ]);
    }
}
