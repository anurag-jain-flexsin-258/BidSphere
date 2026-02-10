@extends('layouts.app')

@section('title', 'Tender Feed')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <div class="mySwiper swiper">
            {{-- ===============================
            Slider Container
            ================================ --}}
            <div id="feed" class="swiper-wrapper">
                @foreach($tenders as $tender)
                    <div class="swiper-slide">
                        @include('feed.components.tender-card', ['tender' => $tender])
                    </div>
                @endforeach
            </div>

            {{-- Swiper Navigation --}}
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>


        {{-- Optional message when no tenders --}}
        @if($tenders->isEmpty())
            <div class="text-center text-gray-500 mt-10">
                No tenders available at the moment.
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const feedSlider = document.getElementById('feed');

            // ===============================
            // Slider Navigation Buttons
            // ===============================
            const prevBtn = document.getElementById('prev');
            const nextBtn = document.getElementById('next');

            const scrollAmount = 340; // px per click, adjust as needed

            prevBtn.addEventListener('click', () => {
                feedSlider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });

            nextBtn.addEventListener('click', () => {
                feedSlider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });

            // ===============================
            // Real-time Updates via Laravel Echo
            // ===============================
            if (window.Echo) {
                window.Echo.channel('tender-feed')
                    .listen('TenderApproved', (event) => {
                        const html = `
                            <div class="flex-none w-1/2 md:w-1/3 lg:w-1/4 snap-start">
                                ${renderTenderCard(event.tender)}
                            </div>`;
                        feedSlider.insertAdjacentHTML('afterbegin', html);
                    });
            }

            // ===============================
            // Render Tender Card dynamically
            // ===============================
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
                    </div>`;
            }

        });
    </script>
@endsection