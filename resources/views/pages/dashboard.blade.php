@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <h1>Dashboard</h1>
        <div class="alert alert-success">
            Welcome to your dashboard, <strong>{{ Auth::user()->name }}</strong>!
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">User Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Registered:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection