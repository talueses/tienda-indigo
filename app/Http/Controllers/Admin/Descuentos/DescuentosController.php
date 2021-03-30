<?php
namespace App\Http\Controllers\Admin\Descuentos;

use App\Descuentos;
use App\Producto;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Item;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class DescuentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $productos= Producto::join('descuentos','descuentos.id','productos.descuento_id')
                              ->where('descuento_id','!=',null)
                              ->where('stock','>',0)
                              ->orderby('descuentos.fecha_inicio')
                              ->orderby('descuentos.fecha_fin')
                              ->get();
       
        return view('admin/tienda/descuentos/index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::where('descuento_id',null)
                    ->where('stock','>',0)
                    ->get();
        // return $productos;
        return view('admin/tienda/descuentos/create',compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = $request->all(); 
        $filtered = Arr::where($item['producto'], function ($value, $key) {
            return is_null($value);
        });

        $datesys=Carbon::now()->format('Y-m-d');

        if (count($item['producto']) != count($filtered)) {
            foreach ($item['producto'] as $key => $monto) {
                if($monto and  isset($item['fecha_i'][$key]) and isset($item['fecha_f'][$key])){
                    // echo $key.'-'.$monto.'-'.$item['fecha_i'][$key].'-'.$item['fecha_f'][$key].'<br>';
                    try { 
                        $descuento= new Descuentos;
                        $descuento->descuento=$monto;
                        $descuento->fecha_inicio= $item['fecha_i'][$key];
                        $descuento->fecha_fin= $item['fecha_f'][$key];
                        $descuento->created_at=Carbon::now();
                        $descuento->updated_at=null;
                        $descuento->user_id= auth()->user()->id;
                        $descuento->producto_id=$key;
                        if($descuento->save()){
                            $producto = Producto::find($key);
                            $producto->descuento_id =$descuento->id;
                            if ($datesys==$item['fecha_i'][$key]) {
                                // $producto->precio=$producto->precio - $monto;
                                $producto->dsct_lista_regalo=$monto;
                            }
                            if($producto->save()){
                                if ($datesys==$item['fecha_i'][$key]) {
                                    $apl= Descuentos::find($descuento->id);
                                    $apl->aplicado=1;
                                    $apl->save();
                                }
                            }
                        };
                    } catch (Exception $e) {
                        //
                    }
                }
            }
            session()->flash('message', ['type' => 'success', 'message' => 'Descuento Asignado']);
            return redirect()->route('admin.descuentos.index');
        }else {
            session()->flash('message', ['type' => 'danger', 'message' => 'Ingresa monto de un producto']);
            return redirect()->route('admin.descuentos.create');
        }
    }

    public function show(Descuentos $descuentos)
    {
        
    }

    
    public function edit($id)
    {
        $productos = Producto::where('id',$id)        
        ->get();                        
        $descuento=Descuentos::where('producto_id',$id)->where('procesado',null)->get();
        return view('admin/tienda/descuentos/edit',compact('productos','descuento')); 
    }

    public function update(Request $request,$id)
    {
        // dd($request->all());
        $descuento=$request->descuento;
        $fecha_i=$request->fecha_i;
        $fecha_f=$request->fecha_f;
        $idDescuento=$request->idDescuento;
        $datesys=Carbon::now()->format('Y-m-d');        
        try { 
            $producto = Producto::find($id);            
            if ($datesys==$fecha_i) {                
                $producto->dsct_lista_regalo=$descuento;
            }else{
                $producto->dsct_lista_regalo=null;
            }
            if($producto->save()){

                $apl= Descuentos::find($idDescuento);
                $apl->descuento=$descuento;
                if ($datesys==$fecha_i) {
                    $apl->aplicado=1;
                }else{
                    $apl->aplicado=null;
                }
                $apl->save();
            }            
            session()->flash('message', ['type' => 'success', 'message' => 'Actualizado correctamente']);
        } catch (Exception $e) {
            //
        }
        
        return redirect()->route('admin.descuentos.edit', $id);
    }

  
    public function destroy(Descuentos $descuentos)
    {
        
    }

    public function cancelDescuento($id){
        $cancel= new Descuentos;
        $cancel->cancelarDescuento($id);
        session()->flash('message', ['type' => 'success', 'message' => 'Se aplicaron cambios']);
        return redirect()->route('admin.descuentos.index');
    }

    public function sincronizaDescuentos(){
        $fecha=Carbon::now()->format('Y-m-d');
        // $fecha='2020-05-26';
        $actualiza= new  Descuentos;
        $actualiza->updateDescuentos($fecha);
        session()->flash('message', ['type' => 'success', 'message' => 'Descuentos actualizados']);
        return redirect()->route('admin.descuentos.index');
    }
}
