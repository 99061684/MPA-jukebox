<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Session::has('spotify_client_id') && !Session::has('spotify_client_secret')) {
            // put session spotify keys in session
        }
        $playlists = Playlist::where('user_id', Auth::id())->get();
        return view('home', [
            'playlists' => $playlists
        ]);
    }
}
