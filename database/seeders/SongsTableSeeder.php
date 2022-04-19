<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Song;
use Illuminate\Support\Facades\URL;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = [
        //     [
        //         'name' => 'Ice Ice Baby',
        //         'artist' => 'Vannilla Ice',
        //         'album' => 'Vannilla Ice Is Back! - Hip Hop Classics',
        //         'duration' => Carbon::createFromFormat('H:i:s', '0:04:14'),
        //         'song_path' => 'https://open.spotify.com/embed/track/3XVozq1aeqsJwpXrEZrDJ9?si=6647a6926a794066',
        //         'genre_id' => Genre::where('name', '=', 'Hip-Hop')->get()->first()->id
        //     ],
        //     [
        //         'name' => 'Mr. Blue Sky',
        //         'artist' => 'Louis Clark',
        //         'band' => 'Electric Light Orchestra',
        //         'album' => 'Out of the Blue',
        //         'duration' => Carbon::createFromFormat('H:i:s', '0:05:03'),
        //         'song_path' => '/mr_bleu_sky.mp3',
        //         'genre_id' => Genre::where('name', '=', 'Pop')->get()->first()->id
        //     ],
        //     [
        //         'name' => 'Classic',
        //         'artist' => 'MKTO',
        //         'album' => 'MKTO',
        //         'duration' => Carbon::createFromFormat('H:i:s', '0:02:55'),
        //         'song_path' => '/MKTO_Classic.mp3',
        //         'genre_id' => Genre::where('name', '=', 'Pop')->get()->first()->id
        //     ]
        // ];

        $data = [
            [
                'name' => 'Ice Ice Baby',
                'artist' => 'Vannilla Ice',
                'album' => 'Vannilla Ice Is Back! - Hip Hop Classics',
                'duration' => Carbon::createFromFormat('H:i:s', '0:04:14'),
                'song_path' => 'https://open.spotify.com/embed/track/3XVozq1aeqsJwpXrEZrDJ9?si=6647a6926a794066',
                'genre_id' => Genre::where('name', '=', 'Hip-Hop')->get()->first()->id
            ],
            [
                'name' => 'Mr. Blue Sky',
                'artist' => 'Louis Clark',
                'band' => 'Electric Light Orchestra',
                'album' => 'Out of the Blue',
                'duration' => Carbon::createFromFormat('H:i:s', '0:05:03'),
                'song_path' => 'https://open.spotify.com/embed/track/2RlgNHKcydI9sayD2Df2xp?si=86f76e3661164b86',
                'genre_id' => Genre::where('name', '=', 'Pop')->get()->first()->id
            ],
            [
                'name' => 'Classic',
                'artist' => 'MKTO',
                'album' => 'MKTO',
                'duration' => Carbon::createFromFormat('H:i:s', '0:02:55'),
                'song_path' => 'https://open.spotify.com/embed/track/6FE2iI43OZnszFLuLtvvmg?si=047227ab759d419e',
                'genre_id' => Genre::where('name', '=', 'Pop')->get()->first()->id
            ]
        ];
        // 'Jukebox webapplicatie\storage\songs\mr_bleu_sky.mp3'

        foreach ($data as $key => $value) {
            Song::create($value);
        }
    }
}
