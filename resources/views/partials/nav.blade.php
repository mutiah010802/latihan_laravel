<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Laravel App</a>
        
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
            
            <!-- Jika user sudah login -->
            @auth
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link" href="#">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">Logout</button>
                </form>
            <!-- Jika user belum login -->
            @else
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>