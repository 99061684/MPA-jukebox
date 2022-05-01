<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->call(PlaylistSongTableSeeder::class);
    }
}
