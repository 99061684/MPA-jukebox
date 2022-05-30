<?php

namespace App\Http\Controllers;

use App\Models\SongSession;
use App\Models\Song;
use App\Models\Playlist;
use App\Rules\NamePattern;
use App\Rules\ColorPattern;
use App\Rules\DescriptionPattern;
use App\Rules\BooleanRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $hasSongs = SongSession::hasSongs();
        return response()->view('playlist.create', ['hasSongs' => $hasSongs]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['bail', 'required', 'max:255', new NamePattern()],
            'description' => [new DescriptionPattern()],
            'color' => ['bail', 'required', new ColorPattern()],
            'public' => ['bail', 'required', new BooleanRule()],
            'addSelected' => ['bail', 'required', new BooleanRule()]
        ]);

        if ($validator->fails()) {
            $hasSongs = SongSession::hasSongs();
            return response()->view('playlist.create', ['hasSongs' => $hasSongs, 'inputData' => $request->all(), 'ValidationErrors' => $validator->errors()->getMessages()]);
        }
        if ($request->description === null) {
            $request->description = '';
        }

        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->description = $request->description;
        $playlist->color = $request->color;
        $playlist->public = $request->public;
        $playlist->user_id = Auth::user()->id;
        $playlist->save();
        if (filter_var($request->addSelected, FILTER_VALIDATE_BOOLEAN)) {
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
        $username = $playlist->user()->first()->name;
        return response()->view('playlist.show', ['playlist' => $playlist, 'songs' => $songs, 'hasSongs' => $hasSongs, 'username' => $username]);
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
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if ($playlist == null) {
            return redirect()->route('home')->with('errors', ['Playlist not found.']);
        }
        return response()->view('playlist.edit', ['playlist' => $playlist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $idValidator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:playlists,id'
        ]);
        if ($idValidator->fails()) {
            return redirect()->route('home')->with('errors', ['Not a valid playlist id.']);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['bail', 'required', 'max:255', new NamePattern()],
            'description' => [new DescriptionPattern()],
            'color' => ['bail', 'required', new ColorPattern()],
            'public' => ['bail', 'required', new BooleanRule()],
            'addSelected' => ['bail', 'required', new BooleanRule()]
        ]);

        if ($validator->fails()) {
            return redirect()->route('playlist.edit', $request->input('id'))->with('playlist', $request->all())->withErrors($validator, 'errors');
        } else {
            $playlist = Playlist::where('id', $request->input('id'))->where('user_id', Auth::user()->id)->first();
            if ($playlist == null) {
                return redirect()->route('home')->with('errors', ['Playlist not found.']);
            }
            if ($request->description === null) {
                $request->description = '';
            }
            $playlist->name = $request->name;
            $playlist->description = $request->description;
            $playlist->color = $request->color;
            $playlist->public = $request->public;
            $playlist->save();
            return redirect()->route('playlist.show', $request->input('id'));
        }
    }

    public function destroy(Request $request)
    {
        $idValidator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:playlists,id'
        ]);
        if ($idValidator->fails()) {
            return redirect()->route('home')->with('errors', ['Not a valid playlist id.']);
        }
        //destroy playlist if exists and is owned by user
        $playlist = Playlist::where('id', $request->input('id'))->where('user_id', Auth::user()->id)->first();
        if ($playlist == null) {
            return redirect()->back()->with('error', ['Playlist not found.']);
        }
        //detach all songs from playlist
        $playlist->songs()->detach();
        $playlist->delete();
        return redirect()->route('home');
    }
}
