<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MailListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $mails = [];
        for ($i = 0; $i < 100; $i++) {
            $mails[] =
                [
                    'email' => $faker->email,
                    'created_at' => now(),
                ];
        }

        DB::table('mail_list')->insert($mails);
    }
}
