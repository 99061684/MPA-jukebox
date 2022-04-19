@extends('layouts.app')

@section('content')
<div class="container">
    <p>
        <a href="{{ route('genre.index') }}">Genres</a>
    </p>
</div>

<?php
    // $spotify = new SpotifyWebAPI\SpotifyWebAPI();
    // $playlists = $spotify->getUserPlaylists(Session::get('spotify_user_id'));
    $playlists = [];
?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Playlists</h3>
        </div>
        <div class="panel-body">
            {{-- link playlist create page --}}
            <a href="{{ route('playlist.create') }}" class="btn btn-primary">Create playlist</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Public</th>
                        <th>Tracks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($playlists as $playlist)
                        <tr>
                            <th class="clickable" onclick="window.location='{{ route('playlist.show', $playlist->id) }}'" scope="row">{{$i++}}</th>
                            <td class="clickable" onclick="window.location='{{ route('playlist.show', $playlist->id) }}'">{{ $playlist->name }}</td>
                            <td class="clickable" onclick="window.location='{{ route('playlist.show', $playlist->id) }}'">{{ $playlist->description }}</td>
                            <td class="clickable" onclick="window.location='{{ route('playlist.show', $playlist->id) }}'">{{ $playlist->public ? 'Yes' : 'No' }}</td>
                            <td class="clickable" onclick="window.location='{{ route('playlist.show', $playlist->id) }}'">{{ $playlist->tracks->total }}</td>
                        </tr>
                    @endforeach
                    @if (Count($playlists) == 0)
                    <tr>
                        <td colspan="8">No playlists found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection