<?php
namespace App\Services\Billing;
use \Culqi\Culqi as CulqiGateway;

class Culqi implements Contracts\BillingContract  {


    public function charge($user, $items, $orderId) {

        $sub_total = (float) $items['subtotal'];

        $culqi = new CulqiGateway(['api_key' => env('CULQI_APP_KEY')]);

        $payment =  $culqi->Charges->create(
          [
            "amount" => (int) $sub_total * 100,
            "capture" => true,
            "currency_code" => "PEN",
            "description" => "Orden #" . $orderId . ' - ' . date('F d, Y g:ia'),
            "email" => $user->card_email,
            "installments" => 0,
            "antifraud_details" => [
                "address" => $user->direccion,
                "address_city" => $user->ciudad,
                "country_code" => $user->pais,
                "first_name" => $user->name,
                "last_name" => $user->apellidos,
                "phone_number" => $user->telefono1,
            ],
            "source_id" => $items['source_id']
          ]
        );
        
        return $payment;

    }

}
