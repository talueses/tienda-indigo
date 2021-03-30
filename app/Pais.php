<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = "paises";

    protected $fillable = ['nombre', 'desc'];

    public function ordenes()
    {
      return $this->belongsToMany('Orden', 'pais');
    }

    public function departamentos()
    {
      return $this->hasMany(Departamentos::class, 'pais_id', 'id');
    }

}
