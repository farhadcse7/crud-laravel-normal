<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static function addProduct($request)
    {
        $imageUrl = null;

        if ($request->file('image')) {
            $imageUrl = self::uploadImage($request->file('image'), 'uploads/product-images/');
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageUrl;
        $product->save();
    }

    public static function updateProduct($request, $product)
    {
        $imageUrl = $product->image;

        if ($request->file('image')) {
            if ($product->image) {
                unlink($product->image);
            }
            $imageUrl = self::uploadImage($request->file('image'), 'uploads/product-images/');
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageUrl;
        $product->save();
    }

    private static function uploadImage($file, $directory)
    {
        $imageName = time() . '-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $imageName);
        return $directory . $imageName;
    }
}
