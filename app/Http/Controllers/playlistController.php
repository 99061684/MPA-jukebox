<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Song;
use App\Models\SongSession;

class playlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('playlist.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'public' => 'required|boolean',
            'addSelected' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return Redirect::route('playlist.create')->with('inputData', $request->all())->withErrors($validator);
        }

        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->description = $request->description;
        $playlist->public = $request->public;
        $playlist->user_id = Auth::user()->id;
        $playlist->save();
        if ($request->input('addSelected') == true) {
            $playlist->songs()->attach(SongSession::getSongsid());
        }
        return (new HomeController)->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // check if playlist exists and is owned by user
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if ($playlist == null) {
            return response()->view('home', ['errors' => ['Playlist not found']]);
        }
        $songs = $playlist->songs()->orderBy('name', 'asc')->paginate(10);
        $hasSongs = SongSession::hasSongs();
        return response()->view('playlist.show', ['playlist' => $playlist, 'songs' => $songs, 'hasSongs' => $hasSongs]);
    }

    public function addtoplaylist(Request $request)
    {
        //validate playlistid required int and playlistid exists
        $validator = Validator::make($request->all(), [
            'playlistid' => 'required|integer|exists:playlists,id'
        ]);
        //if validation fails return to home with errors
        if ($validator->fails()) {
            return redirect()->back()->with('error', ['Not a valid playlist id.']);
        }
        //check if playlist exists and is owned by user
        $playlist = Playlist::where('id', $request->playlistid)->where('user_id', Auth::user()->id)->first();
        if ($playlist == null) {
            return redirect()->back()->with('error', ['Playlist not found.']);
        }
        $songs = SongSession::getSongsid();
        $songsExist = true;
        foreach ($songs as $song) {
            if (Song::where('id', $song)->first() === null) {
                $songsExist = false;
                break;
            }
        }
        // attach all songs to playlist
        if ($songsExist) {
            $playlist->songs()->attach($songs);
            return redirect()->back()->with('success', 'Songs added to playlist');
        } else {
            return redirect()->back()->with('error', ['One or more songs do not exist']);
        }
    }

    public function removefromplaylist(Request $request)
    {
        //validate playlistid required int and playlistid exists
        //check if request has songid
        if ($request->has('songid')) {
            $validator = Validator::make($request->all(), [
                'playlistid' => 'required|integer|exists:playlists,id',
                'songid' => 'required|integer|exists:songs,id'
            ]);

            //if validation fails return to home with errors
            if ($validator->fails()) {
                return redirect()->back()->with('error', ['Not a valid playlist id or song id.']);
            }
        }

        // detach songid from playlist
        $playlist = Playlist::where('id', $request->playlistid)->where('user_id', Auth::user()->id)->first();
        if ($playlist == null) {
            return redirect()->back()->with('error', ['Playlist not found.']);
        }
        if ($request->has('songid')) {
            $playlist->songs()->detach($request->songid);
            return redirect()->back()->with('success', 'Songs removed from playlist');
        } else {
            // $playlist->songs()->detach();
            return redirect()->back()->with('error', 'Song cannot be removed from playlist');
        }
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
