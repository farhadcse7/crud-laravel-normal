@extends('layouts.app')

@section('title')
    index Page
@endsection

@section('content')

    <h2 class="mb-4">Product List</h2>
    <!-- Add Product -->
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

    <div class="row mb-4">
        <!-- Search Bar -->
        <div class="col-md-6 col-lg-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search here" />
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
        <!-- Sort Dropdown -->
        <div class="col-md-4 col-lg-3">
            <select class="form-select" aria-label="Sort by options">
                <option selected disabled>Sort by...</option>
                <option value="price">Price</option>
                <option value="name">Name</option>
            </select>
        </div>
    </div>

    <!-- Display the success message -->
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show w-75" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        @if ($products->isNotEmpty())
            <!-- Table -->
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th>Product Id</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="text-center align-middle">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ $product->price }}</td>
                            <td>
                                <img src="{{ asset($product->image) }}" alt="Product Image" class="img-thumbnail" style="width: 50px; height:50px" />
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm text-white">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-muted">No products available.</p>
        @endif
    </div>

@endsection
