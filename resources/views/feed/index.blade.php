@extends('layouts.app')

@section('title', 'Tender Feed')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-4">Tender Feed</h2>

        <div id="feed" class="space-y-4">
            @foreach($tenders as $tender)
                @include('feed.components.tender-card', ['tender' => $tender])
            @endforeach
        </div>

        <div class="mt-6">
            <button id="load-more" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Load More
            </button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let page = 1;
            const feedContainer = document.getElementById('feed');
            const loadMoreBtn = document.getElementById('load-more');

            // Load more tenders
            loadMoreBtn.addEventListener('click', () => {
                page++;
                axios.get(`/feed?page=${page}`).then(res => {
                    res.data.data.forEach(tender => {
                        const html = renderTenderCard(tender);
                        feedContainer.insertAdjacentHTML('beforeend', html);
                    });
                });
            });

            // Real-time updates
            window.Echo.channel('tender-feed')
                .listen('TenderApproved', (event) => {
                    const html = renderTenderCard(event.tender);
                    feedContainer.insertAdjacentHTML('afterbegin', html);
                });

            // Dynamic tender card renderer
            function renderTenderCard(tender) {
                return `
                <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body">
                        <h5 class="fw-bold">
                            <a href="/feed/${tender.id}" class="text-dark text-decoration-none">
                                ${tender.title}
                            </a>
                        </h5>
                        <div class="text-muted small mb-2">
                            Posted by ${tender.customer_name} • ${tender.approved_at_human}
                        </div>
                        <p class="mb-3">${tender.description.substring(0, 200)}</p>
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span>👁 ${tender.views_count} views</span>
                            <span>👍 ${tender.likes_count} likes</span>
                            <span>Qty: ${tender.quantity}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <button class="btn btn-sm btn-outline-primary like-btn" data-id="${tender.id}">👍 Like</button>
                            <a href="/feed/${tender.id}" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            `;
            }
        });
    </script>
@endsection