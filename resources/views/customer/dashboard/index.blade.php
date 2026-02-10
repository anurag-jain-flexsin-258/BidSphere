{{--
|--------------------------------------------------------------------------
| Customer Dashboard
|--------------------------------------------------------------------------
| - Minimal placeholder dashboard
| - Shows profile completion status
|--------------------------------------------------------------------------
--}}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success small">
                    {{ session('success') }}
                </div>
            @endif

            <div class="app-card p-5 text-center shadow-sm">

                <h3 class="fw-bold mb-3">
                    Welcome, {{ $customer->name ?? 'User' }} 👋
                </h3>

                {{-- Profile Incomplete Warning --}}
                @if(!$customer->profile_completed)
                    <div class="alert alert-warning mt-3">
                        Your profile is incomplete. Please complete it to continue.
                    </div>

                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-warning mt-2">
                        Complete Profile
                    </a>
                @endif

            </div>

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

                    <div class="swiper-pagination"></div>
                </div>


                {{-- Optional message when no tenders --}}
                @if($tenders->isEmpty())
                    <div class="text-center text-gray-500 mt-10">
                        No tenders available at the moment.
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection