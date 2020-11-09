<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'id' => 0,
            'provider' => 'test',
            'account_id' => '12345',
            'name' => 'test',
        ]);

    }
}
