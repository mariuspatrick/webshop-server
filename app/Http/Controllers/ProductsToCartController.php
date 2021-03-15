<?php

namespace App\Http\Controllers;

use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Product;
use App\Models\ProductsToCart;
use App\Models\ShoppingCart;
use App\Http\Resources\ProductsToCartResource;
use App\Http\Resources\ProductResource;

class ProductsToCartController extends Controller
{
    public function index($id)
    {
        return ProductsToCartResource::collection(ProductsToCart::where('shopping_cart_id', $id)->get());
    }

    public function buy()
    {
        $subtotal = 0;
        $user = auth()->user();

        $userCart = QueryBuilder::for(ShoppingCart::class)
            ->where('user_id', $user->id)
            ->get()
            ->first();

        $productsInCart = QueryBuilder::for(ProductsToCart::class)
            ->where('shopping_cart_id', $userCart->id)
            ->get();

        foreach ($productsInCart as $products) {
            $product = Product::find($products->product_id);
            $subtotal += $product->price;
            if ($product->quantity > 0) {
                $product->decrement('quantity', 1);
                ProductsToCart::where('product_id', $product->id)->first()->delete();
            } else {
                return response()->json([
                    "message" => $product->title . ' out of stock',
                ]);
            }
            $productArray[] = $product;
        }

        return response()->json([
            'subtotal' => $subtotal,
            'products' => ProductResource::collection($productArray),
        ], 200);
    }

    public function removeFromCart($id)
    {
        $product = ProductsToCart::where('unique_id', $id)->first();

        Product::where('id', $product->id)->first()
            ->increment('times_removed_from_cart', 1);
        $product->delete();
        return response()->json([
            'removed_from_cart' => new ProductsToCartResource($product),
        ], 200);
    }

    public function getProducts()
    {
        $shoppingCart = auth()->user()->cart;
        $productsInCart = ProductsToCart::where('shopping_cart_id', $shoppingCart->id)->get();

        foreach ($productsInCart as $products) {
            $product[] = Product::find($products->product_id);
        }

        return response()->json([
            'products' => ProductResource::collection($product),
        ], 200);
    }
}
