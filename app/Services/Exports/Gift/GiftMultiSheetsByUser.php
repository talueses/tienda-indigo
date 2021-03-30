<?php
namespace App\Services\Exports\Gift;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Exports\GenericSingleSheet;


class GiftMultiSheetsByUser implements WithMultipleSheets
{
    use Exportable;

    private $names;
    private $headers;
    private $values;
    private $sheets;
    private $sheets_titles;
    
    public function __construct(array $names, array $headers, array $values, array $sheets_titles)
    {
        $this->names = $names;
        $this->headers  = $headers;
        $this->values = $values;
        $this->sheets = count($values);
        $this->sheets_titles = $sheets_titles;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        for ($sheet = 0; $sheet < $this->sheets; $sheet++) {
            $sheets[] = new GenericSingleSheet($this->names[$sheet], $this->headers, $this->values[$sheet], $this->sheets_titles[$sheet]);
        }

        return $sheets;
    }

    // return (new OrdersMultiSheetsByStatus($names, $headers, $results, $names))->download($downloadName);
}
