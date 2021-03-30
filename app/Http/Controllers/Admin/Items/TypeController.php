<?php
namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tipo;


class TypeController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Tipo::all();
        return view('admin.items.types.index')->with('tipos', $tipos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required'
        ]);

        Tipo::create(
            request()->all()
        );

        session()->flash('message', ['type' => 'success', 'message' => 'Tipo de producto guardado.']);
        return redirect()->route('admin.types');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipo = Tipo::find($id);
        return view('admin.items.types.edit')->with('tipo', $tipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'nombre' => 'required',
        ]);

        $tipo = Tipo::findOrFail($id)
            ->update($request->all());

        session()->flash('message', ['type' => 'success', 'message' => 'Tipo actualizado.']);

        return redirect()->route('admin.types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tipo = Tipo::findOrFail($id);
            $tipo->delete();
            session()->flash('message', ['type' => 'success', 'message' => 'Tipo de producto eliminado.']);

        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar tipo. El tipo pertenece actualmente a un producto de la lista.']);
            }
        }

        return redirect()->route('admin.types');
    }
    
}