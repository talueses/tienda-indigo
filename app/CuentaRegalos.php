<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CuentaRegalos extends Authenticatable
{
    protected $table = "cuenta_regalos";

    protected $fillable = ['email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $primaryKey = 'id';

    public function listas()
    {
        return $this->hasMany(ListaRegalo::class, 'cuenta_regalos_id');
    }

    /*public function productos()
    {
    	return $this->belongsToMany(Producto::class, 'lista_regalo_producto');
    }*/

    /*ublic function generateCode()
    {
      $string_name = substr(trim($this->novio),0,1).substr(trim($this->novia),0,1);
      $code = "COD".$this->id.$string_name.strftime('%d%m%g',strtotime($this->fecha));
      $this->codigo = strtoupper($code);
      $this->save();
      return $this->code;
    }

    /*public function deleteImage()
    {
        $imagepath = "uploads/weddinglists/";

        if ($this->img) {
            return \File::delete( $imagepath.$this->img );
        }
    }*/

}
