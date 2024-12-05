@extends('layouts.app')

@section('title')
    View Page
@endsection

@section('content')

    <h2 class="mb-4">View Product</h2>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Back to Product List</a>
    <table class="table table-bordered">
        <tr>
            <th>Product Id</th>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <th>Product Name</th>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $product->description }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>{{ $product->price }}</td>
        </tr>
        <tr>
            <th>Image</th>
            <td><img src="{{ asset($product->image) }}" alt="product-image" class="img-thumbnail" width="250" /></td>
        </tr>
    </table>

@endsection
