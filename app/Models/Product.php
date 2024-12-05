<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    private static $product, $image, $imageName, $imageUrl, $directory;

    public static function addProduct($request)
    {
        if ($request->file('image')) {
            self::$image = $request->file('image');
            self::$imageName = time() . '-' . Str::uuid() . '.' . self::$image->getClientOriginalExtension();
            self::$directory = 'uploads/product-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        }
        self::$product = new Product();
        self::$product->name = $request->name;
        self::$product->description = $request->description;
        self::$product->price = $request->price;
        self::$product->image = self::$imageUrl;
        self::$product->save();
    }

    public static function updateProduct($request, $product)
    {
        self::$product = $product;

        if ($request->file('image')) {
            if (self::$product->image) {
                unlink(self::$product->image);
            }
            self::$image = $request->file('image');
            self::$imageName = time() . '-' . Str::uuid() . '.' . self::$image->getClientOriginalExtension();
            self::$directory = 'uploads/product-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        } else {
            self::$imageUrl = self::$product->image;
        }

        self::$product->name = $request->name;
        self::$product->description = $request->description;
        self::$product->price = $request->price;
        self::$product->image = self::$imageUrl;
        self::$product->save();
    }

    public static function deleteProduct($product)
    {
        self::$product = $product;

        // Check if image is not null and file exists before unlinking
        if (self::$product->image && file_exists(public_path(self::$product->image))) {
            unlink(self::$product->image);
        }

        self::$product->delete();
    }
}
