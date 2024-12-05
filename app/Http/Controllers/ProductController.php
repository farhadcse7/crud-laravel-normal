<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', ['products' => Product::all()]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        // return $request;
        // dd($request->all());
        $request->validate(
            [
                'name'        => 'required|unique:products,name',
                'description' => 'required',
                'price'       => 'required|numeric|min:0|max:999999.99',
                'image'       => 'nullable|mimes:png,jpg,jpeg',
            ]
        );

        Product::addProduct($request);
        return back()->with('message', 'New Product information added successfully');
    }

    public function show(Product $product)
    {
        return view('product.view', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('product.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(
            [
                'name'        => 'required|unique:products,name,' . $product->id,
                'description' => 'required',
                'price'       => 'required|numeric|min:0|max:999999.99',
                'image'       => 'nullable|mimes:png,jpg,jpeg',
            ]
        );

        Product::updateProduct($request, $product);
        return back()->with('message', 'Product information updated successfully');
    }

    public function destroy(Product $product)
    {
        Product::deleteProduct($product);
        return redirect()->route('products.index')->with('message', 'Product information deleted successfully');
    }
}
