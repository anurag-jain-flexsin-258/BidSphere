<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Customer Portal</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth('customer')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.login') }}">Login/Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
