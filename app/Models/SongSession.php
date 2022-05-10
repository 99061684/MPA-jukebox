<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class SongSession
{
    private const SESSION_KEY_NAME = 'playlistSongs';

    // Add a song to the session
    public static function addSong(Song $song)
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if ($songs === null) {
            $songs = [];
        } else {
            $songs[] = $song->id;
        }
        self::saveSong($songs);
    }

    public static function addSongId(int $song_id)
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if ($songs === null) {
            $songs = [];
        } else {
            $songs[] = $song_id;
        }

        self::saveSong($songs);
    }

    public static function removeSong(Song $song)
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if (empty($songs)) {
            $songs = [];
        } else if (in_array($song->id, $songs)) {
            $songs = array_diff($songs, [$song->id]);
        }
        self::saveSong($songs);
    }

    public static function removeSongId(int $song_id)
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if (empty($songs)) {
            $songs = [];
        } else if (in_array($song_id, $songs)) {
            $songs = array_diff($songs, [$song_id]);
        }
        self::saveSong($songs);
    }

    public static function checkSong($id)
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if (empty($songs)) {
            return false;
        }
        return in_array($id, $songs);
    }

    public static function getSongs()
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if (empty($songs)) {
            return [];
        }
        $songModels = array_map(function ($id) {
            return Song::find($id);
        }, $songs);
        return $songModels;
    }

    public static function getSongsWithColumn($column)
    {
        $songs = Session::get(self::SESSION_KEY_NAME);
        if (empty($songs)) {
            return [];
        }
        $songModels = array_map(function ($id) use ($column) {
            return Song::find($id)->$column;
        }, $songs);
        return $songModels;
    }

    public static function getSongsid()
    {
        self::initlilize();
        $songs = Session::get(self::SESSION_KEY_NAME);
        if ($songs === null) {
            return [];
        }
        return $songs;
    }

    public static function hasSongs()
    {
        self::initlilize();
        $songs = Session::get(self::SESSION_KEY_NAME);
        if (empty($songs)) {
            return false;
        }
        return true;
    }


    public static function initlilize()
    {
        if (!Session::has(self::SESSION_KEY_NAME)) {
            Session::put(self::SESSION_KEY_NAME, []);
            Session::save();
        }
    }

    public static function saveSong($songs)
    {
        Session::put(self::SESSION_KEY_NAME, $songs);
        Session::save();
    }
}
