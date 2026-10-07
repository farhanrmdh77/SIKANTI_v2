<table>
    <thead>
        <tr>
            <th colspan="7" style="font-weight: bold; text-align: center; font-size: 14px;">
                REKAPITULASI DOKUMEN ARSIP
            </th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">
                Gudang Folder: {{ $kategori->nama_kategori }} ({{ $kategori->deskripsi }})
            </th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; margin-bottom: 10px;">
                Subbagian: {{ Auth::user()->subbagian->nama_subbag ?? '-' }}
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">NO</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">KODE KLASIFIKASI</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">NAMA ARSIP</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">TAHUN</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">JUMLAH LEMBAR</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">STATUS RETENSI</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000;">LOKASI FISIK</th>
        </tr>
    </thead>
    <tbody>
        @forelse($arsips as $index => $arsip)
        <tr>
            <td style="text-align: center; border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="text-align: center; border: 1px solid #000;">{{ Auth::user()->subbagian->kode_klasifikasi }}.{{ $arsip->nomor_dokumen }}</td>
            <td style="border: 1px solid #000;">{{ $arsip->nama_arsip }}</td>
            <td style="text-align: center; border: 1px solid #000;">{{ $arsip->tahun_berkas ?? '-' }}</td>
            <td style="text-align: center; border: 1px solid #000;">{{ $arsip->jumlah_berkas }}</td>
            <td style="text-align: center; border: 1px solid #000;">
                @if($arsip->status_retensi == 'Musnah')
                    Telah Musnah
                @elseif($arsip->status_retensi == 'Permanen')
                    Permanen
                @elseif($arsip->status_retensi == 'Inaktif')
                    Inaktif ({{ $arsip->retensi_inaktif }} Thn)
                @elseif($arsip->status_retensi == 'Aktif')
                    Aktif ({{ $arsip->retensi_aktif }} Thn)
                @else
                    Belum Diatur
                @endif
            </td>
            <td style="text-align: center; border: 1px solid #000;">{{ $arsip->lokasi_fisik ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center; border: 1px solid #000;">Tidak ada dokumen yang ditemukan.</td>
        </tr>
        @endforelse
    </tbody>
</table>
