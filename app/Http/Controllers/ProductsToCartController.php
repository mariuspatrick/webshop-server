<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Product;
use App\Models\ProductsToCart;
use App\Models\ShoppingCart;

class ProductsToCartController extends Controller
{
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

    public function buy()
    {
        $subtotal = $this->getSubtotal()->getData()->subtotal;
        dd($subtotal);
        
    }
}
