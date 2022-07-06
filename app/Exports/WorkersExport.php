<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkersExport implements FromCollection, WithHeadings
{

    protected $rows;
    protected $headers;

    public function __construct(array $rows, array $headers)
    {
        $this->rows = $rows;
        $this->headers = $headers;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = collect($this->rows);
        return $collection;
    }

    public function headings(): array
    {
        return $this->headers;
    }

}
