<?php

namespace App;

use App\Artista;
use App\Categoria;
use App\Material;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
	protected $table = "obras";

    protected $fillable = ['nombre', 'publicado', 'desc', 'desc_corta', 'img', 'galeria_img', 'tamano', 'peso', 'anio', 'disponible_tienda'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'obra_material', 'obra_id', 'material_id' );
    }

    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'disponible_tienda');
    }

    public function artista()
    {
    	return $this->belongsTo(Artista::class);
    }

    public function scopeFilter($query, $f, $v, $r = '=')
    {
        return $f && $v ? $query->where($f,$r,$v) : null;
    }

    public function deleteImages()
    {
        $imagepath = "uploads/artworks/";

        if ($this->img) {
            \File::delete( $imagepath.'80x80_'.$this->img );
            \File::delete( $imagepath.'200x200_'.$this->img );
            \File::delete( $imagepath.$this->img );
        }
    }

    public function deleteGalleryImages()
    {
        $imagepath = "uploads/artworks/shop/";

        if ($this->galeria_img) {
            $gallery = json_decode($this->galeria_img, true);

            foreach ($gallery as $image) {
                \File::delete( $imagepath.$image );
            }
        }

    }

    public function duplicateImages($original) 
    {

        $picture = null;

        if($original->img) 
        {
            $oldPath = "uploads/artworks/".$original->img;
            $newPath = "uploads/artworks/".$this->id.$original->img;

            if (\File::copy($oldPath , $newPath)) 
            {
                $new_img = \Image::make($oldPath);
                //80x80
                $new_img->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $new_img->save("uploads/artworks/".'80x80_'.$this->id.$original->img);
            }

            $picture = $this->id.$original->img;
                
        }

        return $picture;

    }

    public function duplicateGalleryImages($original)
    {
        $picture = null;
        $gallery = !is_null($original->galeria_img) ? json_decode($original->galeria_img, true) : [];
                
        if(count($gallery) >= 1 && !is_null($gallery))  
        {
            $filenames = [];

            foreach ($gallery as $image) 
            {
                $oldPath = "uploads/artworks/shop/".$image;
                $newPath = "uploads/artworks/shop/".$this->id.$image;
    
                if (\File::copy($oldPath , $newPath)) 
                {    
                    $new_img = \Image::make($oldPath);
                    //80x80
                    $new_img->resize(160, 160, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $new_img->save("uploads/artworks/shop/".'80x80_'.$this->id.$image);
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
