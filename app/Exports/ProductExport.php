<?php

namespace App\Exports;

use App\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Producto::select('nombre','publicado','desc','sku','color', 'stock')->get();
        //return Producto::all();
    }
}
