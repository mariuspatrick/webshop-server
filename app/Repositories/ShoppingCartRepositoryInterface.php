<?php

namespace App\Repositories;

interface ShoppingCartRepositoryInterface
{
  /**
   * Add product by ID to cart
   *
   * @param int
   * @return mixed
   */
  public function add($productId, $request);
}
