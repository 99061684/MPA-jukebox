<?php

namespace Database\Seeders;

use App\Models\PlaylistSong;
use Illuminate\Database\Seeder;

class PlaylistsSongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'playlist_id' => 1,
                'song_id' => 1,
            ],
            [
                'playlist_id' => 1,
                'song_id' => 2,
            ]
        ];

        foreach ($data as $key => $value) {
            PlaylistSong::create($value);
        }
    }
}
