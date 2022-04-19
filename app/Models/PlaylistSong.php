<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistSong extends Model
{
    use HasFactory;

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
