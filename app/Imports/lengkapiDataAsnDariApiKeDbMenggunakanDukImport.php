<?php

namespace App\Imports;

use App\Models\AsnDariApi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class lengkapiDataAsnDariApiKeDbMenggunakanDukImport implements ToCollection, WithHeadingRow
{
    // public function model(array $row): Model|null
    // {
    //     return new AsnDariApi([
    //         //
    //     ]);
    // }

    protected $status;

    public function __construct($status)
    {
        $this->status = $status; //PNS PPPK P3K PW
    }

    public function headingRow(): int
    {
        return 6;
    }

    public function collection(Collection $rows): void
    {
        $data = [];
        foreach ($rows as $row) {

            $nip = trim($row['nomor_induk_kepegawaian'] ?? '');
            $nama = trim($row['nama'] ?? '');
            $unor_siasn_induk = trim($row['unit_kerja_induk'] ?? '');

            if ($nama === '' || $nip === '' || $unor_siasn_induk === '') {
                continue;
            }

            AsnDariApi::where('nip', $nip)
                ->update([
                    // 'nama'              => $nama,
                    'pangkat'           => trim($row['pangkat'] ?? ''),
                    'golongan'          => trim($row['gol'] ?? ''),
                    'status'            => trim($this->status ?? ''),
                    'jabatan'           => trim($row['nama_jabatan'] ?? ''),
                    'unor_siasn'        => trim($row['unit_kerja'] ?? ''),
                    'unor_siasn_induk'  => $unor_siasn_induk,
                    'updated_at'        => now(),
                ]);
        }
    }
}
