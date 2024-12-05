@extends('layouts.app')

@section('title')
    Edit Page
@endsection

@section('content')

    <h2 class="mb-4">Edit Product</h2>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Back to Product List</a>

    <!-- Display the success message -->
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show w-75" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Product ID -->
        <div class="mb-3">
            <label for="productId" class="form-label">Product ID</label>
            <input type="text" id="productId" class="form-control w-75" name="id" value="{{ $product->id }}" readonly />
        </div>

        <!-- Product Name -->
        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" id="productName" class="form-control w-75" name="name" value="{{ $product->name }}" required />
            <span>{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" class="form-control w-75" name="description" rows="3" required>{{ $product->description }}</textarea>
            <span>{{ $errors->has('name') ? $errors->first('description') : '' }}</span>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" class="form-control w-25" name="price" value="{{ $product->price }}"
                step="0.01" required />
            <span>{{ $errors->has('name') ? $errors->first('price') : '' }}</span>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <!-- Existing image -->
            <div class="mb-3">
                <img src="{{ asset($product->image) }}" alt="Current Product Image" class="img-thumbnail mb-3" style="max-width: 150px" />
            </div>
            <!-- File input for uploading a new image -->
            <input type="file" id="image" class="form-control w-25" name="image" />
            <span>{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="reset" class="btn btn-danger">Cancel</button>
    </form>

@endsection
