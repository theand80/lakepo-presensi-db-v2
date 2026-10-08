<?php

namespace App\Exports;

use App\Models\DataAbsen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Columns\Number;

use Maatwebsite\Excel\Concerns\WithColumns;

class downloadPresensiRekapByKantorExcelExport implements FromCollection,  WithColumns
{
    public function collection(): Collection
    {
        return DataAbsen::all();
    }
}
