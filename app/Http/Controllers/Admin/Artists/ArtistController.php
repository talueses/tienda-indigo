<?php
namespace App\Http\Controllers\Admin\Artists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Artista;
use App\Http\Controllers\Traits\Item;


class ArtistController extends Controller
{

    use Item;

    public function index()
    {
        $artistas = Artista::select('artistas.id', 'artistas.slug', DB::raw('CONCAT(artistas.nombres, " ", artistas.apellidos) as nombres'), 'artistas.img', 'artistas.telefono')
        ->getQuery()
        ->get();

        return view('admin.artists.index')->with('artistas', $artistas);
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'pais' => 'required',
            'bio' => 'required|min:3',
            'img' => 'max:3120' //5MB
            /*'img' => 'dimensions:width=510,height=510;',
            'img_portada' => 'dimensions:width=1680,height=240'*/
        ]
        /*,
        $messages = [
          'img.dimensions' => 'La imagen del evento debe ser de 510px de ancho y 510px de alto.',
          'img_portada.dimensions' => 'La imagen de portada debe ser de 1680px de ancho y 240px de alto.'
        ]*/);

        $artista = new Artista;

        $preview = (bool) $request['preview'];

        $artista->nombres = $request['nombres'];
        $artista->apellidos = $request['apellidos'];
        $nombres = $request['nombres'].' '.$request['apellidos'];

        $slug = Str::slug($nombres);
        $artista->slug = $this->getUniqueSlug($artista, $slug);

        $artista->img = ($request->hasFile('img')) ?
                $this->uploadImage($request->file('img'), $artista->slug, 'artists') : null;

        $artista->img_portada = ($request->hasFile('img_portada')) ?
                $this->uploadCover($request->file('img_portada'), $artista->slug.'portada', 'artists') : null;

        $artista->publicado = ($request->has('publicado')) ? true : false;
        $artista->destacado = ($request->has('destacado')) ? true : false;

        $artista->pais = $request['pais'];
        $artista->ciudad = $request['ciudad'];
        $artista->telefono = $request['telefono'];

        $artista->bio = $request['bio'];

        $artista->estudios = $request['estudios'];
        $artista->muestras = $request['muestras'];
        $artista->premios = $request['premios'];

        if ($preview) {
            return view('artista', ['artista' => $artista ]);
        }

        $artista->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Artista creado.']);

        return redirect()->route('admin.artist.edit', $artista->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $artista = Artista::where('slug', '=', $slug)->first();

        $artista->img = ($artista->img) ? '/uploads/artists/'.$artista->img : null;
        $artista->img_portada = ($artista->img_portada) ? '/uploads/artists/'.$artista->img_portada : null;

        return view('admin.artists.edit', compact('artista'));
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
            'nombres' => 'required',
            'apellidos' => 'required',
            'pais' => 'required',
            'bio' => 'required|min:3',
            'img' => 'max:3120']
          );

        $data = $request->except('img');

        $preview = (bool) $request['preview'];

        $artista = Artista::findOrFail($id);

        $nombres = $request['nombres'].' '.$request['apellidos'];

        $slug = Str::slug($nombres);
        $slug = $this->getUniqueSlug($artista, $slug);



        $data['slug'] = (!$this->sameSlug($artista, $slug)) ? $this->getUniqueSlug($artista, $slug) : $slug;

        $artista->slug = $data['slug'];

        $artista->nombres = $request['nombres'];
        $artista->apellidos = $request['apellidos'];
        $artista->publicado = ($request->has('publicado')) ? true : false;
        $artista->destacado = ($request->has('destacado')) ? true : false;
        $artista->bio = $request['bio'];
        $artista->pais = $request['pais'];
        $artista->ciudad = $request['ciudad'];
        $artista->telefono = $request['telefono'];


        $path = 'uploads/artists/';
        if ($request->hasFile('img')) {
            $artista->deleteImages();
            $artista->img = $this->uploadImage($request->file('img'), $data['slug'], 'artists');
        }

        if ($request->hasFile('img_portada')) {
            $artista->deleteCoverImage();
            $artista->img_portada = $this->uploadCover($request->file('img_portada'), $data['slug'].'portada', 'artists');
        }

        $artista->estudios = ($request->has('estudios')) ? $request['estudios'] : '';
        $artista->muestras = ($request->has('muestras')) ? $request['muestras'] : '';
        $artista->premios = ($request->has('premios')) ? $request['premios'] : '';

        if ($preview) {
            return view('artista', ['artista' => $artista ]);
        }

        $artista->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Artista actualizado.']);

        return redirect()->route('admin.artist.edit', $artista->slug);
    }

    public function removeCoverImage(Request $request, $id)
    {
        $artista = Artista::find($id);
        $artista->deleteCoverImage();
        $artista->img_portada = null;
        $artista->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Imagen de Portada eliminada.']);
        return redirect()->route('admin.artist.edit', $artista->slug);
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
            $artista = Artista::findOrFail($id);
            $artista->delete();
            $artista->deleteImages();
            $artista->deleteCoverImage();
            session()->flash('message', ['type' => 'success', 'message' => 'Artista eliminado.']);

        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar artista. Este artista pertenece actualmente a una obra o producto']);
            }
        }

        return redirect()->route('admin.artists');
    }


}