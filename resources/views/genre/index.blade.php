@extends('layouts.app')

@section('content')
<div class="container">
    <h1>JukeBox</h1>
    @foreach ($genres as $key => $genre)
    <div class="card" style="width: 18rem; display:inline-block;">
        @if ($genre->image_path !== null && $genre->image_path !== '')
        <img class="card-img-top" src="{{$genre->image_path}}" alt="image genre">
        @endif
        <div class="card-body">
          <h5 class="card-title">{{ $genre->name }}</h5>
          <p class="card-text">{{ $genre->description }}</p>
        </div>
        <div class="card-body">
          <a href="{{ route('song.overview', $genre->id) }}" class="card-link">Songs with genre</a>
        </div>
    </div>
    @endforeach

</div>
@endsection
