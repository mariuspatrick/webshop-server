<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\ProductsToCart;
use App\Models\ShoppingCart;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    //
    public function index()
    {
        dd(auth()->user());
        return ProductResource::collection(Product::all());
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $createdProduct = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'data' => $createdProduct
        ], 200);
    }

    public function addToCart($id, Request $request)
    {
        $shoppingCart = auth()->user()->cart;
        $product = Product::find($id);

        $this->validate($request, [
            'quantity' => 'required|numeric|min:0|not_in:0'
        ]);

        if ($product->quantity > 0) {
            for ($x = 0; $x < $request->quantity; $x++) {
                ProductsToCart::create([
                    'shopping_cart_id' => $shoppingCart->id,
                    'product_id' => $id,
                    'unique_id' => Str::random(9),
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Product out of stock!'
            ], 200);
        }

        return response()->json([
            'shopping_cart' => ProductsToCart::where('shopping_cart_id', $shoppingCart->id)->get(),
        ], 200);
    }

    public function removeFromCart()
    {
    }
}
