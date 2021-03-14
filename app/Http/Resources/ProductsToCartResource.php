<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsToCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "shopping_cart_id" => $this->shopping_cart_id,
            "product_id" => $this->product_id,
            "unique_id" => $this->unique_id,
        ];
    }
}
