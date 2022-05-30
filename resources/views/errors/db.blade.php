@extends('layouts.app')

@section('content')
<div class="container">
    <img class="full-size-image" src="{{ URL::asset('assets/images/home_music.jpg') }}" alt="home image">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">DB Connection error</h3>
        </div>
        <div class="panel-body">
            <p style="color:red;">
                <b>
                    The database connection failed. Please check your database settings. <br><br>
                    {{-- if $errors is array --}}
                    @if(is_array($errors))
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @else
                        Error: {{ $errors->getMessage() }}
                    @endif
                </b>
            </p>
        </div>
    </div>
</div>
@endsection
