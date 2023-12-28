<?php

namespace App\Exports;

use App\Models\CompanyLinks;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompanyLinksExport implements FromCollection
{

    public function __construct($data){
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }
}
