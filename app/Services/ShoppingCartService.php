<?php

namespace App\Services;

use App\Repositories\ShoppingCartRepository;

class ShoppingCartService
{
  protected $shoppingCartRepository;

  public function __construct(ShoppingCartRepository $shoppingCartRepository)
  {
    $this->shoppingCartRepository = $shoppingCartRepository;
  }

  public function addToCart($productId, $request)
  {
    $request->validate([
      'quantity' => 'required|numeric|min:0|not_in:0'
    ]);

    $data = $this->shoppingCartRepository->add($productId, $request);

    return $data;
  }
}
