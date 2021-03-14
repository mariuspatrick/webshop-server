<?php

namespace App\Http\Controllers;

use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Product;
use App\Models\ProductsToCart;
use App\Models\ShoppingCart;
use App\Http\Resources\ProductsToCartResource;

class ProductsToCartController extends Controller
{
    public function index($id)
    {
        return ProductsToCartResource::collection(ProductsToCart::where('shopping_cart_id', $id)->get());
    }

    public function getSubtotal()
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
        }

        return response()->json([
            'subtotal' => $subtotal
        ], 200);
    }

    public function removeFromCart($id)
    {
        $product = ProductsToCart::where('unique_id', $id)->first();

        Product::where('id', $product->id)->first()->update([
            'times_removed_from_cart' => +1,
        ]);
        $product->delete();
        return response()->json([
            'deleted' => new ProductsToCartResource($product),
        ], 200);
    }

    public function buy()
    {
        $subtotal = $this->getSubtotal()->getData()->subtotal;
        dd($subtotal);
    }
}
