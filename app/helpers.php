<?php

function setUser($user) {
    $app = app();
    $customer = $app->make('stdClass');
    $customer->email = $user->email;
    $customer->direccion = $user->direccion;
    $customer->nombres = $user->name;
    $customer->apellidos = $user->apellidos;
    $customer->ciudad = $user->ciudad;
    $customer->pais = $user->pais;
    $customer->telefono = $user->telefono1;
    return $customer;
}

function getCurrencySign() {
  return 'S/ ';
}

function formatDepartamento($departamento) {
    $deps = explode("_", $departamento);
    $dep = '';
    foreach ($deps as $w) {
    $dep .= ucfirst($w). ' ';
    }
    return trim($dep);
}

function html_cut($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
    {
        $symbol  = $text[$i];
        $result .= $symbol;

        switch ($symbol)
        {
           case '<':
                $is_open   = true;
                $grab_open = true;
                break;

           case '"':
               if ($in_double_quotes)
                   $in_double_quotes = false;
               else
                   $in_double_quotes = true;

            break;

            case "'":
              if ($in_single_quotes)
                  $in_single_quotes = false;
              else
                  $in_single_quotes = true;

            break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";

    return $result;
}



/**
* Orden Service
*/
function calcTotalGiftItemOrder($producto, $recargo, $solicitados) {

  $delivery = floatval( $recargo / $solicitados );
  $newPrice = ($producto->precio + $delivery);
  return number_format($newPrice, 2);

}


/**
* Lista Regalo Cliente
*/
function getGiftItemPrice($product) {
  $html = '';
  if(isset($product->dsct_lista_regalo) && ($product->dsct_lista_regalo > 0)) {

    $new_price = floatval($product->precio) - floatval($product->dsct_lista_regalo);

    $html .= '<span style="text-decoration: line-through;color: gray;">S/ '.$product->precio.'</span><br>
    <span class="product-dsct">S/ '.number_format($new_price, 2).'</span>';

  } else {
    $html .= '<span>S/ '.number_format($product->precio, 2).'</span>';
  }

  return $html;
}
function calcTotalChargeGiftItem($product) {
  //sprintf('%0.2f',(floatval( $product->recargo / $product->solicitados ) ));
  /*
    <p>Recargo por delivery (cada item): {{-- 'S/ '. sprintf('%0.2f',(floatval( $product->recargo / $product->solicitados ) )) --<s></s>}}</p>
  */
  $charge = floatval( $product->recargo / $product->solicitados ) * $product->solicitados;
  return number_format($charge, 2);
}
function calcTotalGiftItem($product) {

  $delivery = floatval( $product->recargo / $product->solicitados );
  $newPrice = $product->precio - $product->dsct_lista_regalo;
  $newPrice = ($newPrice + $delivery) * $product->solicitados;
  return number_format($newPrice, 2);

}
/**
* Mostrar precio, incluido el recargo al cliente
* en la Lista de Regalos
*/
function showTotalPriceClient($product) {
  $delivery = floatval( $product->recargo / $product->solicitados );

  $html = '';
  if(isset($product->dsct_lista_regalo) && ($product->dsct_lista_regalo > 0)) {

    $new_price = floatval($product->precio) - floatval($product->dsct_lista_regalo);
    $new_price = $new_price + $delivery;

    $html .= '<span>S/ '.number_format($new_price, 2).'</span>';

  } else {
    $new_price = $product->precio + $delivery;
    $html .= '<span>S/ '.number_format($new_price, 2).'</span>';
  }

  return $html;
}
