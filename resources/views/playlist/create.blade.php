@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create playlist</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('playlist.store') }}" method="POST">
                    @csrf
                    <div class="form-group has-validation">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @if (isset($ValidationErrors['name']) && count($ValidationErrors['name']) > 0) is-invalid @endif" id="name" name="name" aria-describedby="nameFeedback" required maxlength="255" @if (isset($inputData['name']) && $inputData['name'] !== null) value="{{ $inputData['name'] }}" @endif>
                        <div id="nameFeedback" class="invalid-feedback">
                            @if (isset($ValidationErrors['name']) && $ValidationErrors['name'] !== null)
                                {{ $ValidationErrors['name'][0] }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @if (isset($ValidationErrors['description']) && count($ValidationErrors['description']) > 0) is-invalid @endif" id="description" name="description" aria-describedby="descriptionFeedback" rows="3">@if (isset($inputData['description']) && $inputData['description'] !== null){{ $inputData['description'] }}@endif</textarea>
                        <div id="descriptionFeedback" class="invalid-feedback">
                            @if (isset($ValidationErrors['description']) && $ValidationErrors['description'] !== null)
                                {{ $ValidationErrors['description'][0] }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="color" class="form-control @if (isset($ValidationErrors['color']) && count($ValidationErrors['color']) > 0) is-invalid @endif" id="color" aria-describedby="colorFeedback" required name="color" @if (isset($inputData['color']) && $inputData['color'] !== null) value="{{ $inputData['color'] }}" @else value="#9acd32" @endif>
                        <div id="colorFeedback" class="invalid-feedback">
                            @if (isset($ValidationErrors['color']) && $ValidationErrors['color'] !== null)
                                {{ $ValidationErrors['color'][0] }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="public">Public</label>
                        <input type="hidden" name="public" value="0">
                        <input type="checkbox" class="@if (isset($ValidationErrors['public']) && count($ValidationErrors['public']) > 0) is-invalid @endif" value="1" id="public" aria-describedby="publicFeedback" name="public" @if (isset($inputData['public']) && $inputData['public'] !== null) {{ $inputData['public'] ? 'checked' : '' }} @endif>
                        <div id="publicFeedback" class="invalid-feedback">
                            @if (isset($ValidationErrors['public']) && $ValidationErrors['public'] !== null)
                                {{ $ValidationErrors['public'][0] }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addSelected">Add all selected songs to playlist</label>
                        <input type="hidden" name="addSelected" value="0">
                        <input type="checkbox" class="@if (isset($ValidationErrors['addSelected']) && count($ValidationErrors['addSelected']) > 0) is-invalid @endif" value="1" aria-describedby="addSelectedFeedback" name="addSelected" {{ $hasSongs ? '' : 'disabled' }}>
                        <div id="addSelectedFeedback" class="invalid-feedback">
                            @if (isset($ValidationErrors['addSelected']) && $ValidationErrors['addSelected'] !== null)
                                {{ $ValidationErrors['addSelected'][0] }}
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
