<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumns;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class downloadPresensiRekapByKantorExcelExport implements FromCollection, ShouldAutoSize, WithColumns, WithCustomStartCell, WithEvents, WithStyles
{
    use Exportable;

    public function __construct(
        private array $data,
        private string $opd,
        private string $month
    ) {}

    public function startCell(): string
    {
        return 'A3';
    }

    public function collection(): Collection
    {
        return collect($this->data);
    }

    public function columns(): array
    {
        return [
            Text::make('NIP', 'nip'),
            Text::make('Nama', 'nama'),
            Text::make('Pangkat/Golongan', function ($row) {
                $gol = $row['golongan'] ?? '';
                $pang = $row['pangkat'] ?? '';

                if ($gol === '') {
                    return '';
                }

                if ($pang === '') {
                    return $gol;
                }

                return $gol.' - '.$pang;
            }),
            Text::make('Jabatan', 'jabatan'),
            Text::make('Status', 'status'),
            Number::make('H', 'hadir'),
            Number::make('HN', function ($row) {
                return $row['rekap']['HN'] ?? 0;
            }),
            Number::make('DL', function ($row) {
                return $row['rekap']['DL'] ?? 0;
            }),
            Number::make('TB', function ($row) {
                return $row['rekap']['TB'] ?? 0;
            }),
            Number::make('CT', function ($row) {
                return $row['rekap']['CT'] ?? 0;
            }),
            Number::make('CM', function ($row) {
                return $row['rekap']['CM'] ?? 0;
            }),
            Number::make('CB', function ($row) {
                return $row['rekap']['CB'] ?? 0;
            }),
            Number::make('CS', function ($row) {
                return $row['rekap']['CS'] ?? 0;
            }),
            Number::make('CAP', function ($row) {
                return $row['rekap']['CAP'] ?? 0;
            }),
            Number::make('CTLN', function ($row) {
                return $row['rekap']['CTLN'] ?? 0;
            }),
            Number::make('CH', function ($row) {
                return $row['rekap']['CH'] ?? 0;
            }),
            Number::make('TK', function ($row) {
                return $row['rekap']['TK'] ?? 0;
            }),
            Number::make('TAS', function ($row) {
                return $row['rekap']['TAS'] ?? 0;
            }),
            Number::make('TL1', function ($row) {
                return $row['rekap']['TL1'] ?? 0;
            }),
            Number::make('TL2', function ($row) {
                return $row['rekap']['TL2'] ?? 0;
            }),
            Number::make('TL3', function ($row) {
                return $row['rekap']['TL3'] ?? 0;
            }),
            Number::make('TL4', function ($row) {
                return $row['rekap']['TL4'] ?? 0;
            }),
            Number::make('PSW1', function ($row) {
                return $row['rekap']['PSW1'] ?? 0;
            }),
            Number::make('PSW2', function ($row) {
                return $row['rekap']['PSW2'] ?? 0;
            }),
            Number::make('PSW3', function ($row) {
                return $row['rekap']['PSW3'] ?? 0;
            }),
            Number::make('PSW4', function ($row) {
                return $row['rekap']['PSW4'] ?? 0;
            }),
            Number::make('TAK', function ($row) {
                return $row['rekap']['TAK'] ?? 0;
            }),
            Text::make('Persentase Kehadiran', function ($row) {
                $persentase = $row['persentase'] ?? null;

                if ($persentase === null || $persentase === '') {
                    return 'N/a %';
                }

                return $persentase.'%';
            }),
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        $highestColumn = $sheet->getHighestColumn();

        return [
            // Style for header row (row 3)
            3 => [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '4fc2fe',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '026dbe'],
                    ],
                ],
            ],
            // Style for data rows
            'A:'.$highestColumn => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ],
            'A' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'C' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'E:'.$highestColumn => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $bln = substr($this->month, 5, 2);
                $thn = substr($this->month, 0, 4);

                // Write title rows
                $sheet->setCellValue('A1', $this->opd);
                $sheet->setCellValue('A2', 'Periode bulan '.$bln.' tahun '.$thn);

                // Merge title rows
                $sheet->mergeCells('A1:AB1');
                $sheet->mergeCells('A2:AB2');

                // Style title rows
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Set row heights
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(30);
            },
        ];
    }
}
