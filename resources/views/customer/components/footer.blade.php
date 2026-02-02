{{--
|--------------------------------------------------------------------------
| Customer Footer
|--------------------------------------------------------------------------
| - Minimal and neutral
| - Consistent spacing
| - Automatically updates year
|--------------------------------------------------------------------------
--}}

<footer class="bg-white border-top mt-auto">
    <div class="container py-4">
        <div class="row align-items-center">

            {{-- Left: Copyright --}}
            <div class="col-md-6 text-center text-md-start text-muted small">
                &copy; {{ date('Y') }} <span class="fw-medium">Bidsphere</span>.
                All rights reserved.
            </div>

            {{-- Right: Optional links --}}
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <a href="#" class="text-muted small me-3">Privacy</a>
                <a href="#" class="text-muted small">Terms</a>
            </div>

        </div>
    </div>
</footer>
