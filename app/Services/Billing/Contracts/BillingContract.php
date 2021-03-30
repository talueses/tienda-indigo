<?php


namespace App\Services\Billing\Contracts;


interface BillingContract {

  public function charge($user, $total, $orderId);

}
