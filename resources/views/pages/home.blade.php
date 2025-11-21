@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto text-center">
        <h1 class="display-4">Welcome to Laravel App</h1>
        <p class="lead">This is the home page of your Laravel application.</p>
        
        <!-- Jika user belum login -->
        @guest
            <div class="mt-4">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Login</a>
            </div>
        <!-- Jika user sudah login -->
        @else
            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">Go to Dashboard</a>
            </div>
        @endguest
    </div>
</div>
@endsection