{{-- 
|--------------------------------------------------------------------------
| Main Application Layout
|--------------------------------------------------------------------------
| Base layout for customer-facing frontend.
| Clean, modern, and ready for Swiper sliders.
|--------------------------------------------------------------------------
--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Bidsphere')</title>

    {{-- ===============================
        Fonts
    ================================ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- ===============================
        Framework CSS
    ================================ --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">

    {{-- ===============================
        Swiper Slider CSS
    ================================ --}}
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">

    {{-- ===============================
        Custom App CSS
    ================================ --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    {{-- Axios CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- Vite JS --}}
    @vite('resources/js/app.js')

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body class="font-inter bg-gray-50 text-gray-800">

    {{-- ===============================
        Header
    ================================ --}}
    @include('customer.components.header')

    {{-- ===============================
        Main Content
    ================================ --}}
    <main class="page-wrapper">
        <div class="container py-5">
            @yield('content')
        </div>
    </main>

    {{-- ===============================
        Footer
    ================================ --}}
    @include('customer.components.footer')

    {{-- ===============================
        Framework JS
    ================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Google Maps --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>

    {{-- ===============================
        Swiper JS
    ================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    {{-- ===============================
        Custom App JS
    ================================ --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>