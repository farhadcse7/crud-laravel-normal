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
        $request->validate(
            [
                'name' => 'required|unique:products,name',
                'description' => 'required',
                'price' => 'required|numeric',
                'image' => 'required|mimes:png,jpg,jpeg',
            ]
        );

        Product::addNewProduct($request);
        return back()->with('message', 'New Product information added successfully');
    }

    public function show($id)
    {
        return view('product.view', ['product' => Product::find($id)]);
    }

    public function edit($id)
    {
        return view('product.edit', ['product' => Product::find($id)]);
    }

    public function update(Request $request, $id)
    {
        //return $request;
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'image' => 'nullable|mimes:png,jpg,jpeg',
            ]
        );

        Product::updateProduct($request, $id);
        return back()->with('message', 'Product information updated successfully');
    }

    public function destroy($id)
    {
        Product::deleteProduct($id);
        return redirect()->route('products.index')->with('message', 'Product information deleted successfully');
    }
}
