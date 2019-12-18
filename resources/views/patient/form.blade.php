@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if (isset($patient))
                        Edit Patient {{ $patient->name }}
                    @else
                        New Patient
                    @endif

                    <a href="/patients">View Patients</a>
                </div>

                <div class="card-body">
                    @error('name')
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                    @if (isset($patient))
                    {{ Form::model($patient, ['url' => url('/patients', $patient->id), 'class' => 'form']) }}
                    @else
                    {{ Form::open(['url' => '/patient', 'class' => 'form']) }}
                    @endif

                    {{ Form::label('name', 'Patient Name') }}
                    {{ Form::text('name') }}

                    {{ Form::submit('Save') }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
