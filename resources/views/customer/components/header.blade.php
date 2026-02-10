{{--
|--------------------------------------------------------------------------
| Customer Header / Navigation Bar
|--------------------------------------------------------------------------
| - Clean, responsive, minimal
| - Brand/logo left
| - Rightmost round profile icon
| - Dropdown: Dashboard / My Tenders / Profile / Logout
|--------------------------------------------------------------------------
--}}

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">

        {{-- Brand / Logo --}}
        <a class="navbar-brand fw-bold text-dark" href="{{ route('customer.dashboard') }}">
            Bidsphere
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#customerNavbar"
                aria-controls="customerNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Right Side --}}
        <div class="collapse navbar-collapse" id="customerNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                @auth('customer')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#"
                           id="profileDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            {{-- Round Profile Image --}}
                            @php
                                $customer = Auth::guard('customer')->user();
                            @endphp

                            <img
                                src="{{ $customer->image ? asset($customer->image) : 'https://via.placeholder.com/40' }}"
                                alt="Profile"
                                class="rounded-circle border"
                                width="40"
                                height="40"
                                style="object-fit: cover;"
                            >
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                            aria-labelledby="profileDropdown">

                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('customer.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('customer.tenders.index') }}">
                                    My Tenders
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('customer.profile.edit') }}">
                                    Profile
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST"
                                      action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </li>
                @else
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