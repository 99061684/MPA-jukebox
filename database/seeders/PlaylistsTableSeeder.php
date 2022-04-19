<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlaylistTableSeeder extends Seeder
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
                'name' => 'Playlist 1',
                'description' => 'Playlist 1 description',
                'user_id' => User::where('name', '=', 'bas verdoorn')->get()->first()->id
            ]
        ];

        foreach ($data as $key => $value) {
            Playlist::create($value);
        }
    }
}
