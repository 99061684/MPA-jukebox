<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Genre;
use App\Models\SongSession;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overviewAll()
    {
        $genres = Genre::all();
        $songs = Song::orderBy('name')->paginate(10);
        $spotify_client_id = Session::get('spotify_client_id');
        $spotify_client_secret = Session::get('spotify_client_secret');

        Session::put('sortandsearch.search', null);
        Session::put('sortandsearch.genreid', null);
        Session::put('sortandsearch.sort', 'name');
        Session::put('sortandsearch.order', 'asc');

        $search = Session::get('sortandsearch.search');
        $genreid = Session::get('sortandsearch.genreid');
        $sort = Session::get('sortandsearch.sort');
        $order = Session::get('sortandsearch.order');

        return response()->view('song.index', ['songs' => $songs, 'genres' => $genres, 'search' => $search, 'genreid' => $genreid, 'sort' => $sort, 'order' => $order, 'spotify_client_id' => $spotify_client_id, 'spotify_client_secret' => $spotify_client_secret]);
    }

    public function overview($genreid)
    {
        $genres = Genre::all();
        $songs = Genre::find($genreid)->songs()->orderBy('name')->paginate(10);
        $spotify_client_id = Session::get('spotify_client_id');
        $spotify_client_secret = Session::get('spotify_client_secret');

        Session::put('sortandsearch.search', null);
        Session::put('sortandsearch.genreid', $genreid);
        Session::put('sortandsearch.sort', 'name');
        Session::put('sortandsearch.order', 'asc');

        $search = Session::get('sortandsearch.search');
        $genreid = Session::get('sortandsearch.genreid');
        $sort = Session::get('sortandsearch.sort');
        $order = Session::get('sortandsearch.order');

        return response()->view('song.index', ['songs' => $songs, 'genres' => $genres, 'search' => $search, 'genreid' => $genreid, 'sort' => $sort, 'order' => $order, 'spotify_client_id' => $spotify_client_id, 'spotify_client_secret' => $spotify_client_secret]);
    }

    public function sortandsearch(Request $request)
    {
        $genres = Genre::all();
        if ($request->has('search')) {
            Session::put('sortandsearch.search', trim($request->input('search')));
        } else if (!Session::has('sortandsearch.search')) {
            Session::put('sortandsearch.search', '');
        }
        if ($request->has('genreid')) {
            Session::put('sortandsearch.genreid', $request->input('genreid'));
        } else if (!Session::has('sortandsearch.genreid')) {
            Session::put('sortandsearch.genreid', null);
        }
        if ($request->has('sort')) {
            Session::put('sortandsearch.sort', $request->input('sort'));
        } else if (!Session::has('sortandsearch.sort')) {
            Session::put('sortandsearch.sort', 'name');
        }
        if ($request->has('order')) {
            Session::put('sortandsearch.order', $request->input('order'));
        } else if (!Session::has('sortandsearch.order')) {
            Session::put('sortandsearch.order', 'asc');
        }
        $searchstring = Session::get('sortandsearch.search');
        $search = explode(' ', $searchstring);
        $genreid = Session::get('sortandsearch.genreid');
        $sort = Session::get('sortandsearch.sort');
        $order = Session::get('sortandsearch.order');
        $spotify_client_id = Session::get('spotify_client_id');
        $spotify_client_secret = Session::get('spotify_client_secret');

        $songs = Song::when($searchstring !== '' && $searchstring !== null, function ($query) use ($search) {
            foreach ($search as $word) {
                if(strlen($word) > 2) {
                    $query->orWhere('name', 'like', '%' . $word . '%');
                    $query->orWhere('artist', 'like', '%' . $word . '%');
                    $query->orWhere('band', 'like', '%' . $word . '%');
                    $query->orWhere('album', 'like', '%' . $word . '%');
                }
            }
        })->when($genreid !== null, function ($query) use ($genreid) {
            return $query->whereHas('genres', function($query) use ($genreid) {
                $query->where('genre_id', $genreid);
            });
        })
        ->orderBy($sort, $order)
        ->paginate(10);
        response()->view('song.index', [
            'songs' => $songs,
            'genres' => $genres,
            'search' => $searchstring,
            'genreid' => $genreid,
            'sort' => $sort,
            'order' => $order,
            'spotify_client_id' => $spotify_client_id,
            'spotify_client_secret' => $spotify_client_secret
        ]);
    }

    public function selectSong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'songid' => 'required|integer|exists:songs,id'
        ]);
        if (!$validator->fails()) {
            $songid = $request->input('songid');
            SongSession::initlilize();
            if (SongSession::checkSong($songid)) {
                SongSession::removeSongId($songid);
            } else {
                SongSession::addSongId($songid);
            }
        }
        return redirect()->back();
    }

    // addtoplaylist
    public function addtoplaylist(Request $request)
    {
        //check if song exists
        $song = Song::where('id', $request->songid)->first();
        if ($song === null) {
            return redirect()->back()->with('error', 'Song not found');
        }
        //check if playlist exists
        $playlist = Playlist::where('id', $request->playlistid)->first();
        if ($playlist === null) {
            return redirect()->back()->with('error', 'Playlist not found');
        }
        //check if playlist is owned by user
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not allowed to add songs to this playlist');
        }

        // check playlist with song
        if ($song->playlists->contains($playlist)) {
            return redirect()->back()->with('error', 'Song is already in playlist');
        }
        $song->playlists()->attach($playlist->id);
        return redirect()->back()->with('success', 'Song added to playlist');
    }

    // removefromplaylist
    public function removefromplaylist(Request $request)
    {
        //check if song exists
        $song = Song::where('id', $request->songid)->first();
        if ($song === null) {
            return redirect()->back()->with('error', 'Song not found');
        }
        //check if playlist exists
        $playlist = Playlist::where('id', $request->playlistid)->first();
        if ($playlist === null) {
            return redirect()->back()->with('error', 'Playlist not found');
        }
        //check if playlist is owned by user
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not allowed to remove songs from this playlist');
        }
        // check if song is not in playlist
        if (!playlist::with('songs')->where('user_id', Auth::id())->get()->contains($playlist)) {
            return redirect()->back()->with('error', 'Song is not in playlist');
        }
        $song->playlists()->detach($playlist->id);
        return redirect()->back()->with('success', 'Song removed from playlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $song = Song::find($id);
        $spotify_client_id = Session::get('spotify_client_id');
        $spotify_client_secret = Session::get('spotify_client_secret');
        return response()->view('song.show', ['song' => $song, 'spotify_client_id' => $spotify_client_id, 'spotify_client_secret' => $spotify_client_secret]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
