@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Assign Categories to {{ $user->name }}</h5>
                    <a href="{{ route('admin.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.assign-categories', $user) }}" method="POST">
                        @csrf
                        
                        @if($categories->isEmpty())
                            <div class="alert alert-info">
                                No categories available. Please create categories and subcategories first.
                            </div>
                        @else
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input category-checkbox" 
                                                        id="category-{{ $category->id }}" 
                                                        name="categories[]" 
                                                        value="{{ $category->id }}"
                                                        data-category-id="{{ $category->id }}"
                                                        {{ isset($userCategories[$category->id]) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="category-{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="card-body">
                                                @if($category->subcategories->isEmpty())
                                                    <p class="text-muted">No subcategories available.</p>
                                                @else
                                                    <div class="subcategory-list" id="subcategory-list-{{ $category->id }}">
                                                        @foreach($category->subcategories as $subcategory)
                                                            <div class="form-check mb-2">
                                                                <input type="checkbox" 
                                                                    class="form-check-input subcategory-checkbox" 
                                                                    id="subcategory-{{ $subcategory->id }}" 
                                                                    name="subcategories[{{ $category->id }}][]" 
                                                                    value="{{ $subcategory->id }}"
                                                                    data-category-id="{{ $category->id }}"
                                                                    {{ isset($userCategories[$category->id]) && in_array($subcategory->id, $userCategories[$category->id]) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="subcategory-{{ $subcategory->id }}">
                                                                    {{ $subcategory->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Save Assignments</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update subcategory checkboxes
        function updateSubcategoryCheckboxes(categoryId, isChecked) {
            const subcategoryCheckboxes = document.querySelectorAll(`.subcategory-checkbox[data-category-id="${categoryId}"]`);
            
            subcategoryCheckboxes.forEach(function(subcategoryCheckbox) {
                subcategoryCheckbox.disabled = !isChecked;
                
                // If unchecking parent, uncheck children
                if (!isChecked) {
                    subcategoryCheckbox.checked = false;
                }
            });
        }

        // Set initial state for all subcategory checkboxes
        document.querySelectorAll('.category-checkbox').forEach(function(checkbox) {
            const categoryId = checkbox.dataset.categoryId;
            updateSubcategoryCheckboxes(categoryId, checkbox.checked);
        });

        // Handle category checkbox changes
        document.querySelectorAll('.category-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const categoryId = this.dataset.categoryId;
                updateSubcategoryCheckboxes(categoryId, this.checked);
            });
        });

        // Make sure subcategory checkboxes are clickable
        document.querySelectorAll('.subcategory-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('click', function(event) {
                // Prevent the default if disabled
                if (this.disabled) {
                    event.preventDefault();
                }
            });
        });
    });
</script>
@endpush
@endsection