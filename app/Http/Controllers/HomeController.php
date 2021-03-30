<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Pagina;
use App\General;
use App\Exposicion;
use App\Artista;
use App\Producto;
use App\Obra;
use App\User;
use App\Contacto;
use App\Newsletter;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Traits\AuthenticationUsers;
use App\Http\Controllers\Traits\HasCategories;
use InstaScraper\Insta;
use InstaScraper\Exception\InstagramEncodedException;


class HomeController extends Controller
{
    use AuthenticatesUsers, HasCategories;

    protected $redirectTo = '/cuenta';

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
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        setlocale(LC_ALL, 'es_ES');
        $sliders = Pagina::where('titulo','inicio')->get();

        $prev_shop = Producto::where('publicado', 1)->orderBy('created_at', 'desc')->take(3)->get();
        $prev_shop = $prev_shop->count() >= 3 ? Producto::all()->random(3) : $prev_shop;

        $prev_event = Exposicion::where('tipo','evento')->orderBy('fecha_inicio', 'desc')->first();

        $prev_artist = Artista::orderBy('created_at', 'desc')->take(3)->get();
        $prev_artist = $prev_artist->count() >= 3 ? Artista::all()->random(3) : $prev_artist;

        try {
            $feed_insta = $this->feedInstagram('galeria.indigo');
            $feed_insta = ($feed_insta != null) ? $feed_insta : [];
        } catch(\Exception $e) {

        }

        $img_tienda = Pagina::where('titulo', '=', 'tienda')->first();
        $img_tienda = $img_tienda ? '/uploads/home/section/'.$img_tienda->img : '/media/tienda-prev.jpg';
        $img_artistas = Pagina::where('titulo', '=', 'artistas')->first();
        $img_artistas = $img_artistas ? '/uploads/home/section/'.$img_artistas->img : '/media/artistas-prev.jpg';

