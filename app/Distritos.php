<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distritos extends Model
{
    protected $table = "distritos";
    protected $fillable = ['nombre', 'departamento_id'];

    public function departamento()
    {
      return $this->hasOne(Departamentos::class, 'id', 'departamento_id');
    }
}
