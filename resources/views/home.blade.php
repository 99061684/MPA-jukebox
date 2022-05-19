@extends('layouts.app')

@section('content')
<div class="container">
    <img class="full-size-image" src="{{ URL::asset('assets/images/home_music.jpg') }}" alt="home image">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Playlists</h3>
        </div>
        <div class="panel-body">
            <a href="{{ route('playlist.create') }}" class="btn btn-primary">Create playlist</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
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
                            <td class="clickable" onclick="window.location='{{ route('playlist.show', $playlist->id) }}'">{{ count($playlist->songs) }}</td>
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
