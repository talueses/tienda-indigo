<?php
namespace App\Services\Order\Contracts;
use Illuminate\Http\Request;

interface OrderContract {

  public function all();

  public function getByUserId($id);

  public function generateOrder(Request $request, $user, $items);

  public function cancelOrder(Request $request, $orderId);

  public function getOrderInfo($orderId);

  public function refund(Request $request);

}
