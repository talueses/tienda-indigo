<?php

namespace App;
use App\Obra;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
		protected $table = "artistas";

		protected $fillable = ['nombres', 'apellidos', 'img', 'bio', 'pais', 'ciudad', 'telefono', 'slug', 'otros', 'img_portada', 'publicado', 'estudios', 'muestras_premios'];

    public function obras()
    {
    	return $this->hasMany(Obra::class);
    }

    public function productos()
    {
    	return $this->hasMany(Producto::class);
    }

    public function deleteImages()
    {
        $imagepath = "uploads/artists/";

        if ($this->img) {
            \File::delete( $imagepath.'80x80_'.$this->img );
            \File::delete( $imagepath.'200x200_'.$this->img );
            \File::delete( $imagepath.$this->img );
        }
    }

    public function deleteCoverImage()
    {
        $imagepath = "uploads/artists/";

        if ($this->img_portada) {
            \File::delete( $imagepath.$this->img_portada );
        }
    }

    public function updatedAt()
    {
        $dt = $this->updated_at->toDateTimeString();
        return Carbon::parse($dt)->diffForHumans();
    }
}
