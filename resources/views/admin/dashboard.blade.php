@extends('layouts.app')
@section('content')

<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Admin Dashboard</h2>
        </div>
    </div>
    
    <!-- Categories Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Categories</h5>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus"></i> Add Category
                    </a>
                </div>
                <div class="card-body">
                    @if(count($categories) > 0)
                        <div class="list-group">
                            @foreach($categories as $category)
                                <div class="list-group-item p-0 mb-2 border rounded">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light">
                                        <h6 class="mb-0 fw-bold">{{ $category->name }}</h6>
                                        <div>
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary me-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-info ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#subcategories{{ $category->id }}">
                                                <i class="fas fa-chevron-down"></i> Show Subcategories
                                            </button>
                                        </div>
                                    </div>
                                    <div class="collapse" id="subcategories{{ $category->id }}">
                                        <div class="p-3 border-top">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h6 class="mb-0">Subcategories</h6>
                                                <a href="{{ route('admin.subcategories.create') }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-plus"></i> Add Subcategory
                                                </a>
                                            </div>
                                            
                                            @if(count($category->subcategories) > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th width="200">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($category->subcategories as $subcategory)
                                                                <tr>
                                                                    <td>{{ $subcategory->name }}</td>
                                                                    <td class="text-center">
                                                                        <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-sm btn-primary me-1">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?')">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="alert alert-info mb-0">
                                                    No subcategories found.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            No categories found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Users Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Users</h5>
                </div>
                <div class="card-body">
                    @if(count($users) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.assign-categories', $user) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-tags"></i> Assign Categories
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No users found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection