<?php
// Cargamos Requests y Culqi PHP
include_once dirname(__FILE__).'/Requests/library/Requests.php';
Requests::register_autoloader();
include_once dirname(__FILE__).'/culqi-php/lib/culqi.php';

// Configurar tu API Key y autenticación
$SECRET_KEY = "sk_test_HxvgSUtjkygizIfa";
$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

// Creamos Cargo a una tarjeta
$charge = $culqi->Charges->create(
    array(
      "amount" => $_POST['precio'],
      "currency_code" => "PEN",
      "description" => $_POST['producto'],
      "email" => $_POST['email'],
      "source_id" => $_POST['token']
    )
);
echo 'exito';
