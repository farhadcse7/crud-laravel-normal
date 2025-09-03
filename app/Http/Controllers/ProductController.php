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

        // Handle image upload
        if ($request->file('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = 'uploads/product-images/';
            $image->move($directory, $imageName);
            $imageUrl = $directory . $imageName;
        } else {
            $imageUrl = null;
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageUrl;
        $product->save();

        return back()->with('message', 'New Product information added successfully');
    }

    public function show(Product $product)
    {
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
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

        // Image upload or keep old
        if ($request->file('image')) {

            // Remove existing image if any
            if ($product->image && file_exists($product->image)) {
                unlink($product->image);
            }
            // Upload new image
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = 'uploads/product-images/';
            $image->move($directory, $imageName);
            $imageUrl  = $directory . $imageName;
        } else {
            $imageUrl = $product->image;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageUrl;
        $product->save();

        return back()->with('message', 'Product information updated successfully');
    }

    public function destroy(Product $product)
    {
        // Check if image is not null and file exists before unlinking
        if ($product->image && file_exists($product->image)) {
            unlink($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product information deleted successfully');
    }
}
