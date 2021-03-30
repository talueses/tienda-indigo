<?php
namespace App\Services\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenericMultiSheets implements WithMultipleSheets
{
    use Exportable;

    private $names;
    private $headers;
    private $values;
    private $sheets;
    private $sheetsTitle;
    
    public function __construct(array $names, array $headers, array $values, array $sheets_title)
    {
        $this->names = $names;
        $this->headers  = $headers;
        $this->values = $values;
        $this->sheetsTitle = $sheets_title;
        $this->sheets = count($values);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        for ($sheet = 0; $sheet < $this->sheets; $sheet++) {
            $sheets[] = new GenericSingleSheet($this->names[$sheet], $this->headers[$sheet], $this->values[$sheet], $this->sheets_title[$sheet]);
        }

        return $sheets;
    }

    // return (new GenericMultiSheets('REPORTE DE REGISTROS -', $headers, $results))->download('PRODUCTOS_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx');
}
