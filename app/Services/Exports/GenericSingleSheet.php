<?php
namespace App\Services\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class GenericSingleSheet implements FromView, WithTitle
{
    private $name;
    private $headers;
    private $values;
    private $sheetTitle;

    public function __construct(string $name, array $headers, array $values, string $sheetTitle)
    {
        $this->name = $name;
        $this->headers  = $headers;
        $this->values = $values;
        $this->sheetTitle = $sheetTitle;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->sheetTitle;
    }

    public function view(): View
    {
        return view('admin.exports.generic', [
            'name' => $this->name,
            'headers' => $this->headers,
            'values' => $this->values
        ]);
    }

    // TO DOWLOAD return \Excel::download(new GenericSingleSheet('PRODUCTOS', $headers, $results), $downloadName);

}