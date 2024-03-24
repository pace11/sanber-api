<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SpotifyNotifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('spotify_notif')->insert([
            [
                'id' => Str::uuid(),
                'title' => 'Spotify Family Premium Mei 2023',
                'plan' => 6,
                'member_count' => 5,
                'expires_at' => new Carbon('2023-11-30'),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
        ]);
    }
}
