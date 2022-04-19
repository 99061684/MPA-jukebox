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
            Session::put('spotify_client_id', '4bd586a7c9f7467589c32dbbe245e1fe');
            Session::put('spotify_client_secret', '762c964d8e2b4b1db351f4785f440b87');
        }
        $Playlists = Playlist::where('user_id', Auth::id())->get();
        return view('home', [
            'Playlists' => $Playlists,
        ]);
    }
}
