@extends('layouts.app')

@section('content')
<?php
$spotify_client_id = Session::get('spotify_client_id');
$spotify_client_secret = Session::get('spotify_client_secret');
?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $song->name }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Artist</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $song->artist }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Genre</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $song->genre->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Album</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $song->album }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Year</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $song->year }}</p>
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
                                <p>{{ $song->duration }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Rating</h3>
                            </div>
                            <div class="panel-body">
                                <p>{{ $song->rating }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <iframe id="Songplayer" style="border-radius:12px" src="{{ $song->song_path }}" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
    </div>
</div>
@endsection