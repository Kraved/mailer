<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = [
            [
                'name' => 'admin',
                'email' => 'it@lexsystems.ru',
                'email_verified_at' => now(),
                'password' => password_hash('admin', PASSWORD_DEFAULT), // password
                'remember_token' => Str::random(10),
            ],
        ];
        DB::table('users')->insert($users);

    }
}
