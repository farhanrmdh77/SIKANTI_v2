<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ArsipTemplateExport implements WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'nomor_dokumen',
            'nama_arsip',
            'tahun_berkas',
            'jumlah_berkas',
            'retensi_aktif',
            'retensi_inaktif',
            'nasib_akhir',
            'lokasi_fisik',
            'warna_berkas',
            'keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
