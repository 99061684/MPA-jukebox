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
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres
        ]);
    }

    public function overview($genreid)
    {
        $genres = Genre::all();
        $songs = Genre::find($genreid)->songs()->orderBy('name')->paginate(10);
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres
        ]);
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
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres,
            'genreid' => $genreid,
            'search' => $searchstring,
            'sort' => $sort,
            'order' => $order
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
        return view('Song.show', [
            'song' => Song::find($id)
        ]);
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
