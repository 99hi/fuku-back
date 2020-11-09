<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Category::insert([
           [ 'id' => 1,
            'name' => 'トップス'],
            [ 'id' => 2,
            'name' => 'アウター'],
            [ 'id' => 3,
            'name' => 'パンツ'],
            [ 'id' => 4,
            'name' => 'シューズ']
        ]);
    }
}
