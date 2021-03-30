<?php

namespace App;
use App\Obra;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "categorias";

    protected $fillable = ['nombre', 'desc'];

    public $timestamps = false;

    public function obras()
    {
    	return $this->hasMany(Obra::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
