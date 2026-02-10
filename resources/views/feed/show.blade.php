@extends('layouts.app')

@section('title', $tender->title)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Tender Card --}}
            @include('feed.components.tender-card', [
                'tender' => $tender,
                'single' => true
            ])

        </div>
    </div>
</div>
@endsection

@section('scripts')
@auth('customer')
<script>
document.addEventListener('click', function(e) {
    // Handle Like button
    if (e.target.classList.contains('like-btn')) {
        const button = e.target;
        const tenderId = button.dataset.id;

        axios.post(`/customer/feed/${tenderId}/like`)
            .then(res => {
                if(res.data.success){
                    const likesSpan = button.closest('.card-body')
                        .querySelector('span:nth-child(2)');
                    if(likesSpan) likesSpan.textContent = `👍 ${res.data.likes_count} likes`;
                }
            });
    }
});
</script>
@endauth

<script>
document.addEventListener('DOMContentLoaded', () => {
    const feedContainer = document.getElementById('feed');

    // Real-time updates for this tender
    window.Echo.channel('tender-feed')
        .listen('TenderApproved', (event) => {
            if(event.tender.id === {{ $tender->id }}) {
                // Update single tender stats dynamically
                const cardBody = document.querySelector('.card-body');
                if(cardBody){
                    const likesSpan = cardBody.querySelector('span:nth-child(2)');
                    const viewsSpan = cardBody.querySelector('span:nth-child(1)');
                    if(likesSpan) likesSpan.textContent = `👍 ${event.tender.likes_count} likes`;
                    if(viewsSpan) viewsSpan.textContent = `👁 ${event.tender.views_count} views`;
                }
            }
        });
});
</script>
@endsection