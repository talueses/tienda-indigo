<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\CuentaRegalos;
use App\Producto;
use App\Pagina;
use App\Http\Controllers\Traits\Item;
use App\ListaRegaloProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ListaRegaloController extends Controller
{
    use Item;



    public function updateList(Request $request)
    {
        $id = $request['cuenta_novios_id'];
        $productos = $request['productos'];

        $cuenta = CuentaNovios::find($id);

        foreach ($productos as $id) {
            $producto = Producto::find($id);

            //stock
            /*$producto->stock = $producto->stock - 1;
            $producto->save();*/

            ListaRegaloProducto::create(array(
                'cuenta_novios_id' => $cuenta->id,
                'producto_id' => $producto->id
            ));

        }

        session()->flash('message', ['type' => 'success', 'message' => 'Productos agregados.']);

        return redirect()->route('weddinglist.show', $cuenta->id);
    }

    public function removeList(Request $request)
    {

        $lista_regalos_id = $request['lista_regalos_id'];
        $lista_producto_id = $request['id'];

        $lista_producto = ListaRegaloProducto::where('lista_regalos_id', '=', $lista_regalos_id)
                        ->where('id', '=', $lista_producto_id)
                        ->first();
        $codigo = $lista_producto->lista_regalos->codigo;

        $lista_producto->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Producto eliminado.']);

        return redirect()->route('admin.giftregistry.showList', $codigo);
    }


    public function updateDscto(Request $request)
    {
        //dd($request->all());
        $real_id = $request->get('real_id');
        $dsct_value = $request->get('dsct_value');

        $regalo_product = ListaRegaloProducto::find($real_id);
        $regalo_product->dsct = $dsct_value;
        $regalo_product->save();

        return response()->json(['success' => true]);

    }

}
