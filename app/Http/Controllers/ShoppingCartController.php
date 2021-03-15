<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function show(ShoppingCart $shoppingCart)
    {
        dd(auth()->user());
        return $shoppingCart;
    }
}
