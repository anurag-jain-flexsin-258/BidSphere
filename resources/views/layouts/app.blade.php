<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Customer Portal')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <!-- Optional: Add more CSS links here -->
    @stack('styles')
</head>
<body>
    @include('customer.components.header')

    <div class="container mt-5">
        @yield('content')
    </div>

    @include('customer.components.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    @stack('scripts')
</body>
</html>
