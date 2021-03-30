<?php

namespace App;
use App\Obra;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = "contacto";

    protected $fillable = ['nombres', 'correo', 'mensaje'];
}
