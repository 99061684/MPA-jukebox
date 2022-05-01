@extends('layouts.app')

@section('content')
<?php
use App\Models\SongSession;
?>
<div class="container">
    <h1>Selected songs</h1>
    <table class="table table-bordered table-responsive">
        <caption>List of selected songs</caption>
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
            <th scope="col">selected</th>
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
                <td><button class="playbuttonSong" data-song-url="{{$song->song_path}}">play</button></td>
                <td><form action="{{ route('song.selectSong') }}" method="POST">
                    @csrf
                    <input type="checkbox" name="songid" value="{{$song->id}}" {{ SongSession::checkSong($song->id) ? 'checked' : '' }} onclick="event.preventDefault(); this.form.submit();">
                </form></td>
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

        </tbody>
      </table>

    <iframe id="Songplayer" style="border-radius:12px" src="https://open.spotify.com/embed/track/3XVozq1aeqsJwpXrEZrDJ9?utm_source=generator" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
</div>
@endsection
