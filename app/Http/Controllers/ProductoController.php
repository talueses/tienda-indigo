<?php

namespace App\Http\Controllers;

use App\Obra;
use App\Tipo;
use App\Artista;
use App\Material;
use App\Producto;
use App\Categoria;
use App\ObraMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Traits\Item;

class ProductoController extends Controller
{
    use Item;

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
        //Tipos
        $tipos = Tipo::select('id', 'nombre')
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

        return view('admin.tienda.productos.create', compact('artistas', 'tipos', 'categorias', 'materiales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: exp regular para tamaño 
        $this->validate($request, [
            'nombre' => 'required',
            'stock' => 'required',
            'desc' => 'required',
            'precio' => 'required',
            'categoria' => 'required'            
        ]);

        $categoria = ($request->has('categoria')) ? Categoria::find($request['categoria']) : null;
        $artista = ($request->has('artista')) ? Artista::find($request['artista']) : null;
        $tipo = ($request->has('tipo')) ? Tipo::find($request['tipo']) : null;

        $materiales = $request['materiales'];

        $preview = (bool) $request['preview'];

        try {
            $producto = new Producto;
            $nombre = $request['nombre'];
            $producto->nombre = $nombre;
            $producto->categoria()->associate($categoria);
            $producto->publicado = ($request->has('publicado')) ? true : false;
            $slug = Str::slug($nombre);
            $producto->slug = $this->getUniqueSlug($producto, $slug);
            $producto->img = ($request->hasFile('img')) ?
                    $this->uploadImage($request->file('img'), $producto->slug, 'products') : null;

            $producto->desc = $request['desc'];
            $producto->desc_corta = $request['desc_corta'];
            $producto->precio = $request['precio'];
            $producto->sku = $request['sku'];
            $producto->stock = $request['stock'];
            $producto->peso = $request['peso'];
            $producto->tamano = $request['tamano'];
            $producto->precio = $request['precio'];
            $producto->otros_detalles = $request['otros_detalles'];
            $producto->dsct_lista_regalo = $request['dsct_lista_regalo'] ? $request['dsct_lista_regalo'] : 0.00;

            $producto->color = ($request['producto_colores']) ? json_encode(json_decode($request['producto_colores'])) : '';

            $producto->artista()->associate($artista);
            $producto->tipo()->associate($tipo);

            if ($preview) {
                $producto->galeria_img = ($request->hasFile('images')) ?
                    json_encode($this->uploadImages($request->file('images'), 'temp_'.time(), 'products')) : null;
                $producto->galeria_img = json_decode($producto->galeria_img);
                $producto->galeria_img = is_null($producto->galeria_img) ? [] : $producto->galeria_img;

                $producto->color = isset($product->color) ? $product->color : [];
                $products_like = [];

                return view('producto', ['product' => $producto, 'products_like' =>  $products_like]);
            }

            $producto->save();

            $id = $producto->id;

            $producto->galeria_img = ($request->hasFile('images')) ?
                    json_encode($this->uploadImages($request->file('images'), $id, 'products')) : null;

            $producto->save();

            if ($producto->id) {

                if (!empty($materiales)) {
                    foreach ($materiales as $material) {
                        DB::table('producto_material')->insert([
                            ['producto_id' => $producto->id, 'material_id' => $material ]
                        ]);
                    }
                }
            }

            session()->flash('message', ['type' => 'success', 'message' => 'Producto creado.']);

        } catch (\Exception $e) {
            \Log::error($e);
            session()->flash('message', ['type' => 'danger', 'message' => 'Error al guardar el producto.']);
        }

        return redirect()->route('admin.product.edit', $producto->id);
    }

    public function saveGallery(Request $request, $id)
    {

      $producto = Producto::findOrFail($id);

      if ($request->hasFile('images')) {
          $new_images = $this->uploadImages($request->file('images'), $id, 'products');
          $slides = !is_null($producto->galeria_img) ? json_decode($producto->galeria_img) : [];
          $new_slides = array_merge($slides, $new_images);
          $producto->galeria_img = json_encode($new_slides);
      }

      $producto->save();
      session()->flash('message', ['type' => 'success', 'message' => 'Galeria Actualizada.']);
      return redirect()->route('admin.product.edit', $producto->id);

    }

    public function updateGalleryPosition(Request $request, $id)
    {
        $new_position = $request->get('data');
        if(!is_null($new_position)) {
            $producto = Producto::findOrFail($id);
            $producto->galeria_img = json_encode($new_position);
            $producto->save();
        }
        return response()->json(['success'=>true]);

    }

    public function deleteGalleryImage(Request $request, $id)
    {

        $slug = $request['slug'];
        $producto = Producto::where('slug', '=', $slug)->first();

        $gallery = json_decode($producto->galeria_img, true);

        foreach ($gallery as $key => $item) {
            if ($item == $id) {
                array_splice($gallery, $key, 1);
            }
        }

        $producto->galeria_img = json_encode($gallery);
        $producto->save();

        $path = 'uploads/products/shop/';
        $bool = \File::delete( $path.$id );


        if ($bool) {
            session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
        }
        return redirect()->route('admin.product.edit', $producto->id);
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

        $this->validate($request, [
            'nombre' => 'required',
            'stock' => 'required',
            'desc' => 'required',
            'precio' => 'required',
            'categoria' => 'required'
        ]);

        $artista = ($request->has('artista')) ? Artista::find($request['artista']) : null;
        $tipo = ($request->has('tipo')) ? Tipo::find($request['tipo']) : null;

        $preview = (bool) $request['preview'];
        $producto = Producto::findOrFail($id);

        try {
            
            $categoria = ($request->has('categoria')) ? Categoria::find($request['categoria']) : null;

            $materiales = $request['materiales'];

            $producto->color = ($request['producto_colores']) ? json_encode(json_decode($request['producto_colores'])) : '';

            $producto->categoria()->dissociate();
            $producto->categoria()->associate($categoria);

            $data = $request->except('img', 'galeria_img');

            $producto->nombre = $request['nombre'];

            $producto->publicado = ($request->has('publicado')) ? true : false;

            $slug = Str::slug($request['nombre']);
            $slug = $this->getUniqueSlug($producto, $slug);

            if (!$this->sameSlug($producto, $slug)) {
                $producto->slug = $this->getUniqueSlug($producto, $slug);
                $slug = $producto->slug;
            }

            if ($request->hasFile('img')) {
                $producto->deleteImages();
                $producto->img = $this->uploadImage($request->file('img'), $slug, 'products');
            }

            $producto->desc = $request['desc'];
            $producto->desc_corta = $request['desc_corta'];
            $producto->precio = $request['precio'];
            $producto->sku = $request['sku'];
            $producto->stock = $request['stock'];
            $producto->peso = $request['peso'];
            $producto->tamano = $request['tamano'];
            $producto->precio = $request['precio'];
            $producto->otros_detalles = $request['otros_detalles'];

            //$producto->dsct_lista_regalo = $request['dsct_lista_regalo'];

            $producto->artista()->dissociate();
            $producto->tipo()->dissociate();

            $producto->artista()->associate($artista);
            $producto->tipo()->associate($tipo);

            if ($request->hasFile('images')) {
                $new_images = $this->uploadImages($request->file('images'), $id, 'products');
                $slides = !is_null($producto->galeria_img) ? json_decode($producto->galeria_img) : [];
                $new_slides = array_merge($slides, $new_images);
                $producto->galeria_img = json_encode($new_slides);
            }

            if ($preview) {
                $producto->galeria_img = json_decode($producto->galeria_img);
                $producto->galeria_img = is_null($producto->galeria_img) ? [] : $producto->galeria_img;

                $producto->color = isset($product->color) ? $product->color : [];
                $products_like = [];

                return view('producto', ['product' => $producto, 'products_like' => $products_like ]);
            }

            if ($producto->id) {
                DB::table('producto_material')->where('producto_id', $producto->id)->delete();

                if (!empty($materiales)) {
                    foreach ($materiales as $material) {
                        DB::table('producto_material')->insert([
                            ['producto_id' => $producto->id, 'material_id' => $material ]
                        ]);
                    }
                }
            }

            $producto->save();

            session()->flash('message', ['type' => 'success', 'message' => 'Producto actualizado.']);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            
            session()->flash('message', ['type' => 'danger', 'message' => 'Error al actualizar el producto.']);
        }

        return redirect()->route('admin.product.edit', $producto->id);
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
            $producto = Producto::findOrFail($id);
            $producto->delete();
            $producto->deleteImages();
            $producto->deleteGalleryImages();
            $artwork = Obra::where('disponible_tienda', $producto->id)->first();
            if(!is_null($artwork))
            {
                $artwork->disponible_tienda = 'ninguno';
                $artwork->save();
            }

            session()->flash('message', ['type' => 'success', 'message' => 'Producto eliminado.']);

        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', ['type' => 'danger', 'message' => 'Error al eliminar producto.']);
            }
        }

