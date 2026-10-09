<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Kehadiran ASN</title>
    <style>
        @page {
            size: 330mm 215mm;
            margin: 6mm 5mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 6pt;
            line-height: 1.2;
            margin: 2mm;
            margin-top: 6mm;
        }
        .kop {
            margin-bottom: 3mm;
            text-align: left;
        }
        .kop .title {
            font-weight: bold;
            font-size: 7pt;
            text-transform: uppercase;
            text-align: center;
        }
        .kop .kantor {
            font-size: 7pt;
            text-transform: uppercase;
            text-align: center;
        }
        .kop .row {
            margin-top: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        thead {
            display: table-header-group;
        }
        th, td {
            border: 0.25pt solid #000;
            padding: 1pt 1.5pt;
            vertical-align: top;
        }
        th {
            background: #f3f4f6;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        td {
            text-align: left;
        }
        .center {
            text-align: center;
        }
        .nowrap {
            white-space: nowrap;
        }

        .titlePersentase{
            width: 14mm;
            border-right: 0.25pt solid #000;
        }
        .colPersentase{
            /* max-width: 4mm; */
            /* white-space: nowrap; */
        }
        .truncate {
            max-width: 50mm;
            word-wrap: break-word;
        }
        .jabatan {
            max-width: 60mm;
            word-wrap: break-word;
        }
        .nama {
            max-width: 40mm;
            word-wrap: break-word;
        }
        .nip {
            white-space: nowrap;
        }
        .empty {
            text-align: center;
            padding: 5mm;
        }
        .footer-info {
            margin-top: 2mm;
            font-size: 5pt;
            color: #333;
        }

        .ttd{
            text-align: center;
            width: 20em;
            margin-left: 70%;
            margin-top: 3em;
        }

        .ttd .ttdNama{
            margin-top: 15mm;
        }

        .tabelKet {
            margin-left: 8mm;
            width: 30em;
        }

        .tabelKetTabel th,
        .tabelKetTabel td {
            border: none;
        }

        .tabelKet tr {
            width: 10em;
        }
    </style>
</head>
<body>
    <div class="kop">
        <div class="title">Rekapitulasi Kehadiran ASN</div>
        <div class="kantor">{{ $opd }}</div>
        <div class="row">Periode bulan {{ $bln }} tahun {{ $thn }}</div>
        <div class="row">Tanggal cetak: {{ date('d/m/Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Pangkat/Golongan</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>H</th>
                <th>HN</th>
                <th>DL</th>
                <th>TB</th>
                <th>CT</th>
                <th>CM</th>
                <th>CB</th>
                <th>CS</th>
                <th>CAP</th>
                <th>CTLN</th>
                <th>CH</th>
                <th>TK</th>
                <th>TAS</th>
                <th>TL1</th>
                <th>TL2</th>
                <th>TL3</th>
                <th>TL4</th>
                <th>PSW1</th>
                <th>PSW2</th>
                <th>PSW3</th>
                <th>PSW4</th>
                <th>TAK</th>
                <th class="titlePersentase">Persentase Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="center nowrap">{{ $loop->iteration }}</td>
                    <td class="nip">{{ $item['nip'] }}</td>
                    <td class="nama">{{ $item['nama'] }}</td>
                    <td class="nowrap">
                        {{ $item['pangkat'] == '' ? ($item['golongan'] ?? '-') : ($item['golongan'] ?? '').' - '.($item['pangkat'] ?? '') }}
                    </td>
                    <td class="jabatan">{{ \Illuminate\Support\Str::limit($item['jabatan'] ?? '', 80, '...') }}</td>
                    <td class="center nowrap">{{ $item['status'] ?? '-' }}</td>
                    <td class="center nowrap">{{ $item['hadir'] ?? '-' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['HN'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['DL'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TB'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CT'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CM'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CB'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CS'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CAP'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CTLN'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['CH'] ?? '0' }}</td>
                    <td class="center nowrap text-red-600">{{ $item['rekap']['TK'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TAS'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TL1'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TL2'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TL3'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TL4'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['PSW1'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['PSW2'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['PSW3'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['PSW4'] ?? '0' }}</td>
                    <td class="center nowrap">{{ $item['rekap']['TAK'] ?? '0' }}</td>
                    <td class="center nowrap">
                        @if (!isset($item['persentase']) || $item['persentase'] === '')
                            <span>N/a %</span>
                        @elseif ($item['persentase'] < 50)
                            <span style="color: #dc2626;">{{ $item['persentase'] }}%</span>
                        @elseif ($item['persentase'] < 75)
                            <span style="color: #d97706;">{{ $item['persentase'] }}%</span>
                        @else
                            <span style="color: #059669;">{{ $item['persentase'] }}%</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="29" class="empty">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd">
        <div>{{ $sebagai }},</div>
        <h4 class="ttdNama">{{ $namaPenTtd }}</h4>
        <hr>
        <div>{{ $pangkatGol }}</div>
        <div>Nip. {{ $nipPenTtd }}</div>
    </div>

    <div>
        <h3>Ket:</h3>
        <div class="tabelKet">
            <table class="tabelKetTabel">
                <tbody>
                    <tr><td>HN</td><td>:</td><td>Hadir Normal</td></tr>
                    <tr><td>DL</td><td>:</td><td>Dinas Luar</td></tr>
                    <tr><td>TB</td><td>:</td><td>Tugas Belajar</td></tr>
                    <tr><td>CT</td><td>:</td><td>Cuti</td></tr>
                    <tr><td>CAP</td><td>:</td><td>Cuti</td></tr>
                    <tr><td>CLTN</td><td>:</td><td>Cuti Luar Tanggungan Negara</td></tr>
                    <tr><td>CH</td><td>:</td><td>Cuti Haji</td></tr>
                    <tr><td>TK</td><td>:</td><td>Tanpa Keterangan</td></tr>
                    <tr><td>TAS</td><td>:</td><td>Tidak Absen Siang</td></tr>
                    <tr><td>TL1, 2, 3, 4</td><td>:</td><td>Terlambat Kategori 1, 2, 3, 4</td></tr>
                    <tr><td>TL1, 2, 3, 4</td><td>:</td><td>Terlambat Kategori 1, 2, 3, 4</td></tr>
                    <tr><td>PSW1, 2, 3, 4</td><td>:</td><td>Pulang Sebelum Waktu Kategori 1, 2, 3, 4</td></tr>
                    <tr><td>TAK</td><td>:</td><td>Tidak Ada Keterangan</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
