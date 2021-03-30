<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $table = "departamentos";
    protected $fillable = ['nombre', 'pais_id'];

    public function pais()
    {
      return $this->hasOne(Pais::class, 'id', 'pais_id');
    }

    public function distritos()
    {
      return $this->hasMany(Distritos::class, 'departamento_id', 'id');
    }
}
