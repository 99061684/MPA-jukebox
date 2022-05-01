@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create playlist</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('playlist.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="255" @if (Session::has('inputData')) value="{{ Session::get('inputData')['name'] }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">@if (Session::has('inputData')) {{ Session::get('inputData')['description'] }} @endif</textarea>
                    </div>
                    <div class="form-group">
                        <label for="public">Public</label>
                        <input type="hidden" name="public" value="0">
                        <input type="checkbox" value="1" id="public" name="public" @if (Session::has('inputData')) {{ Session::get('inputData')['public'] ? 'checked' : '' }} @endif>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
