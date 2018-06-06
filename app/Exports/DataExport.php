<?php

namespace App\Exports;
use App\Models\SIIFAC\Venta;

use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    public function collection()
    {
        return Venta::all();
    }
}