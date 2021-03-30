<?php

namespace App;
use App\Tipo;
use App\Orden;
use App\Material;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    protected $table = "productos";

    protected $fillable = ['nombre', 'publicado', 'stock', 'sku', 'desc', 'desc_corta', 'img', 'galeria_img', 'tamano', 'peso', 'precio', 'categoria', 'producto_colores', 'tamanos'];

    protected $hidden = ['created_at'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function categoria() 
    {
        return $this->belongsTo(Categoria::class);
    }

    public function artista()
    {
    	return $this->belongsTo(Artista::class);
    }

    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'producto_material','producto_id','material_id');
    }

    public function tipo()
    {
    	return $this->belongsTo(Tipo::class);
    }

    public function orden_producto()
    {
    	return $this->belongsToMany('Orden', 'orden_producto');
    }

    public function lista_regalo_producto()
    {
    	return $this->belongsToMany('CuentaNovios', 'lista_regalo_producto');
    }

    public function scopeOrder($query, $o, $r)
    {
        return $o && $r ? $query->orderBy($o,$r) : null;
    }

    public function scopeFilter($query, $f, $v, $r = '=')
    {
        return $f && $v ? $query->where($f,$r,$v) : null;
    }

		public function scopeFilterMaterial($query, $col, $v)
		{
				return $query->join('producto_material', 'producto_material.producto_id', '=', 'productos.id')
								->join('materiales', 'materiales.id', '=', 'producto_material.material_id')
								->select('productos.id','productos.dsct_lista_regalo as dsct' ,'productos.nombre', 'productos.slug', 'productos.img', 'productos.precio', 'productos.categoria_id', 'productos.created_at','productos.descuento_id')
								->where($col, '=', $v);
		}

    public function deleteImages()
    {
        $imagepath = "uploads/products/";

        if ($this->img) {
            \File::delete( $imagepath.'80x80_'.$this->img );
            \File::delete( $imagepath.'200x200_'.$this->img );
            \File::delete( $imagepath.$this->img );
        }

    }

    public function deleteGalleryImages()
    {
        $imagepath = "uploads/products/shop/";

        if ($this->galeria_img) {
            $gallery = json_decode($this->galeria_img, true);

            foreach ($gallery as $image) {
                \File::delete( $imagepath.$image );
            }
        }

    }

    public function duplicateImages($original, $from_art = false) 
    {

        $picture = null;

        $old_path = $from_art ? "uploads/artworks/" : "uploads/products/";

        if($original->img) 
        {
            $oldPath = $old_path.$original->img;
            $newPath = "uploads/products/".$this->id.$original->img;

            if (\File::copy($oldPath , $newPath)) 
            {
                $new_img = \Image::make($oldPath);
                //80x80
                $new_img->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $new_img->save("uploads/products/".'80x80_'.$this->id.$original->img);
            }

            $picture = $this->id.$original->img;
                
        }

        return $picture;

    }

    public function duplicateGalleryImages($original, $from_art = false) 
    {
        $picture = null;
        $old_path = $from_art ? "uploads/artworks/shop/" : "uploads/products/shop/";

        $gallery = !is_null($original->galeria_img) ? json_decode($original->galeria_img, true) : [];
                
        if(count($gallery) >= 1 && !is_null($gallery))  
        {
            $filenames = [];

            foreach ($gallery as $image) 
            {
                $oldPath = $old_path.$image;
                $newPath = "uploads/products/shop/".$this->id.$image;
    
                if (\File::copy($oldPath , $newPath)) 
                {    
                    $new_img = \Image::make($oldPath);
                    //80x80
                    $new_img->resize(160, 160, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $new_img->save("uploads/products/shop/".'80x80_'.$this->id.$image);
                    $filenames[] = $this->id.$image;
                }
            }
            
            $picture = json_encode($filenames);
            
        }

        return $picture;
    }

    public function updatedAt()
    {
        $dt = $this->updated_at->toDateTimeString();
        return Carbon::parse($dt)->diffForHumans();
    }

}
