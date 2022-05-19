@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit playlist</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('playlist.update') }}" method="POST">
                    @csrf
                    @if(isset($playlist) && !isset($inputdata))
                        <input type="hidden" name="id" value="{{ $playlist->id }}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ $playlist->name }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{$playlist->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="public">Public</label>
                            <input type="hidden" name="public" value="0">
                            <input type="checkbox" value="1" id="public" name="public" {{ $playlist->public ? 'checked' : '' }}>
                        </div>
                    @elseif (isset($inputdata))
                        <input type="hidden" name="id" value="{{ $inputdata->id }}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ $inputdata->name }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{$inputdata->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="public">Public</label>
                            <input type="hidden" name="public" value="0">
                            <input type="checkbox" value="1" id="public" name="public" {{ $inputdata->public ? 'checked' : '' }}>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
