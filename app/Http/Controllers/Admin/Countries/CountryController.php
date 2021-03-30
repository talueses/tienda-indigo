<?php
namespace App\Http\Controllers\Admin\Countries;

use App\Pais;
use App\Distritos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{

   

    public function index()
    {
        $paises = Pais::all();
        
        return view('admin.tienda.countries.index')->withPaises($paises);
    }

    public function create()
    {
        return view('admin.tienda.countries.create');
    }

    public function getAll()
    {
        $paises = Pais::all();
        return response()->json($paises);
    }

    public function belongsToLimaMetropolitana(Request $request)
    {
        $item = $request->all();        
        $distrito = $item['distrito'];
        $departamento=$item['iddepartamento'];
        $lima_metropolitana=Distritos::Where('is_free',1)
                            ->where('nombre',$distrito)
                            ->where('departamento_id',$departamento)
                            ->select('nombre')
                            ->get()->toArray();
          // return response()->json($lima_metropolitana);
        if (count($lima_metropolitana)>0) {
          return response()->json(['belongs' => true]);
        } else {
          return response()->json(['belongs' => false]);
        }
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre' => 'required'
        ]);

        $pais = new Pais;
        $pais->nombre = $request->get('nombre');
        $pais->desc = $request->get('desc');
        $pais->save();

        session()->flash('message', ['type' => 'success', 'message' => 'País creado.']);

        return redirect()->route('admin.countries');
    }

    public function edit($id)
    {
        $pais = Pais::find($id);
        return view('admin.tienda.countries.edit')->withPais($pais);
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'nombre' => 'required',
        ]);
        
        $pais = Pais::find($id);

        if($pais->nombre != $request->get('nombre'))
        {
            $pais->nombre = $request->get('nombre');
        }
        $pais->desc = $request->get('desc');
    
        if($pais->save()) {
            session()->flash('message', ['type' => 'success', 'message' => 'País actualizado.']);
        } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'No se pudo actualizar el pais o el nombre ya esta tomado']);
        }

        return redirect()->route('admin.countries.edit', $pais->id);
    }

    public function destroy($id)
    {
        try {
            $pais = Pais::findOrFail($id);
            $pais->delete();
            
            session()->flash('message', ['type' => 'success', 'message' => 'País eliminado.']);

        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar país.']);
            }
        }

        return redirect()->route('admin.countries');
    }


}
