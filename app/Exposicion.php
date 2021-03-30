<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Exposicion extends Model
{
    protected $table = "exposiciones";

    protected $fillable = ['img', 'titulo', 'artista', 'fuente', 'desc', 'publicado', 'hora', 'lugar', 'distrito', 'direccion', 'precio', 'fecha_inicio', 'fecha_fin', 'tags', 'slug'];


    public function deleteImagesEvent()
    {
        $imagepath = "uploads/exhibitions/";

        if ($this->img) {
            \File::delete( $imagepath.'80x80_'.$this->img );
            \File::delete( $imagepath.'200x200_'.$this->img );
            \File::delete( $imagepath.$this->img );
        }
    }

    public function deleteGalleryImagesEvent()
    {
        $imagepath = "uploads/exhibitions/shop/";

        if ($this->galeria_img) {
            $gallery = json_decode($this->galeria_img, true);

            foreach ($gallery as $image) {
                \File::delete( $imagepath.$image );
            }
        }

    }


    public function deleteImagesNote()
    {
        $imagepath = "uploads/notes/";

        if ($this->img) {
            \File::delete( $imagepath.'80x80_'.$this->img );
            \File::delete( $imagepath.'200x200_'.$this->img );
            \File::delete( $imagepath.$this->img );
        }
    }

    public function deleteGalleryImagesNote()
    {
        $imagepath = "uploads/notes/shop/";

        if ($this->galeria_img) {
            $gallery = json_decode($this->galeria_img, true);

            foreach ($gallery as $image) {
                \File::delete( $imagepath.$image );
            }
        }

    }

    public function updatedAt()
    {
        $dt = $this->updated_at->toDateTimeString();
        return Carbon::parse($dt)->diffForHumans();
    }

    public function deleteImage()
    {
        $imagepath = "uploads/exhibitions/";

        if ($this->img) {
            return \File::delete( $imagepath.$this->img );
        }
    }


}
