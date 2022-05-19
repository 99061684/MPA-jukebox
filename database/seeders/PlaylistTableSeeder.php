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
        $colors = [
            '#ff7f50',
            '#87cefa',
            '#da70d6',
            '#32cd32',
            '#6495ed',
            '#ff69b4',
            '#ba55d3',
            '#cd5c5c',
            '#ffa500',
            '#40e0d0',
            '#1e90ff',
            '#ff6347',
            '#7b68ee',
            '#00fa9a',
            '#ffd700',
            '#6b8e23',
            '#ff00ff',
            '#3cb371',
            '#b8860b',
            '#30e0e0'
        ];

        $data = [
            [
                'name' => 'Playlist 1',
                'description' => 'Playlist 1 description',
                'color' => $colors[array_rand($colors)],
                'user_id' => User::where('name', '=', 'bas verdoorn')->get()->first()->id
            ]
        ];

        foreach ($data as $key => $value) {
            Playlist::create($value);
        }
    }
}
