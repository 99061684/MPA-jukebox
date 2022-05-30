<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Playlist;

class OwnsPlaylist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $playlist = Playlist::find($request->route('id'));
        if ($playlist === null || $playlist->user_id != Auth::id()) {
            return redirect()->route('home')->with('errors', ['You do not own this playlist.']);
        }
        return $next($request);
    }
}
