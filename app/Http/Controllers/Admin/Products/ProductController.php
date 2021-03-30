<?php
namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\Producto;
use App\Artista;
use App\Descuentos;
use App\Tipo;
use App\Categoria;
use App\Material;
use App\ObraMaterial;
use App\Http\Controllers\Traits\Item;
use App\Services\Exports\GenericSingleSheet;


class ProductController extends Controller
{
	//private $productService;

	public function __construct(/*ProductService $productService*/)
	{
		//$this->productService = $productService;
	}

	public function index() 
	{
				$productos = Producto::leftjoin('descuentos','descuentos.id','productos.descuento_id')
								->with('artista')
								->select('productos.*', 'descuentos.descuento')
								->orderBy('id', 'DESC')
								->get();
				return view('admin.tienda.productos.index')->with('productos', $productos);
	}

	public function edit($id)
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
        /*$categorias = $this->categoryService->listCategories('name', 'asc')->toTree();*/

        $categorias = Categoria::select('id', 'nombre')
                ->getQuery()
                ->get();

        //Materials
        $materiales = Material::select('id', 'nombre')
                ->getQuery()
                ->get();

				$producto = Producto::where('id', $id)->with('materiales')->first();

				if (!is_null($producto))
				{
							$materiales_seleccionados = $producto->materiales()->get();

							$producto->galeria_img = ($producto->galeria_img) ? json_decode($producto->galeria_img) : [];

							$producto->color = ($producto->color) ? json_decode($producto->color) : [];
							$updated_at = $producto->updatedAt();

							return view('admin.tienda.productos.edit', compact(
								'producto',
								'artistas',
								'tipos',
								'categorias',
								'materiales',
								'materiales_seleccionados',
								'updated_at')
						);
				}

				session()->flash('message', ['type' => 'danger', 'message' => 'Producto no existe.']);

				return redirect()->route('admin.products');

    }

		public function export()
    {

				$headers = [ 'SKU', 'Nombre', 'Categoria', 'Stock', 'Descripcion','Tamaño', 'Peso', 'Precio', 'Otros detalles','Descuento lista de regalos', 'Artista', 'Tipo' ];

				$products = Producto::all();

				$results = [];

				foreach ($products as $k => $product) {
					$results[$k]['sku'] = $product->sku;
					$results[$k]['nombre'] = $product->nombre;
					$results[$k]['categoria_id'] = $product->categoria()->first() ? $product->categoria()->first()->nombre : null;
					$results[$k]['stock'] = $product->stock;
					$results[$k]['desc'] = $product->desc;
					$results[$k]['tamano'] = $product->tamano;
					$results[$k]['peso'] = $product->peso;
					$results[$k]['precio'] = $product->precio;
					$results[$k]['otros_detalles'] = $product->otros_detalles;
					$results[$k]['dsc_lista_regalo'] = $product->dsc_lista_regalo ? $product->dsc_lista_regalo : 0;
					$results[$k]['artista_id'] = $product->artista()->first()->nombre;
					$results[$k]['tipo_id'] = $product->tipo()->first() ? $product->tipo()->first()->nombre : null;
				}

				$download_name = 'PRODUCTOS_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';

				return \Excel::download(new GenericSingleSheet('PRODUCTOS', $headers, $results, 'Reporte'), $download_name);


    }

}
