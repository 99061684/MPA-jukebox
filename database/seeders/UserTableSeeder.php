<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
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
                'name' => 'bas verdoorn',
                'email' => 'basverdoorn@hotmai.com',
                'password' => bcrypt('adminBas!5')
            ]
        ];
        // 'Jukebox webapplicatie\storage\songs\mr_bleu_sky.mp3'

        foreach ($data as $key => $value) {
            User::create($value);
        }
    }
}
