<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Song;

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
            'public' => 'required'
        ]);

        //if $request->songs is not empty, then add songs to playlist
        if (!empty($request->songs)) {
            $validator->after(function ($validator) use ($request) {
                $playlist = new Playlist();
                $playlist->name = $request->name;
                $playlist->description = $request->description;
                $playlist->public = $request->public;
                $playlist->user_id = Auth::user()->id;
                $playlist->save();
                $playlist->songs()->attach($request->songs);
            });
        }

        if (!$validator->fails()) {
            $playlist = new Playlist();
            $playlist->name = $request->name;
            $playlist->description = $request->description;
            $playlist->public = $request->public;
            $playlist->user_id = Auth::user()->id;
            $playlist->save();
            return view("home");
        } else {
            return Redirect::route('playlist.create')->with('inputData', $request->all())->withErrors($validator);
        }
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
        $songs = Song::all();
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if ($playlist != null) {
            return view('playlist.show', ['playlist' => $playlist, 'songs' => $songs]);
            // return view('playlist.test', ['playlist' => $playlist, 'songs' => $songs]);
        } else {
            return view('home', ['errors' => ['Playlist not found']]);
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
