@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Profile</h5>
            </div>
            <div class="card-body text-center">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="profile-image mb-3">
                @else
                    <img src="https://via.placeholder.com/150?text=No+Photo" alt="No Photo" class="profile-image mb-3">
                @endif
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <a href="{{ route('profile.update') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Update Profile
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">My Categories</h5>
            </div>
            <div class="card-body">
                @if(count($userCategorySubcategories) > 0)
                    <div class="accordion" id="categoriesAccordion">
                        @php
                            $groupedCategories = $userCategorySubcategories->groupBy(function($item) {
                                return $item->category->name;
                            });
                        @endphp
                        
                        @foreach($groupedCategories as $categoryName => $items)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $loop->index }}">
                                        {{ $categoryName }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#categoriesAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            @foreach($items as $item)
                                                <li class="list-group-item">{{ $item->subcategory->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        You don't have any categories assigned yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection