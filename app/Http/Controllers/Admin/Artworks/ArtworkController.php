<?php
namespace App\Http\Controllers\Admin\Artworks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Obra;
use App\Artista;
use App\Categoria;
use App\Material;
use App\ObraMaterial;
use App\Pagina;
use App\Producto;
use App\Http\Controllers\Traits\Item;


class ArtworkController extends Controller
{

    use Item;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $obras = Obra::leftJoin('artistas', 'obras.artista_id', '=', 'artistas.id')
                ->leftJoin('productos', 'obras.disponible_tienda', '=', 'productos.id')
                ->select('productos.sku', 'obras.id', 'obras.img', 'obras.nombre', 'obras.publicado', 'obras.slug', DB::raw('CONCAT(artistas.nombres," ",artistas.apellidos) as artista_nombres') )
                ->getQuery()
                ->get();

        return view('admin.artworks.index')->with('obras', $obras);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Artistas
        $artistas = Artista::select('id', 'nombres', 'apellidos')
                ->getQuery()
                ->get();

        //Categorias
        $categorias = Categoria::select('id', 'nombre')
                ->getQuery()
                ->get();

        //Materials
        $materiales = Material::select('id', 'nombre')
                ->getQuery()
                ->get();

        return view('admin.artworks.create', compact('artistas', 'categorias', 'materiales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'desc_corta' => 'required',
            'categoria' => 'required'
        ]);

        $artista = ($request->has('artista')) ? Artista::find($request['artista']) : null;
        $categoria = ($request->has('categoria')) ? Categoria::find($request['categoria']) : null;

        $materiales = $request['materiales'];

        $obra = new Obra;

        $preview = (bool) $request['preview'];

        $obra->categoria()->associate($categoria);
        $nombre = $request['nombre'];
        $obra->nombre = $nombre;
        $obra->publicado = ($request->has('publicado')) ? true : false;
        $slug = Str::slug($nombre);

        $obra->slug = $this->getUniqueSlug($obra, $slug);
        $obra->img = ($request->hasFile('img')) ?
                    $this->uploadImage($request->file('img'), $slug, 'artworks') : null;

        $obra->desc = $request['desc'];
        $obra->desc_corta = $request['desc_corta'];
        $obra->tamano = $request['tamano'];
        $obra->peso = $request['peso'];
        $obra->anio = $request['anio'];

        $obra->artista()->associate($artista);

        if ($preview) {

            $obra->galeria_img = ($request->hasFile('images')) ?
                    json_encode($this->uploadImages($request->file('images'), 'temp_'.time(), 'artworks')) : null;
            $obra->galeria_img = json_decode($obra->galeria_img);
            return view('obra', ['obra' => $obra ]);
        }

        $obra->save();

        $id = $obra->id;

        $obra->galeria_img = ($request->hasFile('images')) ?
            json_encode($this->uploadImages($request->file('images'), $id, 'artworks')) : null;

        $obra->disponible_tienda = $request['disponible_tienda'];
        $obra->save();


        if ($obra->id) {

            if (!empty($materiales)) {
                foreach ($materiales as $material) {
                    DB::table('obra_material')->insert([
                        ['obra_id' => $obra->id, 'material_id' => $material ]
                    ]);
                }
            }
        }

        session()->flash('message', ['type' => 'success', 'message' => 'Obra guardada.']);

        return redirect()->route('admin.artwork.edit', $obra->slug);
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //Categorias
        $categorias = Categoria::select('id', 'nombre')
                ->getQuery()
                ->get();

        //Artistas
        $artistas = Artista::select('id', 'nombres', 'apellidos')
                ->getQuery()
                ->get();

        //Materials
        $materiales = Material::select('id', 'nombre')
                ->getQuery()
                ->get();

        $obra = Obra::where('slug', '=', $slug)->with('materiales')->first();
    
        $obra->img = ($obra->img) ? '/uploads/artworks/'.$obra->img : null;

        $obra->galeria_img = ($obra->galeria_img) ? json_decode($obra->galeria_img) : [];

