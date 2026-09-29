<?php

namespace App\Imports;

use App\Models\DataAsn;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UpdateDataAsnImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {

            $nip = trim($row['nip'] ?? '');
            $unor_simpegnas = trim($row['unit_kerja_simpegnas'] ?? '');

            if ($nip === '' || $unor_simpegnas === '') {
                continue;
            }

            DataAsn::where('nip', $nip)
                ->update([
                    'unor_simpegnas' => $unor_simpegnas,
                    'updated_at' => now(),
                ]);
        }
    }
}
