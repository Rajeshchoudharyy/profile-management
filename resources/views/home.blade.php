@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Image Slider -->
        <div id="homeSlider" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($sliders as $key => $slider)
                    <button type="button" data-bs-target="#homeSlider" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner rounded shadow">
                @forelse($sliders as $key => $slider)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="5000">
                        <img src="{{ asset('storage/' . $slider->image) }}" class="d-block w-100" alt="Slider Image" style="height: 400px; object-fit: cover;">
                        @if($slider->title || $slider->subtitle)
                            <div class="carousel-caption d-none d-md-block">
                                @if($slider->title)
                                    <h5>{{ $slider->title }}</h5>
                                @endif
                                @if($slider->subtitle)
                                    <p>{{ $slider->subtitle }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/1200x400?text=No+Slider+Images" class="d-block w-100" alt="No Slider Images">
                    </div>
                @endforelse
            </div>
            @if(count($sliders) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#homeSlider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#homeSlider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">User Profiles</h2>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    @forelse($profiles as $profile)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($profile->photo)
                            <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name }}" class="profile-card-image">
                        @else
                            <img src="https://via.placeholder.com/150?text=No+Photo" alt="No Photo" class="profile-card-image">
                        @endif
                    </div>
                    <h5 class="card-title">{{ $profile->name }}</h5>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                No profiles available yet.
            </div>
        </div>
    @endforelse
</div>
@endsection