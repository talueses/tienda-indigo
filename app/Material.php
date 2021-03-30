<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = "materiales";

    protected $fillable = ['nombre', 'desc'];

    public $timestamps = false;

    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_material');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_material');
    }
}
