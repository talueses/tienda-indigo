<?php

namespace App;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
	protected $table = "tipos";

	protected $fillable = ['nombre', 'desc'];

    public $timestamps = false;

    public function productos()
    {
    	return $this->hasMany(Product::class);
    }
}
