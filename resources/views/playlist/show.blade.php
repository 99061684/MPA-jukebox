@extends('layouts.app')

@section('content')
<div class="body_container">
    <div class="container grid">
        <div class="detail">
            <div class="left">
                <img class="full-size-image" src="{{ URL::asset('assets/images/'.$playlist->image_path) }}" alt="{{ $playlist->name }}">

                <div class="stats" style="background-color: @if(isset($playlist->color) && $playlist->color !== null) {{$playlist->color}} @else yellowgreen @endif;">
                    <h1>{{ $playlist->name }}</h1>
                    <ul class="fa-ul">
                        <li><b>Length playlist:</b> {{ $playlist->getTotalDuration() }}</li>
                        <li><b>Created by:</b> {{ $username }}</li>
                    </ul>
                    @if(Auth::user()->id == $playlist->user_id)
                    <div class="playlist-show-button-div">
                        <a href="{{ route('playlist.edit', $playlist->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('playlist.destroy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $playlist->id }}">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            <div class="right">
                <p>
                    {{ nl2br($playlist->description, false) }}
                </p>

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
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($songs as $key => $song)
                                <tr>
                                    <th class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'" scope="row">{{ ($songs->currentPage() - 1)  * $songs->links()->paginator->perPage() + ($key + 1) }}</th>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->name}}</td>
                                    <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->getGenreNamesString()}}</td>
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
    </div>
</div>
@endsection
