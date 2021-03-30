<?php
namespace App\Http\Controllers\Traits;
use Carbon\Carbon;
use App\Exposicion;

trait HasCategories {

  	public function categoriesListByMonth($month, $year, $type)
    {
        if (!is_null($this->translateMonth($month))) {
          $month = $this->translateMonth($month);
          $mes = Carbon::parse($month)->month;

          if ($type == 'evento') {
            $items = Exposicion::whereMonth('fecha_inicio', $mes)
                          ->whereYear('fecha_inicio', $year)
                          ->where('publicado', 1)
                          ->where('tipo', 'evento')
                          ->orderBy('fecha_inicio', 'desc')->get();
          } else {
            $items = Exposicion::whereMonth('created_at', $mes)
                        ->whereYear('created_at', $year)
                        ->where('publicado', 1)
                        ->where('tipo', 'nota')
                        ->orderBy('fecha_inicio', 'desc')->get();
          }
        }

        return $items;
    }

    public function translateMonth($month)
    {
        $months = array(
          'enero' => 'january',
          'febrero' => 'february',
          'marzo' => 'march',
          'abril' => 'april',
          'mayo' => 'may',
          'junio' => 'june',
          'julio' => 'july',
          'agosto' => 'august',
          'septiembre' => 'september',
          'setiembre' => 'september',
          'octubre' => 'october',
          'noviembre' => 'november',
          'diciembre' => 'december'
        );

        if(!in_array($month, $months)) {
            return $months[$month];
        }

        return null;
    }

}
