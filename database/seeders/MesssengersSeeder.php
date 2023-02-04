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
                'name' => 'email',
                'display_name' => 'E-mail',
            ],
        );

        DB::table('messengers')->insert(
            [
                'name' => 'telegram',
                'display_name' => 'Telegram',
            ],
        );

        DB::table('messengers')->insert(
            [
                'name' => 'viber',
                'display_name' => 'Viber',
            ],
        );

    }
}
