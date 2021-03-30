<?php
namespace App\Http\Controllers\Admin\Departamentos;

use App\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Controller;

class DepartamentosController extends Controller
{
    public function getAll() 
    {
        $departarments = Departamentos::all();

        return response()->json($departarments);
    }

    public function getDepartmentsByCountry(Request $request) 
    {
        $id = $request->get('id');
        $departments = Departamentos::where('pais_id', $id)->get();
        
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'pais_id' => 'required'
        ]);

        $department = new Departamentos;
        $department->nombre = $request->get('nombre');
        $department->pais_id = $request->get('pais_id');
    
        return response()->json($department->save());
    }


    public function update(Request $request)
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'id' => 'required'
        ]);
        
        $department = Departamentos::find($request->get('id'));

        if($department->nombre != $request->get('nombre'))
        {
            $department->nombre = $request->get('nombre');
        }

        return response()->json($department->save());
    }

    public function destroy(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required'
        ]);
        
        $department = Departamentos::find($request->get('id'));
        $department->delete();
        
        return response()->json($department->delete());
    }


}
