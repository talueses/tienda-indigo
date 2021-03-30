<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\Services\Cart\Contracts\CartContract;

class CartController extends Controller
{
    protected $cart; 

    public function __construct(CartContract $cart)
    {
        $this->cart = $cart;
    }

    public function getContents(Request $request)
    {
        $items = $this->cart->getContents($request->get('products'));
            
        return response()->json( $items );
    }

}
