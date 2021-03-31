<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\ProductsToCart;
use App\Http\Resources\ProductsToCartResource;

class ShoppingCartRepository implements ShoppingCartRepositoryInterface
{
  public function add($productId, $request)
  {
    // dd($request['quantity']);
    $shoppingCart = auth()->user()->cart;
    $product = Product::find($productId);
    $subtotal = 0;

    $request->validate([
      'quantity' => 'required|numeric|min:0|not_in:0'
    ]);

    if ($product->quantity > 0) {
      for ($x = 0; $x < $request->quantity; $x++) {
        ProductsToCart::create([
          'shopping_cart_id' => $shoppingCart->id,
          'product_id' => $productId,
          'unique_id' => Str::random(9),
        ]);
      }
    } else {
      return response()->json([
        'message' => 'Product out of stock!'
      ], 200);
    }

    //Update cart subtotal
    $productsInCart = ProductsToCart::where('shopping_cart_id', $shoppingCart->id)->get();

    foreach ($productsInCart as $products) {
      $product = Product::find($products->product_id);
      $subtotal += $product->price;
    }

    $shoppingCart->first()->update([
      'sub_total' => +$subtotal,
    ]);

    return response()->json([
      'shopping_cart' => ProductsToCartResource::collection(ProductsToCart::where('shopping_cart_id', $shoppingCart->id)->get()),
    ], 200);
  }
}
