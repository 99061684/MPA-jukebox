<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Song;
use FFI\Exception;
use Illuminate\Database\QueryException;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make song foreach row in muziek data.csv wih the following columns: name, artist, album, duration, song_path, genre_id
        $data = [];
        $file = fopen(storage_path('app/public/muziek.csv'), 'r');
        while (($row = fgetcsv($file, null, ';')) !== false) {
            if ($row[0] == 'Track URI') {
                continue;
            }
            $trackurl = "https://open.spotify.com/embed/track/" .substr($row[0], strrpos($row[0], ':') + 1);
            $data[] = [
                'name' => trim($row[1]),
                'artist' => trim($row[2]),
                'band' => trim($row[6]),
                'album' => trim($row[4]),
                'duration' => Carbon::createFromFormat('H:i:s', $this->formatSeconds($row[9])),
                'song_path' => trim($trackurl),
                'unique_hash' => md5($row[1] . $row[2] . $row[6] . $row[4]),
                // 'genre_id' => Genre::where('name', '=', $row[5])->get()->first()->id
                'genre_id' => Genre::where('name', '=', 'pop')->get()->first()->id
            ];
        }
        fclose($file);

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
        //         'song_path' => 'https://open.spotify.com/embed/track/2RlgNHKcydI9sayD2Df2xp?si=86f76e3661164b86',
        //         'genre_id' => Genre::where('name', '=', 'Pop')->get()->first()->id
        //     ],
        //     [
        //         'name' => 'Classic',
        //         'artist' => 'MKTO',
        //         'album' => 'MKTO',
        //         'duration' => Carbon::createFromFormat('H:i:s', '0:02:55'),
        //         'song_path' => 'https://open.spotify.com/embed/track/6FE2iI43OZnszFLuLtvvmg?si=047227ab759d419e',
        //         'genre_id' => Genre::where('name', '=', 'Pop')->get()->first()->id
        //     ]
        // ];

        foreach ($data as $key => $value) {
            try {
                Song::create($value);
            } catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode !== 1062){
                    throw $e;
                }
            }
        }
    }

    function formatSeconds( $miliseconds ) {
        $seconds = round($miliseconds / 1000, 0, PHP_ROUND_HALF_UP);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        $hours = intval($hours);
        $minutes = intval($minutes);
        $seconds = intval($seconds);

        if ($hours < 10) {
            $hours = '0' . $hours;
        }
        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }
        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        }
        return "{$hours}:{$minutes}:{$seconds}";
    }
}
