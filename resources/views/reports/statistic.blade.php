@extends('layouts.app')

@section('title', 'Statistics')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Detailed Statistics</h1>
        </div>
    </div>

    <!-- Family Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Family Statistics</h6>
                </div>
                <div class="card-body">
                    <p>Total: <strong>{{ $stats['families']['total'] }}</strong></p>
                    <p>Active: <strong>{{ $stats['families']['active'] }}</strong></p>
                    <p>Inactive: <strong>{{ $stats['families']['inactive'] }}</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">Member Statistics</h6>
                </div>
                <div class="card-body">
                    <p>Total: <strong>{{ $stats['members']['total'] }}</strong></p>
                    <p>Active: <strong>{{ $stats['members']['active'] }}</strong></p>
                    <p>Inactive: <strong>{{ $stats['members']['inactive'] }}</strong></p>
                    <p>Male: <strong>{{ $stats['members']['male'] }}</strong></p>
                    <p>Female: <strong>{{ $stats['members']['female'] }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection