@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Patients <a href="/patient/new" class="pull-right btn">Add New</a></div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr><th>Patient Name</th></tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)

                            <tr><td><a href="{{ url('/patients', $patient->id) }}">{{ $patient->name }}</a></td></tr>

                            @empty
                            
                            <tr><td>No data</td></tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
