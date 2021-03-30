<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    protected $fillable = ['img', 'contenido', 'video'];
    protected $table = "paginas";
}
