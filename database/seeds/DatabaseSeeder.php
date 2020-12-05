<?php

use App\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            TagTableSeeder::class,
            SeasonTableSeeder::class,
            CategoryTableSeeder::class
        ]);
    }
}
