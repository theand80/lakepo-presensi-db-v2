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
    // public function collection(): Collection
    // {
    //     return DataAbsen::all();
    // }

    protected $namaKantor, $month;

    public function __construct($namaKantor, $month)
    {
        // dd($namaKantor, $month);
        $this->namaKantor = $namaKantor; //"Kecamatan Mpunda"
        $this->month = $month; //"2026-08"
    }

    public function collection(): Collection
    {
        $data = DataAbsen::query()
            ->where('unor_simpegnas', $this->namaKantor)
            ->where('date', 'like', $this->month . '%')
            // ->orderBy('date', 'asc')
            // ->orderBy('nama', 'asc')
            ->get()
            ->values()
            ->map(function ($item, $index) {
                $item->nomor = $index + 1;

                return $item;
            });

        return $data;

    }

    //  ambil isi
    public function columns(): array
    {
        return [
            Number::make('No', 'nomor'),
            Text::make('Nama', 'nama'),
            Text::make('NIP', 'nip'),
            Text::make('Tanggal', 'date'),
            // text::make('PANGKAT', 'pangkat'),
            // text::make('GOL', 'golongan'),
            // text::make('STATUS', 'status'),
            // text::make('JABATAN', 'jabatan'),
            text::make('Unor di Simpegnas', 'unor_simpegnas'),
            // text::make('Unor di Simpegnas', 'unor_simpegnas'),
        ];
    }
}
