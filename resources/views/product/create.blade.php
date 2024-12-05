@extends('layouts.app')

@section('title')
    Create Page
@endsection

@section('content')

    <h2 class="mb-4">Create Product</h2>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Back to Product List</a>

    <!-- Display the success message -->
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show w-75" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" id="productName" class="form-control w-75" name="name" value="{{ old('name') }}" placeholder="Enter product name" required />
            <span>{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" class="form-control w-75" rows="3" name="description" placeholder="Enter product description" required>{{ old('description') }}</textarea>
            <span>{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" class="form-control w-25" name="price" value="{{ old('price') }}" placeholder="Enter price" step="0.01" required />
            <span>{{ $errors->has('price') ? $errors->first('price', 'please enter product price') : '' }}</span>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" id="image" name="image" class="form-control w-25" />
            <span>{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-primary">Create Product</button>
        <button type="reset" class="btn btn-danger">Cancel</button>
    </form>

@endsection
