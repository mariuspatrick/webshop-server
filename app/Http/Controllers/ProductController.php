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
use App\Http\Resources\ProductsToCartResource;

use App\Repositories\ShoppingCartRepositoryInterface;

class ProductController extends Controller
{
    protected $shoppingCart;

    public function __construct(ShoppingCartRepositoryInterface $shoppingCart)
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
        $this->shoppingCart->add($id, $request);
    }
}
