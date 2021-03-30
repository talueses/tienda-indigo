<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Descuentos extends Model
{
    protected $table = "descuentos";
     
    protected $fillable = ['descuento', 'fecha_inicio', 'fecha_fin','created_at','user_id'];

    public function updateDescuentos($fecha)
    {	
    	$query="update 
					productos p, descuentos  d 
				set 
					d.aplicado=1,p.dsct_lista_regalo=d.descuento
				where
					p.descuento_id =d.id
					and d.fecha_inicio='$fecha'
					and d.aplicado is null";
		$queryF="update 
					productos p, descuentos d
				set 
					d.procesado=1 , p.descuento_id=null ,p.dsct_lista_regalo=null
				where 
					p.descuento_id =d.id 
					and d.fecha_fin='$fecha'
					and d.aplicado = 1
					and d.procesado is null";
	 	DB::statement($query);
    	DB::statement($queryF);
	}
	
	public function cancelarDescuento($id){
	$query="update 
		productos p, descuentos d
	set 		
		d.procesado=1 , p.descuento_id=NULL ,p.dsct_lista_regalo=NULL
	where 
		p.descuento_id =d.id 
		and p.id=$id";
		DB::statement($query);
	}

}
