<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistSongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            $playlist = Playlist::where('name', '=', 'Playlist 1')->get()->first();
            $songs = [
                [
                    "name" => 'bad guy'
                ],
                [
                    "name" => 'Dynamite'
                ],
            ];
            if ($playlist instanceof Playlist) {
                foreach ($songs as $key => $value) {
                    $song = Song::where('name', '=', $value['name'])->get()->first();
                    if ($song instanceof Song) {
                        $playlist->songs()->attach($song->id);
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
