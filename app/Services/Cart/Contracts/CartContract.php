<?php
namespace App\Services\Cart\Contracts;

interface CartContract {

  public function getContents($list);

  public function getStockDatabase($list);

  public function getCartTotal($list);
}
