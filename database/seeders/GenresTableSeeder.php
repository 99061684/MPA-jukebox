<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
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
                'name' => 'Pop',
                'description' => 'Pop is een genre van muziek waarin de muziek van de popbanden wordt gespeeld.',
                'image_path' => '',
            ],
            [
                'name' => 'Jazz',
                'description' => 'Jazz is een genre van muziek waarin de muziek van de jazzbanden wordt gespeeld.',
                'image_path' => '',
            ],
            [
                'name' => 'Rock',
                'description' => 'Rock is een genre van muziek waarin de muziek van de rockbanden wordt gespeeld.',
                'image_path' => '',
            ],
            [
                'name' => 'Hip-Hop',
                'description' => 'Hip-Hop is een genre van muziek waarin de muziek van de hip-hopbanden wordt gespeeld.',
                'image_path' => '',
            ],
            [
                'name' => 'Country',
                'description' => 'Country is een genre van muziek waarin de muziek van de countrybanden wordt gespeeld.',
                'image_path' => '',
            ]
        ];

        foreach ($data as $key => $value) {
            Genre::create($value);
        }
    }
}
