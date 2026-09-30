<?php

namespace App\Exports;

use App\Models\DataAsn;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataAsnExport implements FromCollection,  WithColumns, WithStyles
{
    public function collection(): Collection
    {
        $namaKantor = 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia';
        return DataAsn::where('unor_siasn_induk', $namaKantor)->get()
        // tambah nomor
        ->values()
        ->map(function ($item, $index) {
            $item->nomor = $index + 1;
            return $item;
        });
        // return DataAsn::all();
    }

    //  ambil isi
    public function columns(): array
    {
        return [
            Number::make('No', 'nomor'),
            Text::make('Nama', 'nama'),
            Text::make('NIP', 'nip'),
            text::make('PANGKAT', 'pangkat'),
            text::make('GOL', 'golongan'),
            text::make('STATUS', 'status'),
            text::make('JABATAN', 'jabatan'),
            text::make('Unor di SIASN', 'unor_siasn_induk'),
            text::make('Unor di Simpegnas', 'unor_simpegnas'),
        ];
    }


    // setingan untuk header dan kolom
    public function styles(Worksheet $sheet): array
    {
        // isi kolom B jadi rata tengah
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');

        // lebar kolom A sampai E mengikuti panjang teks
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Lebar kolom satu per satu
        // $sheet->getColumnDimension('A')->setAutoSize(true);
        // $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setAutoSize(true);

        // A sampai F ingin dibuat lebar yang sama:
        // foreach (range('A', 'F') as $column) {
        //     $sheet->getColumnDimension($column)->setWidth(20);
        // }

        

        return [
            // Style the first row as bold text.
            1    => [
                        'font' => [
                            'bold' => true, 
                            'size' => 14, 
                            'color' => ['rgb' => 'FFFFFF']
                            ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '4fc2fe',
                            ],
                        ],
                        'alignment' => [
                            'horizontal' => 'center',
                            'vertical' => 'center',
                            'wrapText' => true,
                            ],
                        // 'borders' => [
                        //     'top' => [
                        //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        //         'color' => ['rgb' => 'C00000'],
                        //     ],
                        //     'bottom' => [
                        //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        //         'color' => ['rgb' => 'C00000'],
                        //     ],
                        //     'left' => [
                        //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        //         'color' => ['rgb' => 'C00000'],
                        //     ],
                        //     'right' => [
                        //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        //         'color' => ['rgb' => 'C00000'],
                        //     ],
                        // ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '026dbe'],
                            ],
                        ],
                    ],
                    
        ];
    }

    

    // public function headings(): array
    // {
    //     return [
    //         'NO',
    //         'NIP',
    //         'NAMA',
    //         'PANGKAT',
    //         'GOLONGAN',
    //         'STATUS',
    //         'JABATAN',
    //         'UNIT KERJA',
    //     ];
    // }
}
