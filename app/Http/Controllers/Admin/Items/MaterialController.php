<?php
namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Material;


class MaterialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiales = Material::all();
        return view('admin.items.materials.index')->with('materiales', $materiales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.materials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre' => 'required',
        ]);

        $material = Material::create(
            request()->all()
        );

        session()->flash('message', ['type' => 'success', 'message' => 'Material creada.']);

        return redirect()->route('admin.materials');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.items.materials.edit')->with('material', $material);
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
        
        $material = Material::findOrFail($id);
        $material->update($request->all());

        session()->flash('message', ['type' => 'success', 'message' => 'Material actualizado.']);

        return redirect()->route('admin.material.edit', $material->id);
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
            $material = Material::findOrFail($id);
            $material->delete();
            session()->flash('message', ['type' => 'success', 'message' => 'Material eliminado.']);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar material. Este material pertenece actualmente a una obra o producto.']);
            }
        }
        
        return redirect()->route('admin.materials');
    }

}