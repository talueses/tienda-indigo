<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ListaRegalo extends Authenticatable
{
    protected $table = "lista_regalo";

    protected $fillable = ['email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function productos()
    {
    	return $this->belongsToMany(Producto::class, 'lista_regalo_producto', 'lista_regalos_id');
    }

    public function cuentaRegalo()
    {
        return $this->hasOne(CuentaRegalos::class, 'id', 'cuenta_regalos_id');
    }

    public function generateCode()
    {
      $string_name = substr(trim($this->organizador_uno),0,1).substr(trim($this->organizador_dos),0,1);
      
      $code = "COD".$this->id.$string_name.strftime('%d%m%g',strtotime($this->fecha)).substr(trim($this->titulo),0,1);
      
      return strtoupper($code);
    }

    public function getState($str = '')
    {
        $state = [
          "id" => "desconocido",
          "msg" => "Desconocido"
        ];

        if ( $this->edicion_finalizada) {
            if ($this->costo_envio)
            {
              $state = [
                "id" => "finalizado",
                "msg" => "Finalizada"
              ];
            }
      
            if ($this->entrega == 'recojo_tienda')
            {
              $state = [
                "id" => "finalizado",
                "msg" => "Finalizada"
              ];
            }
      
            if ($this->entrega == 'delivery' &&  $this->departamento == 'lima_metropolitana') 
            {
              $state = [
                "id" => "finalizado",
                "msg" => "Finalizada"
              ];
            }


            if (!$this->costo_envio && $this->entrega == 'delivery' &&  $this->departamento != 'lima_metropolitana')
            { 
              $state = [
                "id" => "finalizado",
                "msg" => "Calculando costo de envio"
              ];
            }
          }

        if (!$this->edicion_finalizada) {
          $state = [
            "id" => "edicion",
            "msg" => "Lista en edición"
          ];
        }

        if ($str == "format") {
          return $state["msg"];
        } else {
          return $state["id"];
        }

    }

    public function getBadge()
    {

      $badge = "badge-light";

      if ( $this->edicion_finalizada) {
        if($this->costo_envio)
        {
          $badge = "badge-success";
        }
        if ($this->entrega == 'recojo_tienda')
        {
          $badge = "badge-success";
        }
        if ($this->entrega == 'delivery' &&  $this->departamento == 'lima_metropolitana') 
        {
          $badge = "badge-success";
        }
        if (!$this->costo_envio && $this->entrega == 'delivery' &&  $this->departamento != 'lima_metropolitana')
        {
          $badge = "badge-info";
        }  
      }

      if (!$this->edicion_finalizada) {
        return "badge-warning";
      }

      return $badge;

    }


    public function deleteImage()
    {
        $imagepath = "uploads/giftregistry/";

        if ($this->img) {
            return \File::delete( $imagepath.$this->img );
        }
    }

}