        return view('admin.artworks.edit', compact('obra', 'artistas', 'categorias', 'materiales'));
    }

    public function deleteGalleryImage(Request $request, $id)
    {

        $slug = $request['slug'];
        $obra = Obra::where('slug', '=', $slug)->first();

        $gallery = json_decode($obra->galeria_img, true);

        foreach ($gallery as $key => $item) {
            if ($item == $id) {
                array_splice($gallery, $key, 1);
            }
        }

        $obra->galeria_img = json_encode($gallery);
        $obra->save();

        $path = 'uploads/artworks/shop/';
        $bool = \File::delete( $path.$id );


        if ($bool) {
            session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
        }
        return redirect()->route('admin.artwork.edit', $slug);
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
            'desc_corta' => 'required',
        ]);

        $data = $request->except('img');

        $preview = (bool) $request['preview'];

        $obra = Obra::findOrFail($id);

        $categoria = ($request->has('categoria')) ? Categoria::find($request['categoria']) : null;

        $materiales = $request['materiales'];

        $obra->categoria()->dissociate();
        $obra->categoria()->associate($categoria);

        $artista = ($request->has('artista')) ? Artista::find($request['artista']) : null;

        $obra->artista()->dissociate();
        $obra->artista()->associate($artista);

        $nombre = $request['nombre'];
        $data['publicado'] = ($request->has('publicado')) ? true : false;
        $slug = Str::slug($nombre);
        $obra->slug = $this->getUniqueSlug($obra, $slug);


        if ($request->hasFile('img')) {
            $obra->deleteImages();
            $obra->img = $this->uploadImage($request->file('img'), $slug, 'artworks');
        }


        if ($request->hasFile('images')) {
            $new_images = $this->uploadImages($request->file('images'), $id, 'artworks');
            $slides = !is_null($obra->galeria_img) ? json_decode($obra->galeria_img) : [];
            $new_slides = array_merge($slides, $new_images);
            $obra->galeria_img = json_encode($new_slides);
        }

        if ($preview) {
            $obra->galeria_img = json_decode($obra->galeria_img);
            return view('obra', ['obra' => $obra ]);
        }


        if ($obra->id) {
            DB::table('obra_material')->where('obra_id', $obra->id)->delete();

            if (!empty($materiales)) {
                foreach ($materiales as $material) {
                    DB::table('obra_material')->insert([
                        ['obra_id' => $obra->id, 'material_id' => $material ]
                    ]);
                }
            }
        }

        $obra->update($data);

        session()->flash('message', ['type' => 'success', 'message' => 'Obra actualizada.']);

        return redirect()->route('admin.artwork.edit', $obra->slug);
    }

    public function saveGallery(Request $request, $id)
    {
      $obra = Obra::findOrFail($id);

      if ($request->hasFile('images')) {
          $new_images = $this->uploadImages($request->file('images'), $id, 'artworks');
          $slides = !is_null($obra->galeria_img) ? json_decode($obra->galeria_img) : [];
          $new_slides = array_merge($slides, $new_images);
          $obra->galeria_img = json_encode($new_slides);
      }

      $obra->save();
      session()->flash('message', ['type' => 'success', 'message' => 'Galeria Actualizada.']);
      return redirect()->route('admin.artwork.edit', $obra->slug);
    }


    public function updateGalleryPosition(Request $request, $id)
    {
        $new_position = $request->get('data');
        if(!is_null($new_position)) {
            $obra = Obra::findOrFail($id);
            $obra->galeria_img = json_encode($new_position);
            $obra->save();
        }
        return response()->json(['success'=>true]);

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
            $obra = Obra::findOrFail($id);

            $obra->deleteImages();
            $obra->deleteGalleryImages();

            $obra->delete();
            session()->flash('message', ['type' => 'success', 'message' => 'Obra eliminada.']);

        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar obra.']);
            }
        }

        return redirect()->route('admin.artworks');
    }

    public function duplicate($id)
    {
        $original = Obra::findOrFail($id);

        $duplicated_artwork = new Obra;
        $duplicated_artwork = $original->replicate();
        $slug = Str::slug($original->nombre);
        $slug = $this->getUniqueSlug($duplicated_artwork, $slug);
        $duplicated_artwork->slug = $slug;
        $duplicated_artwork->disponible_tienda = 'ninguno';
        $duplicated_artwork->save();
        $img = $duplicated_artwork->duplicateImages($original);
        $galeria_img = $duplicated_artwork->duplicateGalleryImages($original);
        $duplicated_artwork->img = $img;
        $duplicated_artwork->galeria_img = $galeria_img;
        $duplicated_artwork->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Obra duplicada.']);

        return redirect()->route('admin.artworks');
    }

    public function syncproductProduct(Request $request)
    {

        $id = $request->artwork_id;
        $product_slug = $request->artwork_slug;
        $response;

        try {

            $obra = Obra::find($id);
            $product = Producto::where('slug', $product_slug)->first();

            $product->nombre = $obra->nombre;
            $product->publicado = $obra->publicado;
            $product->categoria_id = $obra->categoria_id;
            $product->stock = 0;
            $product->sku = null;
            $product->desc = $obra->desc;
            $product->desc_corta = $obra->desc_corta;
            $product->slug = $obra->slug;

            $response = $product->save();
            $obra->disponible_tienda = $product->id;
            $obra->save();

        } catch (\Exception $e) {

            $msg = "Error";

            return response()->json([
              'success' => false,
              'data' => $msg
            ]);
        }


        return response()->json([
          'success' => $response,
          'data' => "Producto actualizado"
        ]);

    }


    public function replicateProduct(Request $request)
    {

        $id = $request->artwork_id;
        $original = Obra::find($id);
        
        $slug = Str::slug($original->nombre);
        $slug = $this->getUniqueSlug(new Producto, $slug);

        $exist = Producto::where('slug', $slug)->withTrashed()->first();

        try {
            $product = is_null($exist) ? new Producto : $exist;
            $product->nombre = $original->nombre;
            $product->publicado = $original->publicado;
            $product->categoria_id = $original->categoria_id;
            $product->stock = 0;
            $product->sku = null;
            $product->desc = $original->desc;
            $product->desc_corta = $original->desc_corta;     
            $product->slug = $slug;
            $product->tamano = null;
            $product->color = "[]";
            $product->otros_detalles = null;
            $product->artista_id = $original->artista_id;
            $product->tipo_id = null;
            $product->deleted_at = null;
            if(!is_null($exist)) {
                $product->deleteImages();
                $product->deleteGalleryImages();
            }
            $product->save();

            $original->disponible_tienda = $product->id;
            $original->save();

            $img = $product->duplicateImages($original, true);
            $galeria_img = $product->duplicateGalleryImages($original, true);
            $product->img = $img;
            $product->galeria_img = $galeria_img;
            $product->save();
        
        } catch (\Exception $e) {

            $msg = ($e->getCode() ==  "23000") ?  "Producto ya existe" : "Error: ".$e->getMessage();

            return response()->json([
              'success' => false,
              'data' => $msg
            ]);
        }

        return response()->json([
          'success' => true,
          'data' => "Producto creado"
        ]);


    }

}