        return view('index', compact('sliders','feed_insta','prev_event','prev_artist','prev_shop', 'img_tienda', 'img_artistas'));
    }

    public function redirectReferer($referer)
    {
        return (strpos($referer, 'cart') !== false) ? '/cart' : $this->redirectTo;
    }

    /**
     * Show the about us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function nosotros()
    {
        $us = Pagina::where('titulo','nosotros')->first();
        if (!$us) {
          $us = new Pagina;
          $us->img = 'default.jpg';
          $us->contenido = '<p>Para editar esta sección ingresa al <br><a target="_blank" href="/admin">panel de administraci&oacute;n</a> e inicie sesi&oacute;n ...</p>';
        }
        return view('nosotros', compact('us'));
    }

    /**
     * Show the artists page
     */
    public function artistas()
    {
        $artistas = Artista::orderBy('created_at', 'desc')->where('publicado', 1)->paginate(9);
        foreach ($artistas as $artista) {
          $differencia = Carbon::now()->diffInMonths($artista->created_at);
          $artista->recently = $differencia < 1;
        }
        return view('artistas', compact('artistas'));
    }

    /**
     * show the artist info page
     */
    public function artista($slug)
    {
        $artista = Artista::where('slug','=',$slug)->where('publicado', 1)->first();

        if (!is_null($artista)) 
        {
            return view('artista', compact('artista'));
        }

        return redirect()->route('home.artistas');
    }

    /**
     * show the obras page
     */
    public function obras()
    {
      $obra = Pagina::where('titulo','obras')->first();
      return view('obras', compact('obra'));
    }

    /**
     * show the obra info page
     */
    public function obra($slug)
    {
        $obra = Obra::where('slug','=',$slug)->where('publicado', 1)->first();
        
        if (!is_null($obra)) {

            $obra->galeria_img = !is_null($obra->galeria_img) ? json_decode($obra->galeria_img) : array();

            $medidas = explode('x',$obra->tamano);
            $alto = isset($medidas[0]) ? trim($medidas[0]) : '';
            $ancho = isset($medidas[1]) ? trim($medidas[1]) : '';
            $largo = isset($medidas[2]) ? trim($medidas[2]) : '';


            $producto_tienda = null;

            if($obra->disponible_tienda !== 'ninguno' && !is_null($obra->disponible_tienda)) 
            {
              $producto_t = Producto::find($obra->disponible_tienda);

              if (!is_null($producto_t)) 
              {
                $producto_tienda = $producto_t->slug;
              }

            }
            
            return view('obra', compact('obra', 'alto', 'ancho', 'largo', 'producto_tienda'));
        }

        return redirect()->route('home.obras');
    }

    public function notas()
    {
        $notas = Exposicion::where('tipo','nota')
                              ->where('publicado', 1)
                              ->orderBy('created_at', 'desc')
                              ->get();

        Carbon::setLocale('es');
        Carbon::setUtf8(true);

        $menu = $notas->sortByDesc('created_at')->groupBy([
          function ($item) { return Carbon::parse($item['created_at'])->year; },
          function ($item) { setlocale(LC_ALL, 'es_ES'); return strtolower(strftime('%B', strtotime($item['created_at']))); },
        ], $preserveKeys = true);


        try {
          if (request('mes') && request('periodo')) {
            $notas = $this->categoriesListByMonth(request('mes'), request('periodo'), 'nota');
          }
        } catch (\Exception $e) {

        }

        foreach ($notas as $nota) {
            $nota->created_at_formated = $nota->created_at->toFormattedDateString();
        }

        $notas = $notas->paginate(4);

        return view('notas', compact('notas', 'menu'));
    }

    public function nota($slug)
    {
        setLocale(LC_ALL, 'es_ES');
        $nota = Exposicion::where('slug',$slug)->where('publicado', 1)->first();

        if (!is_null($nota)) {
            $nota->galeria_img = ($nota->galeria_img) ? json_decode($nota->galeria_img) : [];
            $created_at = $nota->created_at->toFormattedDateString();

            return view('nota', compact('nota', 'created_at'));
        }

        return redirect()->route('home.notas');
    }

    /**
     * show the eventos page
     */
    public function eventos()
    {
        $eventos = Exposicion::where('tipo','evento')
                        ->where('publicado', 1)
                        ->orderBy('created_at', 'desc')
                        ->get();

        Carbon::setLocale('es');
        Carbon::setUtf8(true);

        $menu = $eventos->sortByDesc('fecha_inicio')->groupBy([
          function ($item) { return Carbon::parse($item['fecha_inicio'])->year; },
          function ($item) { setlocale(LC_ALL, 'es_ES'); return strtolower(strftime('%B', strtotime($item['fecha_inicio']))); },
        ], $preserveKeys = true);


        try {
          if (request('mes') && request('periodo')) {
            $eventos = $this->categoriesListByMonth(request('mes'), request('periodo'), 'evento');
          }
        } catch (\Exception $e) {

        }

        foreach ($eventos as $evento) {
            $evento->created_at_formated = $evento->created_at->toFormattedDateString();
        }

        $eventos = $eventos->paginate(4);
        return view('eventos', compact('eventos', 'menu'));
    }

    /**
     * show the evento info page
     */
    public function evento($slug)
    {
        # code...
        setLocale(LC_ALL, 'es_ES');
        $evento = Exposicion::where('slug',$slug)->where('publicado', 1)->first();

        if (!is_null($evento)) {
            $evento->galeria_img = ($evento->galeria_img) ? json_decode($evento->galeria_img) : [];
            return view('evento', compact('evento'));
        }

        return redirect()->route('home.eventos');
    }

    public function feedInstagram($profile)
    {
        $Instagram = new Insta();
        try {
          return $Instagram->getMediasFromPage($profile);
        } catch (\Exception $e) {
          // print_r($e->getMessage());
        }
        /*try {
          $dom = new \DOMDocument('1.0');
          //Load html content from url to merge to the new DOM
          $dom->loadHTMLFile('https://www.instagram.com/'.$profile);
          //GET ELEMENTS HTML
          //get script that contents all info profile showed on instagram
          $script = $dom->getElementsByTagName('script');


          //dd($script[4]->nodeValue);
          $content_profile = $script[4]->nodeValue;
          $stringArray = substr($content_profile, 21,-1);
          $parseContent = json_decode($stringArray);
          //Management content profile
          //get all medias feed profile
          $feedmedia = $parseContent->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;
          return $feedmedia;

        } catch (\Exception $e) {

        }*/
    }

    public function showContact()
    {
      return view('contact');
    }

    public function contact(Request $request)
    {
        $messages = [
            'nombres.required'       => 'Ingrese sus nombres.',
            'correo.required'        => 'Ingrese su correo electrónico.',
            'correo.email'           => 'Correo inválido.',
            'mensaje.required'       => 'Ingrese su mensaje.',
            'mensaje.min'            => 'Ingrese al menos 6 caracteres en su mensaje.',
        ];

        $this->validate(request(), [
            'nombres' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255',
            'mensaje' => 'required|string|min:6'
        ], $messages);

        /*if ($validator->fails()) {
            //dd($validator->errors());
            session()->flash('message', ['type' => 'danger', 'message' => 'Por favor complete todos los campos.']);
        } else {*/
        Contacto::create([
            'nombres' => $request->get('nombres'),
            'correo' => $request->get('correo'),
            'mensaje' => $request->get('mensaje')
        ]);
        //}

        return redirect()->route('home.contact');
    }

    public function newsletter(Request $request)
    {
        $messages = [
            'email.required'        => 'Ingrese su email.',
            'email.email'           => 'Correo inválido.',
            'email.unique'          => 'Este correo ya se encuentra registrado.',
        ];

        $validator = \Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:newsletter',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }

        Newsletter::create([
            'name' => $request->get('nombres'),
            'email' => $request->get('email')
        ]);

        return response()->json(['success' => true ]);
    }

    public function terminos()
    {
        $termino = General::where('nombre', 'terminos_condiciones')->get()->first();
        $title = 'Términos y Condiciones de Uso';
        return view('terminos', compact('title','termino'));
    }

    public function privacidad()
    {
        $termino = General::where('nombre', 'politicas_privacidad')->get()->first();
        $title = 'Políticas de privacidad y confidencialidad';
        return view('terminos', compact('title','termino'));
    }

    public function devoluciones()
    {
        $termino = General::where('nombre', 'politicas_devoluciones')->get()->first();
        $title = 'Políticas de Devoluciones';
        return view('terminos', compact('title','termino'));
    }

    public function free_delivery(){
      $free_delivery=General::where('nombre','is_free')->get();
    } 

}
