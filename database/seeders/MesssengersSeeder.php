<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesssengersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messengers')->insert(
            [
                'id'=>3,
                'name' => 'email',
                'display_name' => 'E-mail',
            ],
        );

        DB::table('messengers')->insert(
            [
                'id'=>4,
                'name' => 'telegram',
                'display_name' => 'Telegram',
            ],
        );

        DB::table('messengers')->insert(
            [
                'id'=>5,
                'name' => 'viber',
                'display_name' => 'Viber',
            ],
        );

    }
}
