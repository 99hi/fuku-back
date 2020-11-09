<?php

use App\Season;
use Illuminate\Database\Seeder;

class SeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Season::insert([
           [ 'id' => 1,
            'name' => '春'],
            [ 'id' => 2,
            'name' => '夏'],
            [ 'id' => 3,
            'name' => '秋'],
            [ 'id' => 4,
            'name' => '冬']
        ]);
    }
}
