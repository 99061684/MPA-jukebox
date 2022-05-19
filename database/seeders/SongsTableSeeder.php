<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Song;
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
                'genres' => array_merge(array_map(fn($item) => ['name' => ucwords($item)], explode(',', $row[11])))
            ];
        }

        fclose($file);

        foreach ($data as $value) {
            try {
                $song = Song::where('unique_hash', '=', $value['unique_hash'])->get()->first();
                if ($song !== null) {
                    continue;
                }
                if (isset($value['genres'])) {
                    $genres = $value['genres'];
                    unset($value['genres']);
                } else {
                    $genres = [];
                }
                $song = Song::create($value);
                if ($genres !== null) {
                    foreach ($genres as $value) {
                        $genre = Genre::where('name', $value['name'])->get()->first();
                        if ($genre == null) {
                            $genre = Genre::factory()->create(['name' => $value['name']]);
                        }
                        $song->genres()->attach($genre->id);
                    }
                }
            } catch (QueryException $e){
                throw $e;
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
