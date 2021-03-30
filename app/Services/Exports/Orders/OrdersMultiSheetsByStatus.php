<?php
namespace App\Services\Exports\Orders;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Exports\GenericSingleSheet;


class OrdersMultiSheetsByStatus implements WithMultipleSheets
{
    use Exportable;

    private $names;
    private $headers;
    private $values;
    private $sheets;
    
    public function __construct(array $names, array $headers, array $values)
    {
        $this->names = $names;
        $this->headers  = $headers;
        $this->values = $values;
        $this->sheets = count($values);
    }

    /**
     * @return array
     */
   public function sheets(): array
    {
        $sheets = [];
        foreach ($this->values as $key => $val) {
            // foreach ($val as $v) {
                    $sheets[] = new GenericSingleSheet(
                        $key, 
                        $this->headers, 
                        $val, 
                        $key
                    );
            // }    
        }
        return $sheets;
    }
}