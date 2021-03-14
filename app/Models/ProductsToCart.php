<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsToCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_cart_id',
        'product_id',
        'product_quantity',
        'unique_id'
    ];

    public function shoppingCart()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function user()
    // {
    //     return $this->hasMany(User::class);
    // }
}
