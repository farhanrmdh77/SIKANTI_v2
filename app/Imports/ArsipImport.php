<?php

namespace App\Imports;

use App\Arsip;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ArsipImport extends DefaultValueBinder implements ToModel, WithHeadingRow, WithCustomValueBinder
{
    protected $kategori_id;
    protected $subbag_id;
    protected $user_id;

    public function __construct($kategori_id, $subbag_id, $user_id)
    {
        $this->kategori_id = $kategori_id;
        $this->subbag_id = $subbag_id;
        $this->user_id = $user_id;
    }

    public function bindValue(Cell $cell, $value)
    {
        // Jika value numeric atau kelihatan seperti date/time di Excel, 
        // kita paksa jadi string agar format seperti 02.02 tidak hancur
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // Kalau text biasa, jalankan default binder
        return parent::bindValue($cell, $value);
    }

    public function model(array $row)
    {
        // Skip empty rows (assuming if nama_arsip is empty, we skip)
        if (!isset($row['nama_arsip']) || trim($row['nama_arsip']) === '') {
            return null;
        }

        // Mapping Nasib Akhir
        $nasibAkhir = null;
        if (!empty($row['nasib_akhir'])) {
            $n = strtolower(trim($row['nasib_akhir']));
            if (strpos($n, 'musnah') !== false) $nasibAkhir = 'Musnah';
            elseif (strpos($n, 'permanen') !== false) $nasibAkhir = 'Permanen';
            elseif (strpos($n, 'dinilai') !== false) $nasibAkhir = 'Dinilai Kembali';
        }

        // Mapping Lokasi Fisik
        $lokasiFisik = null;
        if (!empty($row['lokasi_fisik'])) {
            $l = strtolower(trim($row['lokasi_fisik']));
            if (strpos($l, 'internal') !== false) $lokasiFisik = 'Internal Subbagian';
            elseif (strpos($l, 'umum') !== false) $lokasiFisik = 'Diserahkan ke Umum';
        }

        $nomorDokumen = $row['nomor_dokumen'] ?? null;
        
        // Memulihkan nomor_dokumen jika Excel mengonversinya menjadi angka desimal/waktu (seperti 02.02 jadi 0.0840277...)
        if (is_numeric($nomorDokumen) && strpos((string)$nomorDokumen, '.') !== false) {
            if ($nomorDokumen > 0 && $nomorDokumen < 1) {
                try {
                    $time = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($nomorDokumen);
                    $nomorDokumen = $time->format('H.i'); // 02.02
                } catch (\Exception $e) {
                    // Biarkan jika gagal
                }
            }
        }

        return new Arsip([
            'kategori_id' => $this->kategori_id,
            'subbag_id' => $this->subbag_id,
            'user_id' => $this->user_id,
            'nomor_dokumen' => $nomorDokumen,
            'nama_arsip' => $row['nama_arsip'],
            'tahun_berkas' => $row['tahun_berkas'] ?? date('Y'),
            'jumlah_berkas' => $row['jumlah_berkas'] ?? 1,
            'retensi_aktif' => $row['retensi_aktif'] ?? null,
            'retensi_inaktif' => $row['retensi_inaktif'] ?? null,
            'nasib_akhir' => $nasibAkhir,
            'lokasi_fisik' => $lokasiFisik,
            'warna_berkas' => $row['warna_berkas'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }
}
