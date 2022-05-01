@extends('layouts.app')

@section('content')
<?php
$spotify_client_id = Session::get('spotify_client_id');
$spotify_client_secret = Session::get('spotify_client_secret');
?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $playlist->name }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">description</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Artist</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->artist }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Genre</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->genre->name }}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Album</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->album }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Year</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Songs</h3>
                            </div>
                            <div class="panel-body">
                                {{ $songs = $playlist->songs->sortBy('track_number')->sortBy('title')->paginate(15) }}
                                @foreach ($songs as $key => $song)
                                <tr>
                                    <th class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'" scope="row">{{ ($songs->currentPage() - 1)  * $songs->links()->paginator->perPage() + ($key + 1) }}</th>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->name}}</td>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->genre->name}}</td>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->artist}}</td>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->band}}</td>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->album}}</td>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->duration}}</td>
                                    <td><button class="playbuttonSong" data-song-url="{{$song->song_path}}">play</button></td>
                                    {{-- toevoegen aan gekozen playlists --}}
                                    {{-- <td>
                                        <form action="{{ route('song.addtoplaylist') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="songid" value="{{$song->id}}">
                                            <select class="form-control" name="playlistid">
                                                @foreach ($playlists as $playlist)
                                                    <option value="{{$playlist->id}}">{{$playlist->name}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary">Add to playlist</button>
                                        </form>
                                    </td> --}}
                                </tr>
                                @endforeach
                                @if (Count($songs) == 0)
                                <tr>
                                    <td colspan="8">No songs found</td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="8">{{ $songs->links() }}</td>
                                </tr>
                                @endif
                                <ul>
                                    @foreach($playlist->songs as $song)
                                        <li>{{ $song->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Length</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->getTotalDuration() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <form action="{{ route('song.addtoplaylist') }}" method="POST">
                        @csrf
                        <label for="songDatalistInput" class="form-label">Datalist example</label>
                        <input type="hidden" name="SelectedSongs" id="SelectedSongs" value="">
                        <input type="text" class="form-control" list="songDatalist" name="songDatalistInput" id="songDatalistInput" size="20" autocomplete="off" placeholder="Type to search...">
                        <datalist id="songDatalist">
                            @foreach ($songs as $song)
                                <option id="songOption{{ $song->id }}" value="{{ $song->name }}"></option>
                            @endforeach
                        </datalist>
                        <select class="select" multiple data-mdb-filter="true" data-mdb-clear-button="true">
                            @foreach ($songs as $song)
                                <option value="{{ $song->id }}">{{ $song->name }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" name="playlistid">

                        </select>
                        <button type="submit" class="btn btn-primary">Add to playlist</button>
                    </form> --}}

                    {{-- <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Spotify</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <a href="{{ $playlist->spotify_url }}" target="_blank">
                                        {{ $playlist->spotify_url }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Spotify Client ID</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $spotify_client_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Spotify Client Secret</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $spotify_client_secret }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Spotify Token</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->spotify_token }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Spotify Refresh Token</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->spotify_refresh_token }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Spotify Token Expiration</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $playlist->spotify_token_expiration }}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        {{-- <iframe id="Songplayer" style="border-radius:12px" src="{{ $song->song_path }}" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe> --}}
    </div>
</div>
@endsection
