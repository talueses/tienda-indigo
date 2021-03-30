<?php
namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;


class CategoryController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.items.categories.index')->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.categories.create');
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

        try {
            $categoria = Categoria::create(
                request()->all()
            );

            session()->flash('message', ['type' => 'success', 'message' => 'Categoría creada.']);

        } catch (\Exception $e) {
            session()->flash('message', ['type' => 'danger', 'message' => 'Error al crear categoría.']);
        }       

        return redirect()->route('admin.categories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.items.categories.edit')->with('categoria', $categoria);
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
        
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        session()->flash('message', ['type' => 'success', 'message' => 'Categoría actualizado.']);

        return redirect()->route('admin.category.edit', $categoria->id);
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
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            session()->flash('message', ['type' => 'success', 'message' => 'Categoria eliminada.']);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar categoría. Esta categoría pertenece actualmente a un artista.']);
            }
        }
        
        return redirect()->route('admin.categories');
    }

}