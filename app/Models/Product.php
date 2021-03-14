<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'title',
        'description',
        'quantity',
        'times_removed_from_cart',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function cart()
    {
        return $this->belongsTo(ProductsToCart::class);
    }
}
