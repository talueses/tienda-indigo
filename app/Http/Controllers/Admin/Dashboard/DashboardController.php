<?php
namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pagina;
use App\General;
use App\Descuentos;
use App\Http\Controllers\Traits\Item;
use App\Http\Controllers\Traits\UploadableModelTrait;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\PostTooLargeException;


class DashboardController extends Controller
{
    use Item, UploadableModelTrait;

	public function index()
	{
        $user = \Auth::user();

        $fecha=Carbon::now()->format('Y-m-d');
        $actualiza= new  Descuentos;
        $actualiza->updateDescuentos($fecha);

       $sliders = Pagina::where('titulo', '=', 'inicio')
                ->getQuery()
                ->get();

        $d_generales = General::all();

        $generales = array();
        foreach ($d_generales as $general) {
            $generales[$general->nombre] = $general->valor;
        }

        $img_tienda = Pagina::where('titulo', '=', 'tienda')->first();
        $img_tienda = $img_tienda ? '/uploads/home/section/'.$img_tienda->img : '/media/default.jpg';
        $img_artistas = Pagina::where('titulo', '=', 'artistas')->first();
        $img_artistas = $img_artistas ? '/uploads/home/section/'.$img_artistas->img : '/media/default.jpg';

        return view('admin.index', compact('sliders', 'generales', 'img_tienda', 'img_artistas'));
	}

    public function generalSetting(Request $request)
    {
        $generales = General::all();

        $data_request = $request->except('_token');
        $data = array();

        if (count($data_request) == 8) {

            General::truncate();

            foreach ($data_request as $nombre => $val) {
                $data[] = [
                    'nombre' => $nombre,
                    'valor' => $val
                ];
            }
            General::insert($data);

            session()->flash('message', ['type' => 'success', 'message' => 'Contenido actualizado.']);
        }

        return redirect()->route('admin');

    }

    public function getFreeDeliveryText(Request $request) 
    {
        $generales = General::where('nombre', 'free_delivery')->first();
        //$free_delivery = $generales->valor;

        return response()->json($free_delivery);

    }

    public function getAboutUs(Request $request)
    {
        $nosotros = Pagina::where('titulo', '=', 'nosotros')
                ->getQuery()
                ->get()
                ->first();

        if ($nosotros !== null) {
            $nosotros->img = $nosotros->img ? '/uploads/nosotros/'.$nosotros->img : '';
        }

        return view('admin.aboutus.index')->with('nosotros', $nosotros);
    }

    public function postAboutUs(Request $request)
    {
        $contenido = ($request->hasFile('files')) ? $this->uploadImgDom($request['editordata']) : $request['editordata'];

        $nosotros = Pagina::where('titulo', '=', 'nosotros')
                ->getQuery()
                ->get()
                ->first();

        if ($nosotros !== null) {
            $pagina = Pagina::find($nosotros->id);

            $pagina->img = ($request->hasFile('img')) ? $this->uploadSlide($request['img'], 'nosotros', 'uploads/nosotros/') : $pagina->img;
            $pagina->contenido = $contenido;
            $pagina->update();
            session()->flash('message', ['type' => 'success', 'message' => 'Contenido de Nosotros actualizado.']);
        } else {
            $pagina = new Pagina;
            $pagina->titulo = 'nosotros';
            $pagina->img = ($request->hasFile('img')) ? $this->uploadSlide($request['img'], 'default', 'uploads/nosotros/') : null;
            $pagina->contenido = $contenido;
            $pagina->save();
            session()->flash('message', ['type' => 'success', 'message' => 'Contenido de Nosotros guardado.']);
        }
        return redirect()->route('admin.aboutus');
    }

    public function deleteAboutUsImage(Request $request)
    {
        $nosotros = Pagina::where('titulo', '=', 'nosotros')
                ->getQuery()
                ->get()
                ->first();

        if ($nosotros !== null) {
            $pagina = Pagina::find($nosotros->id);
            $path = 'uploads/nosotros/';
            \File::delete($path.$pagina->img);

            $pagina->img = null;
            $pagina->save();

            session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
        }

        return redirect()->route('admin.aboutus');
    }

}