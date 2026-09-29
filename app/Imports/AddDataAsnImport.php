<?php

namespace App\Imports;

use App\Models\DataAsn;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AddDataAsnImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {

    //     $nip = trim($row['NOMOR INDUK KEPEGAWAIAN'] ?? '');
    //     $nama = trim($row['NAMA'] ?? '');
    //     $pangkat = trim($row['PANGKAT'] ?? '');
    //     $golongan = trim($row['GOL'] ?? '');
    //     $jabatan = trim($row['NAMA JABATAN'] ?? '');
    //     $unor_siasn = trim($row['UNIT KERJA'] ?? '');
    //     $unor_siasn_induk = trim($row['UNIT KERJA INDUK'] ?? '');
    //     $unor_simpegnas_id = trim($row['NAMA JABATAN PENUGASAN STRUKTURAL'] ?? '');
    //     $unor_simpegnas = trim($row['UNIT KERJA PENUGASAN STRUKTURAL'] ?? '');
    //     $foto_simpegnas = trim($row['TMT PENUGASAN STRUKTURAL'] ?? '');


    //     if ($nama === '' || $nip === '' || $unor_siasn_induk === '') {
    //         return null;
    //     }

    //     return new DataAsn([
    //         'nip' => $nip,
    //         'nama' => $nama,
    //         'pangkat' => $pangkat,
    //         'golongan' => $golongan,
    //         'jabatan' => $jabatan,
    //         'unor_siasn' => $unor_siasn,
    //         'unor_siasn_induk' => $unor_siasn_induk,
    //         'unor_simpegnas_id' => $unor_simpegnas_id,
    //         'unor_simpegnas' => $unor_simpegnas,
    //         'foto_simpegnas' => $foto_simpegnas,
    //     ]);
    // }

    // ini kelemahannya karna memanggil create() berkali-kal
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $row) {

    //         $nip = trim($row['NOMOR INDUK KEPEGAWAIAN'] ?? '');
    //         $nama = trim($row['NAMA'] ?? '');
    //         $pangkat = trim($row['PANGKAT'] ?? '');
    //         $golongan = trim($row['GOL'] ?? '');
    //         $jabatan = trim($row['NAMA JABATAN'] ?? '');
    //         $unor_siasn = trim($row['UNIT KERJA'] ?? '');
    //         $unor_siasn_induk = trim($row['UNIT KERJA INDUK'] ?? '');
    //         $unor_simpegnas_id = trim($row['NAMA JABATAN PENUGASAN STRUKTURAL'] ?? '');
    //         $unor_simpegnas = trim($row['UNIT KERJA PENUGASAN STRUKTURAL'] ?? '');
    //         $foto_simpegnas = trim($row['TMT PENUGASAN STRUKTURAL'] ?? '');

    //         if ($nama === '' || $nip === '' || $unor_siasn_induk === '') {
    //             continue;
    //         }

    //         DataAsn::create([
    //             'nip' => $nip,
    //             'nama' => $nama,
    //             'pangkat' => $pangkat,
    //             'golongan' => $golongan,
    //             'jabatan' => $jabatan,
    //             'unor_siasn' => $unor_siasn,
    //             'unor_siasn_induk' => $unor_siasn_induk,
    //             'unor_simpegnas_id' => $unor_simpegnas_id,
    //             'unor_simpegnas' => $unor_simpegnas,
    //             'foto_simpegnas' => $foto_simpegnas,
    //         ]);
    //     }
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
        // dd($rows);
        // dd($this->status);
        // dd($rows->first());

        $data = [];

        foreach ($rows as $row) {

            $nip = trim($row['nomor_induk_kepegawaian'] ?? '');
            $nama = trim($row['nama'] ?? '');
            $unor_siasn_induk = trim($row['unit_kerja_induk'] ?? '');

            if ($nama === '' || $nip === '' || $unor_siasn_induk === '') {
                continue;
            }

            $data[] = [
                'nip' => $nip,
                'nama' => $nama,
                'pangkat' => trim($row['pangkat'] ?? ''),
                'golongan' => trim($row['gol'] ?? ''),
                'status' => trim($this->status ?? ''),
                'jabatan' => trim($row['nama_jabatan'] ?? ''),
                'unor_siasn' => trim($row['unit_kerja'] ?? ''),
                'unor_siasn_induk' => $unor_siasn_induk,
                'unor_simpegnas_id' => trim($row['nama_jabatan_penugasan_struktural'] ?? ''),
                'unor_simpegnas' => trim($row['unit_kerja_penugasan_struktural'] ?? ''),
                'foto_simpegnas' => trim($row['tmt_penugasan_struktural'] ?? ''),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($data)) {
            // dd($data);
            DataAsn::insert($data);
        }
    }

    // public function startRow(): int
    // {
    //     return 6;
    // }
}
