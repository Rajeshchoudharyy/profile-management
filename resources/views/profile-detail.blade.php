@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profile Details</h5>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="profile-image mb-3">
                            @else
                                <div class="profile-image d-flex justify-content-center align-items-center bg-secondary text-white mb-3 mx-auto">
                                    <span class="fs-1">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $user->name }}</h3>
                            <hr>
                            
                            <h5 class="mt-4 mb-3">Categories & Interests</h5>
                            @if($userCategorySubcategories->isEmpty())
                                <p class="text-muted">No categories assigned yet.</p>
                            @else
                                @php
                                    $groupedCategories = $userCategorySubcategories->groupBy(function($item) {
                                        return $item->category->name;
                                    });
                                @endphp
                                
                                @foreach($groupedCategories as $categoryName => $items)
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <strong>{{ $categoryName }}</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($items as $item)
                                                    <span class="badge bg-primary">{{ $item->subcategory->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection