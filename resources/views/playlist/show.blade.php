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
                                <table class="table table-bordered table-responsive">
                                    <caption>List of playlist songs</caption>
                                    <thead class="thead-dark">
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Genre</th>
                                        <th scope="col">Artist</th>
                                        <th scope="col">Band</th>
                                        <th scope="col">Album</th>
                                        <th scope="col">Length</th>
                                        <th scope="col">play</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($songs as $key => $song)
                                        <tr>
                                            <th class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'" scope="row">{{ ($songs->currentPage() - 1)  * $songs->links()->paginator->perPage() + ($key + 1) }}</th>
                                            <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->name}}</td>
                                            <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->genre->name}}</td>
                                            <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->artist}}</td>
                                            <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->band}}</td>
                                            <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->album}}</td>
                                            <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->duration}}</td>
                                            <td><form action="{{ route('playlist.removeSongs') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="playlistid" value="{{ $playlist->id }}">
                                                <input type="hidden" name="songid" value="{{ $song->id }}">
                                                <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); this.form.submit();">delete</button>
                                            </form></td>
                                        </tr>
                                        @endforeach
                                        @if (Count($songs) == 0)
                                        <tr>
                                            <td colspan="8">No songs found</td>
                                        </tr>
                                        @elseif ($songs->hasPages())
                                        <tr>
                                            <td colspan="8">{{ $songs->links() }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>


                            <div class="panel-footer">
                                <form action="{{ route('playlist.addSongs', $playlist->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="playlistid" value="{{ $playlist->id }}">
                                    <button type="submit" class="btn btn-primary" {{ $hasSongs ? '' : 'disabled' }}>Add selected songs to playlist</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
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

        {{-- foreach song get url combined in array --}}
        {{-- <script defer>
            var songs = [];
            @foreach ($songs as $key => $song)
                songs['{{ $key }}'] = '{{ $song->song_path }}';
            @endforeach

            window.onload = function() {
                playplaylist(songs);
            }
        </script> --}}

        {{-- <iframe id="Songplayer" style="border-radius:12px" src="{{ $songs->first()->song_path }}" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe> --}}
    </div>
</div>
@endsection
