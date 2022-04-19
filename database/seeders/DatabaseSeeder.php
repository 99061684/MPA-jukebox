<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\SongsTableSeeder;
use Database\Seeders\GenresTableSeeder;
use Database\Seeders\PlaylistTableSeeder;
use Database\Seeders\PlaylistsSongsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenresTableSeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PlaylistTableSeeder::class);
        $this->call(PlaylistsSongsTableSeeder::class);
    }
}