        return redirect()->back();
    }

    public static function devolverStock($id_producto, $cantidad,$itemcancel)
    {
        $producto = Producto::find($id_producto);
        $producto->stock = $producto->stock + $cantidad;
        if ($itemcancel!=null) {
            $item=json_decode($producto->color,true);
            $data=array_merge([$itemcancel],$item);
            foreach($data as $k => $array)
                $counts[$array['color']][] = $array['stock'];
            $counts = array_map('array_sum', $counts);
            foreach($data as $k => $array)
                $data[$k]['stock'] = $counts[$array['color']];

            $data = array_unique($data,SORT_REGULAR);
            $i=0;
            $res=[];
            foreach ($data as $key => $value) {
                // echo $key; var_dump($value);
                 $res[$i]=$value;
                 $i++;
            }
            $producto->color=json_encode($res);
        }
      $producto->save();
    }

    public function duplicate($id)
    {
        $original = Producto::findOrFail($id);
        
        $duplicated_product = new Producto;
        $duplicated_product = $original->replicate();

        $slug = Str::slug($original->nombre);
        $slug = $this->getUniqueSlug($duplicated_product, $slug);
        
        $checkForSoftDeletes = Producto::where('slug', $slug)->withTrashed()->first();

        if($checkForSoftDeletes) 
        {
            $checkForSoftDeletes->deleteImages();
            $checkForSoftDeletes->deleteGalleryImages();
            $img = $checkForSoftDeletes->duplicateImages($original);
            $galeria_img = $checkForSoftDeletes->duplicateGalleryImages($original);
            $checkForSoftDeletes->img = $img;
            $checkForSoftDeletes->galeria_img = $galeria_img;
            $checkForSoftDeletes->deleted_at = null;
            $checkForSoftDeletes->precio = 0.00;
            $checkForSoftDeletes->stock = 0;
            $checkForSoftDeletes->save();
        } else {
            $duplicated_product->precio = 0.00;
            $duplicated_product->stock = 0;
            $duplicated_product->save();
            $img = $duplicated_product->duplicateImages($original);
            $galeria_img = $duplicated_product->duplicateGalleryImages($original);
            $duplicated_product->slug = $slug;
            $duplicated_product->img = $img;
            $duplicated_product->galeria_img = $galeria_img;
            $duplicated_product->save();
        }

        session()->flash('message', ['type' => 'success', 'message' => 'Producto duplicado.']);

        return redirect()->route('admin.products');
    }
}
