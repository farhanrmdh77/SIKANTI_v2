<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Arsip extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subbag_id', 'kategori_id', 'user_id', 
        'nomor_dokumen', 'nama_arsip', 'tahun_berkas', 'jumlah_berkas',
        'retensi_aktif', 'retensi_inaktif', 'nasib_akhir', 'lokasi_fisik',
        'warna_berkas', 'keterangan', 'file_dokumen'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function subbagian()
    {
        return $this->belongsTo(Subbagian::class, 'subbag_id');
    }

    // ========================================================
    // LOGIKA ENTERPRISE: AUTO-CALCULATE JRA (BULAN & TAHUN PRESISI)
    // ========================================================
    public function getStatusRetensiAttribute()
    {
        // 1. Jika data dasar tidak lengkap, kembalikan status aman
        if (empty($this->tahun_berkas) || empty($this->retensi_aktif)) {
            return 'Belum Diatur';
        }

        // 2. Normalisasi teks (Lowercase & hapus spasi berlebih)
        $str = strtolower(trim($this->tahun_berkas));
        $str = preg_replace('/\s+/', ' ', $str);
        $parts = explode(' ', $str);

        // Kamus mapping bulan Indonesia
        $bulanIndo = [
            'januari' => '01', 'jan' => '01',
            'februari' => '02', 'feb' => '02',
            'maret' => '03', 'mar' => '03',
            'april' => '04', 'apr' => '04',
            'mei' => '05', 
            'juni' => '06', 'jun' => '06',
            'juli' => '07', 'jul' => '07',
            'agustus' => '08', 'agu' => '08', 'ags' => '08',
            'september' => '09', 'sep' => '09',
            'oktober' => '10', 'okt' => '10',
            'november' => '11', 'nov' => '11',
            'desember' => '12', 'des' => '12'
        ];

        $bulan = '01'; // Default Januari
        $tahun = date('Y');

        // 3. Deteksi apakah ada nama bulan dalam string
        foreach ($parts as $part) {
            if (isset($bulanIndo[$part])) {
                $bulan = $bulanIndo[$part];
            } elseif (is_numeric($part) && strlen($part) == 4) {
                $tahun = $part;
            }
        }

        try {
            // 4. Kalkulasi presisi dengan Carbon
            $tanggalArsip = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
            $sekarang = Carbon::now();

            // Batas Aktif = Tanggal Arsip + Masa Retensi Aktif
            $batasAktif = $tanggalArsip->copy()->addYears((int)$this->retensi_aktif);
            
            // Batas Inaktif = Batas Aktif + Masa Retensi Inaktif
            $retensiInaktif = (int)($this->retensi_inaktif ?? 0);
            $batasInaktif = $batasAktif->copy()->addYears($retensiInaktif);

            // 5. Keputusan Status Real-Time
            if ($sekarang->lessThan($batasAktif)) {
                return 'Aktif';
            } elseif ($sekarang->greaterThanOrEqualTo($batasAktif) && $sekarang->lessThan($batasInaktif)) {
                return 'Inaktif';
            } else {
                return !empty($this->nasib_akhir) ? $this->nasib_akhir : 'Dinilai Kembali';
            }
        } catch (\Exception $e) {
            return 'Format Salah';
        }
    }
}