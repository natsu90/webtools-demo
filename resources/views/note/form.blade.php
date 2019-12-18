@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if (isset($note))
                        Edit Note
                    @else
                        New Note
                    @endif

                    <a href="{{ url('/patients', $patient->id) }}">View Notes</a>
                </div>

                <div class="card-body">
                    @error('description')
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                    @if (isset($note))
                    {{ Form::model($note, ['url' => url('/notes', $note->id), 'class' => 'form']) }}
                    @else
                    {{ Form::open(['url' => '/patients/' .$patient->id .'/note', 'class' => 'form']) }}
                    @endif

                    {{ Form::label('description', 'Description') }}
                    {{ Form::textarea('description') }}

                    {{ Form::submit('Save') }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
