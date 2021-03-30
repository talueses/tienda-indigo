<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
	use softDeletes;

	protected $table = "ordenes";

	protected $fillable = ['estado'];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function pais()
	{
		return $this->belongsTo(Pais::class, 'pais_id');
	}

	public function productos()
	{
		return $this->belongsToMany(Producto::class, 'orden_producto');
	}

	public function scopeGetDetail($query, $id)
	{
		return $query->where('id', $id)
				->select('id as orden_id','ruc','razon_social' ,'delivery_at', 'tracking', 'estado', 'entrega', 'pais_id', 'departamento','distrito', 'direccion', 'user_id as usuario', 'costo_envio', 'created_at', 'payed_at', 'cancelled_at', 'refunded_at','card')
				->first();
	}

	public function getOrderBadge()
	{

		$badge = '';

		switch ($this->estado) {
			case "Pagado":
				$badge = 'badge-success';
				break;
			case "Pendiente":
				$badge = 'badge-info';
				break;
			case "Calculando":
				$badge = 'badge-warning';
				break;
			case "Cancelado":
				$badge = 'badge-danger';
				break;
			case "Devolucion":
				$badge = 'badge-warning';
				break;
			case "Entregado":
				$badge = 'badge-success';
				break;
			case "Enviado":
				$badge = 'badge-success';
				break;
			default:
				$badge = '';
		}
		return $badge;

	}

	public function getOrderStatus()
	{
		$status = $this->estado;

		switch ($status) {

			case "Enviado":
				$status_text = 'Producto Enviado';
				break;
			case "Pendiente":
				$status_text = 'Pendiente de pago';
				break;
			case "Calculando":
				$status_text = 'Calculando costo de envio';
				break;
			case 'Cancelado':
				$status_text = 'Cancelado';
				break;
			default:
				$status_text = $status;
		}

		return $status_text;
	}

}
