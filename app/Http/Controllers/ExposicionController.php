<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exposicion;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Traits\Item;

class ExposicionController extends Controller
{
    use Item;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exposiciones = Exposicion::where('tipo', '=', 'evento')
                        ->paginate(8);
                        /*->get();*/
        return view('admin.events.index')->with('exposiciones', $exposiciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create');
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
            'titulo' => 'required',
            'hora' => 'required',
            'lugar' => 'required',
            'distrito' => 'required',
            'precio' => 'required',
            'img' => 'required', //|dimensions:width=960,height=542
            'fecha_inicio' => 'required',
        ]
        /*,
        $messages = [
            'dimensions' => 'La imagen del evento debe ser de 960px de ancho y 542px de alto.'
        ]*/);

        $data = $request->except('img', 'images');

        //$data['publicado'] = ($request->has('publicado')) ? true : false;

        $slug = Str::slug($request['titulo']);
        $slug = $this->getUniqueSlug(new Exposicion, $slug);


        $fecha_inicio = $request['fecha_inicio'] . ' 00:00:00';
        $fecha_fin = $request['fecha_fin'] . ' 00:00:00';


        $exposicion = new Exposicion;
        $preview = (bool) $request['preview'];

        $exposicion->publicado = ($request->has('publicado')) ? true : false;
        $exposicion->slug = $slug;
        $exposicion->img = ($request->hasFile('img')) ?
                $this->uploadImage($request->file('img'), $slug, 'exhibitions') : null;

        $exposicion->titulo = $request->get('titulo');
        $exposicion->artista = $request->get('artista');
        $exposicion->desc = $request->get('desc');
        $exposicion->fecha_inicio = $fecha_inicio;
        $exposicion->fecha_fin = $fecha_fin;
        $exposicion->lugar = $request->get('lugar');
        $exposicion->distrito = $request->get('distrito');
        $exposicion->direccion = $request->get('direccion');
        $exposicion->precio = $request->get('precio');
        $exposicion->hora = $request->get('hora');
        $exposicion->tags = $request['tags'];

        if ($preview) {
            $exposicion->galeria_img = ($request->hasFile('images')) ?
                        json_encode($this->uploadImages($request->file('images'), 'temp_'.time(), 'exhibitions')) : null;

            $exposicion->galeria_img = json_decode($exposicion->galeria_img);
            return view('evento', ['evento' => $exposicion ]);
        }

        $id = $exposicion->id;

        $exposicion->galeria_img = ($request->hasFile('images')) ?
            json_encode($this->uploadImages($request->file('images'), $id, 'exhibitions')) : null;

        $exposicion->tipo = 'evento';

        $exposicion->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Exposición creada.']);

        return redirect()->route('exhibitions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $exposicion = Exposicion::where('slug', '=', $slug)->first();

        $exposicion->galeria_img = ($exposicion->galeria_img) ? json_decode($exposicion->galeria_img) : [];

        $exposicion->fecha_inicio = date('Y-m-d', strtotime($exposicion->fecha_inicio));
        $exposicion->fecha_fin = date('Y-m-d', strtotime($exposicion->fecha_fin));

        return view('admin.events.edit', compact('exposicion'));
    }

    public function deleteGalleryImage(Request $request, $id)
    {
        $event_id = $request['event_id'];
        $event_slug = $request['event_slug'];
        $exposicion = Exposicion::find($event_id);

        $gallery = json_decode($exposicion->galeria_img, true);

        foreach ($gallery as $key => $item) {
            if ($item == $id) {
                array_splice($gallery, $key, 1);
            }
        }

        $exposicion->galeria_img = json_encode($gallery);
        $exposicion->save();

        $path = 'uploads/exhibitions/shop/';
        $bool = \File::delete( $path.$id );


        if ($bool) {
            session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
        }
        return redirect()->route('exhibition.edit', $event_slug);
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
            'titulo' => 'required',
            'hora' => 'required',
            'lugar' => 'required',
            'distrito' => 'required',
            'precio' => 'required',
            'img' => 'required', //dimensions:width=960,height=542
            'fecha_inicio' => 'required',
        ]
        /*,
        $messages = [
            'dimensions' => 'La imagen del evento debe ser de 960px de ancho y 542px de alto.'
        ]*/);

        $data = $request->except('img', 'images');

        $exposicion = Exposicion::findOrFail($id);

        $preview = (bool) $request['preview'];

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];


        $exposicion->fecha_inicio = date('Y-m-d h:m:s', strtotime($fecha_inicio));
        $exposicion->fecha_fin = date('Y-m-d h:m:s', strtotime($fecha_fin));

        $exposicion->desc = $request->get('desc');
        $exposicion->titulo = $request->get('titulo');
        $exposicion->artista = $request->get('artista');
        $exposicion->publicado = ($request->has('publicado')) ? true : false;
        $exposicion->hora = $request->get('hora');
        $exposicion->lugar = $request->get('lugar');
        $exposicion->distrito = $request->get('distrito');
        $exposicion->direccion = $request->get('direccion');
        $exposicion->precio = $request->get('precio');
        $exposicion->tags = $request->get('tags');


        $slug = Str::slug($request['titulo']);
        $slug = $this->getUniqueSlug($exposicion, $slug);

        if (!$this->sameSlug($exposicion, $slug)) {
            $exposicion->slug = $this->getUniqueSlug($exposicion, $slug);
        }

        if ($request->hasFile('img')) {
            $exposicion->deleteImagesEvent();
            $exposicion->img = $this->uploadImage($request->file('img'), $slug, 'exhibitions');
        }

        if ($request->hasFile('images')) {
            $new_images = $this->uploadImages($request->file('images'), $id, 'exhibitions');
            $slides = !is_null($exposicion->galeria_img) ? json_decode($exposicion->galeria_img) : [];
            $new_slides = array_merge($slides, $new_images);
            $exposicion->galeria_img = json_encode($new_slides);
        }

        if ($preview) {
            $exposicion->galeria_img = json_decode($exposicion->galeria_img);
            return view('evento', ['evento' => $exposicion ]);
        }

        $exposicion->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Exposición actualizada.']);

        return redirect()->route('exhibition.edit', $exposicion->slug);

    }

    public function uploadImageTextarea(Request $request)
    {
        $link = '';

        if ($request->hasFile('image_param')) {
            $new_image = $this->uploadTextareaImages($request->file('image_param'), 'exhibitions/events');
            $link = '/uploads/exhibitions/events/'.$new_image;
        }

        $response = new \StdClass;
        $response->link = $link;
        echo stripslashes(json_encode($response));
    }

    public function saveGallery(Request $request, $id)
    {

      $exposicion = Exposicion::findOrFail($id);

      if ($request->hasFile('images')) {
          $new_images = $this->uploadImages($request->file('images'), $id, 'exhibitions');
          $slides = !is_null($exposicion->galeria_img) ? json_decode($exposicion->galeria_img) : [];
          $new_slides = array_merge($slides, $new_images);
          $exposicion->galeria_img = json_encode($new_slides);
      }

      $exposicion->save();
      session()->flash('message', ['type' => 'success', 'message' => 'Galeria Actualizada.']);
      return redirect()->route('exhibition.edit', $exposicion->slug);

    }

    public function updateGalleryPosition(Request $request, $id)
    {
        $new_position = $request->get('data');
        if(!is_null($new_position)) {
            $exposicion = Exposicion::findOrFail($id);
            $exposicion->galeria_img = json_encode($new_position);
            $exposicion->save();
        }
        return response()->json(['success'=>true]);

    }

    public function removeImage(Request $request, $id)
    {
        $event = Exposicion::find($id);
        $event->deleteImage();
        $event->img = null;
        $event->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
        return redirect()->route('exhibition.edit', $event->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exposicion = Exposicion::findOrFail($id);

        $exposicion->deleteImagesEvent();
        $exposicion->deleteGalleryImagesEvent();
        $exposicion->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Exposición eliminada.']);

        return redirect()->route('exhibitions');
    }
}
