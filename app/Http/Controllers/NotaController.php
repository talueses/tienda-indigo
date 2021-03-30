<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exposicion;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Traits\Item;

class NotaController extends Controller
{
    use Item;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notas = Exposicion::where('tipo', '=', 'nota')
                    ->paginate(8);
                    /*->get();*/

        foreach ($notas as $nota) {

            $dt = new \DateTime($nota->created_at); // <== instance from another API
            $carbon = \Carbon\Carbon::instance($dt);                             // 'Carbon\Carbon'
            $nota->created_at = $carbon->toDateTimeString();

        }

        return view('admin.notas.index')->with('notas', $notas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notas.create');
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
            'desc' => 'required',
            'fecha' => 'required'
        ]);

        $data = $request->except('img', 'images');

        $data['publicado'] = ($request->has('publicado')) ? true : false;

        $slug = Str::slug($request['titulo']);
        $slug = $this->getUniqueSlug(new Exposicion, $slug);

        $data['slug'] = $slug;

        $data['img'] = ($request->hasFile('img')) ?
                $this->uploadImage($request->file('img'), $slug, 'notes') : null;

        $exposicion = Exposicion::create($data);

        $id = $exposicion->id;

        $exposicion->galeria_img = ($request->hasFile('images')) ?
            json_encode($this->uploadImages($request->file('images'), $id, 'notes')) : null;

        $exposicion->tipo = 'nota';
        
        $fecha = \Carbon\Carbon::parse($request->get('fecha'));
        $exposicion->fecha_inicio = $fecha->toDateTimeString();

        $exposicion->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Nota creada.']);

        return redirect()->route('notes.edit', $exposicion->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nota = Exposicion::find($id);

        $nota->img = $nota->img ? '/uploads/notes/'.$nota->img : '';
        $nota->galeria_img = json_decode($nota->galeria_img);
        $nota->galeria_img = (!is_null($nota->galeria_img) && is_array($nota->galeria_img)) ? $nota->galeria_img : [];

        if (!is_null($nota->fecha_inicio)) {
            $fecha = \Carbon\Carbon::parse($nota->fecha_inicio);
            $nota->fecha = $fecha->format('m/d/Y');
        }

        return view('admin.notas.edit', compact('nota'));
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

        $path = 'uploads/notes/shop/';
        $bool = \File::delete( $path.$id );


        if ($bool) {
            session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
        }
        return redirect()->route('notes.edit', $exposicion->id);
    }


    public function saveGallery(Request $request, $id)
    {

      $exposicion = Exposicion::findOrFail($id);

      if ($request->hasFile('images')) {
          $new_images = $this->uploadImages($request->file('images'), $id, 'notes');
          $exposicion->galeria_img = json_decode($exposicion->galeria_img);
          $slides = (!is_null($exposicion->galeria_img) && is_array($exposicion->galeria_img)) ? $exposicion->galeria_img : [];

          $new_slides = array_merge($slides, $new_images);
          $exposicion->galeria_img = json_encode($new_slides);
      }

      $exposicion->save();
      session()->flash('message', ['type' => 'success', 'message' => 'Galeria Actualizada.']);
      return redirect()->route('notes.edit', $exposicion->id);

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
            'desc' => 'required',
            'fecha' => 'required'
        ]);
        //dd($request->get('fecha'));
        $data = $request->except('img', 'images');
        $exposicion = Exposicion::findOrFail($id);

        $data['publicado'] = ($request->has('publicado')) ? true : false;

        $slug = Str::slug($request->get('titulo'));
        $slug = $this->getUniqueSlug($exposicion, $slug);

        if (!$this->sameSlug($exposicion, $slug)) {
            $exposicion->slug = $this->getUniqueSlug($exposicion, $slug);
        }

        if ($request->hasFile('img')) {
            $exposicion->deleteImagesEvent();
            $exposicion->img = $this->uploadImage($request->file('img'), $slug, 'notes');
        }

        if ($request->hasFile('images')) {
            $new_images = $this->uploadImages($request->file('images'), $id, 'notes');
            $slides = !is_null($exposicion->galeria_img) ? json_decode($exposicion->galeria_img) : [];
            $new_slides = array_merge($slides, $new_images);
            $exposicion->galeria_img = json_encode($new_slides);
        }

        $fecha = \Carbon\Carbon::parse($request->get('fecha'));
        $data['fecha_inicio'] = $fecha->toDateTimeString();
        //dd($data);
        //dd($exposicion->slug);

        $exposicion->update($data);

        session()->flash('message', ['type' => 'success', 'message' => 'Exposición actualizada.']);

        return redirect()->route('notes.edit', $exposicion->id);
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

        $exposicion->deleteImagesNote();
        $exposicion->deleteGalleryImagesNote();
        $exposicion->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Nota eliminada.']);

        return redirect()->route('notes');
    }
}
