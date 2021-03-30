<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = "pagos";

    public function orden()
    {
    	return $this->hasOne('Orden');
    }

    public function metodo_pagos()
    {
    	return $this->belongsToMany('MetodoPagos');
    }
}
