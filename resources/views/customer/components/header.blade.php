{{--
|--------------------------------------------------------------------------
| Customer Header / Navigation Bar
|--------------------------------------------------------------------------
| - Clean, minimal, responsive
| - Bootstrap handles layout & collapse
| - Tailwind used only for fine UI polish
| - Auth-safe (customer guard)
|--------------------------------------------------------------------------
--}}

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand fw-semibold text-slate-800" href="{{ url('/') }}">
            Bidsphere
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#customerNavbar" aria-controls="customerNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navigation --}}
        <div class="collapse navbar-collapse" id="customerNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                @auth('customer')
                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('customer.dashboard') ? 'text-primary' : '' }}"
                           href="{{ route('customer.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    {{-- Tenders --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('customer.tenders.*') ? 'text-primary' : '' }}"
                           href="{{ route('customer.tenders.index') }}">
                            My Tenders
                        </a>
                    </li>

                    {{-- Logout --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-danger btn-sm px-3">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    {{-- Login / Register --}}
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-4"
                           href="{{ route('customer.login') }}">
                            Login / Register
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
