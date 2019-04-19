<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 07/08/18
 * Time: 16:22
 */

namespace App\maguttiCms\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollectionExport implements FromCollection, WithHeadings
{
    use Exportable;

    function __construct($data)
    {
        $this->data =$data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Attualmente non usato
     * solo per promemoria
     * @return array
     */
    public function headings(): array
    {
        return [];
    }

}

