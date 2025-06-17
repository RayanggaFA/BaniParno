@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Dashboard</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Families</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_families'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Members</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_members'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Families</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_families'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Active Members</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_members'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="row">
        <!-- Recent Families -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Families</h6>
                </div>
                <div class="card-body">
                    @if($recent_families->count() > 0)
                        @foreach($recent_families as $family)
                        <div class="d-flex align-items-center mb-2">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-home text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">{{ $family->created_at->format('M d, Y') }}</div>
                                <div class="font-weight-bold">{{ $family->name }}</div>
                                <div class="small">{{ $family->members->count() }} members</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No families found</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Members -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Recent Members</h6>
                </div>
                <div class="card-body">
                    @if($recent_members->count() > 0)
                        @foreach($recent_members as $member)
                        <div class="d-flex align-items-center mb-2">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">{{ $member->created_at->format('M d, Y') }}</div>
                                <div class="font-weight-bold">{{ $member->name }}</div>
                                <div class="small">{{ $member->family->name ?? 'No family' }}</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No members found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('family.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Add Family
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('member.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-user-plus"></i> Add Member
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('family.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-list"></i> View Families
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('dashboard.statistics') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-chart-bar"></i> Statistics
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection