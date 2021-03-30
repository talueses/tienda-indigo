<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\General;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Traits\AuthenticationUsers;
use App\Http\Controllers\Traits\HasCategories;
use InstaScraper\Insta;
use InstaScraper\Exception\InstagramEncodedException;


class TerminosCondicionesController extends Controller
{
    use AuthenticatesUsers, HasCategories;

    protected $redirectTo = '/cuenta';

    protected $format_names = [
      'terminos_condiciones' => 'Términos y Condiciones',
      'politicas_devoluciones' => 'Políticas de Devoluciones',
      'politicas_privacidad' => 'Políticas de Privacidad'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //code
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $condiciones = array(
        'terminos_condiciones',
        'politicas_privacidad',
        'politicas_devoluciones'
      );

      $generales = General::select('id', 'nombre', 'valor')
              ->whereIn('nombre', $condiciones)
              ->getQuery()
              ->get();

        if ($generales->isEmpty()) {
          //create
          foreach ($condiciones as $nombre) {
              $data[] = [
                  'nombre' => $nombre,
                  'valor' => ''
              ];
          }
          General::insert($data);
        }

        $generales = General::select('id', 'nombre', 'valor')
                ->whereIn('nombre', $condiciones)
                ->getQuery()
                ->get();


        foreach ($generales as $condicion) {
            $condicion->format_nombre = $this->format_names[$condicion->nombre];
        }

        //dd($generales);
        return view('admin.terminoscondiciones.index', compact('generales') );
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $id = $request->get('termino_id');
        $text = $request->get('editordata');

        $condicion = General::find($id);
        //dd($condicion);
        $condicion->valor = $text;
        $condicion->update();

        session()->flash('message', ['type' => 'success', 'message' => 'Actualizado correctamente.']);
        return redirect()->route('admin.terminosycondiciones.edit', $condicion->nombre);

    }

    public function edit($name)
    {
        $condicion = General::where('nombre', $name)->get()->first();

        $links = [
          'terminos_condiciones' => 'terminos',
          'politicas_devoluciones' => 'devoluciones',
          'politicas_privacidad' => 'privacidad'
        ];

        $link = $links[$condicion->nombre];

        return view('admin.terminoscondiciones.edit', compact('condicion', 'link') );
    }

}
