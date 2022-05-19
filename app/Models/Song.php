<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\PlaylistSong;
use App\Models\Playlist;

class Song extends Model
{
    use HasFactory;

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function getGenreNames()
    {
        $genres = $this->genres()->get();
        $genreNames = [];
        foreach ($genres as $genre) {
            $genreNames[] = $genre->name;
        }
        return $genreNames;
    }

    public function getGenreNamesString()
    {
        return implode(", ", $this->getGenreNames());
    }
}
