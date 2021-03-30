<?php
namespace App\Http\Controllers\Admin\Distritos;

use App\Distritos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Controller;

class DistritosController extends Controller
{

    public function create()
    {
        return view('admin.tienda.countries.create');
    }

    public function getAll()
    {
        $districts = Distritos::all();
        return response()->json($districts);
    }

    public function getDistrtictByDepartment(Request $request)
    {
        $id = $request->get('id');
        $districts = Distritos::where('departamento_id', $id)->get();

        return response()->json($districts);

    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'departamento_id' => 'required'
        ]);

        $district = new Distritos;
        $district->nombre = $request->get('nombre');
        $district->is_free = $request->get('is_free');
        $district->departamento_id = $request->get('departamento_id');
    
        return response()->json($district->save());
    }


    public function update(Request $request)
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'id' => 'required'
        ]);
        
        $district = Distritos::find($request->get('id'));

        if($district->nombre != $request->get('nombre'))
        {
            $district->nombre = $request->get('nombre');
        }
        $district->is_free = $request->get('is_free');

        return response()->json($district->save());
    }

    public function destroy(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required'
        ]);
        
        $district = Distritos::find($request->get('id'));
        $district->delete();
        
        return response()->json($district->delete());
    }

    public function isFreeDelivery(Request $request) {

        $district = Distritos::find($request->get('id'));
        
        return response()->json($district->is_free);
    }


}
