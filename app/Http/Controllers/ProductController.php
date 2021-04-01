<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Http\Resources\ProductResource;

use App\Services\ShoppingCartService;

class ProductController extends Controller
{
    protected $shoppingCart;

    public function __construct(ShoppingCartService $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }
    //
    public function index()
    {
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
        $response = $this->shoppingCart->addToCart($id, $request);

        return response()->json([
            "shopping_cart" => $response,
        ], 201);
    }
}
