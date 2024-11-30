<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    private static $product, $image, $imageName, $imageUrl, $directory;

    public static function addNewProduct($request)
    {
        self::$image = $request->file('image');
        self::$imageName = time() . '_' . Str::uuid() . '_' . self::$image->getClientOriginalName();
        self::$directory = 'uploads/product-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;

        self::$product = new Product();
        self::$product->name = $request->name;
        self::$product->description = $request->description;
        self::$product->price = $request->price;
        self::$product->image = self::$imageUrl;
        self::$product->save();
    }

    public static function updateProduct($request, $id)
    {
        self::$product = Product::find($id);
        if ($request->file('image')) {
            if (self::$product->image) {
                unlink(self::$product->image);
            }
            self::$image = $request->file('image');
            self::$imageName = time() . '_' . Str::uuid() . '_' . self::$image->getClientOriginalName();
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

    public static function deleteProduct($id)
    {
        self::$product = Product::find($id);
        unlink(self::$product->image);
        self::$product->delete();
    }
}
