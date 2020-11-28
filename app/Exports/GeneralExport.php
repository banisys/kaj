<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class GeneralExport implements FromCollection
{
    protected $__collection;
    
    public function __construct($collection)
    {
        $this->__collection = $collection;
    }
    
    public function collection()
    {
        return $this->__collection;
    }
}
