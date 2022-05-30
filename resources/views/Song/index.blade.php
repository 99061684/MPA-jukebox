@extends('layouts.app')

@section('content')
<?php
use App\Models\SongSession;
?>
<div class="container">
    <h1>Songs</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('song.sortandsearch') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="genreid">Genre</label>
                            <select class="form-control" id="genreid" name="genreid">
                                <option value="">All genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ $genreid == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sort</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('song.sortandsearch') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="sort">Sort</label>
                            <select class="form-control" id="sort" name="sort">
                                <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="artist" {{ $sort == 'artist' ? 'selected' : '' }}>Artist</option>
                                <option value="genre" {{ $sort == 'genre' ? 'selected' : '' }}>Genre</option>
                                <option value="year" {{ $sort == 'year' ? 'selected' : '' }}>Year</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="order">Order</label>
                            <select class="form-control" id="order" name="order">
                                <option value="asc" {{ $order == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ $order == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-primary">Sort</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive">
        <caption>List of songs</caption>
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Artist</th>
            <th scope="col">Band</th>
            <th scope="col">Album</th>
            <th scope="col">Genre</th>
            <th scope="col">Length</th>
            <th scope="col">play</th>
            <th scope="col">selected</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($songs as $key => $song)
            <tr>
                <th class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'" scope="row">{{ ($songs->currentPage() - 1)  * $songs->links()->paginator->perPage() + ($key + 1) }}</th>
                <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->name}}</td>
                <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->artist}}</td>
                <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->band}}</td>
                <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->album}}</td>
                <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->getGenreNamesString()}}</td>
                <td class="clickable" onclick="window.location='{{ route('song.show', $song->id) }}'">{{$song->duration}}</td>
                <td><button class="playbuttonSong" data-song-url="{{$song->song_path}}">play</button></td>
                <td><form action="{{ route('song.selectSong') }}" method="POST">
                    @csrf
                    <input type="checkbox" name="songid" value="{{$song->id}}" {{ SongSession::checkSong($song->id) ? 'checked' : '' }} onclick="event.preventDefault(); this.form.submit();">
                </form></td>
            </tr>
            @endforeach
            @if (Count($songs) == 0)
            <tr>
                <td colspan="9">No songs found</td>
            </tr>
            @elseif ($songs->hasPages())
            <tr>
                <td colspan="9">{{ $songs->links() }}</td>
            </tr>
            @endif
        </tbody>
      </table>

    <iframe id="Songplayer" style="border-radius:12px" src="https://open.spotify.com/embed/track/3XVozq1aeqsJwpXrEZrDJ9?utm_source=generator" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
</div>
@endsection
