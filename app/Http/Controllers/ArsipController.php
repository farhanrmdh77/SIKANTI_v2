<?php

namespace App\Http\Controllers;

use App\Arsip;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Imports\ArsipImport;
use App\Exports\ArsipTemplateExport;
use App\Exports\ArsipExport;
use Maatwebsite\Excel\Facades\Excel;

class ArsipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $kategori_id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);
        
        $arsips = Arsip::where('kategori_id', $kategori_id)->latest();

        if ($request->filled('search')) {
            $arsips->where(function($q) use ($request) {
                $q->where('nama_arsip', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status_file')) {
            if ($request->status_file == 'ada') {
                $arsips->whereNotNull('file_dokumen');
            } elseif ($request->status_file == 'tidak') {
                $arsips->whereNull('file_dokumen');
            }
        }

        if ($request->filled('lokasi_fisik')) {
            $arsips->where('lokasi_fisik', $request->lokasi_fisik);
        }

        $perPage = $request->filled('per_page') ? $request->per_page : 10;
        $arsips = $arsips->paginate($perPage);

        if ($request->filled('status_jra')) {
            $filteredCollection = $arsips->getCollection()->filter(function($arsip) use ($request) {
                return $arsip->status_retensi == $request->status_jra;
            });
            $arsips->setCollection($filteredCollection);
        }

        return view('arsip.index', compact('kategori', 'arsips'));
    }

    public function create($kategori_id)
    {
        $kategori = \App\Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);
        return view('arsip.create', compact('kategori'));
    }

    public function store(Request $request, $kategori_id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);

        $request->validate([
            'nomor_dokumen' => 'required|string',
            'nama_arsip' => 'required|string|max:255',
            'tahun_berkas' => 'nullable|string',
            'jumlah_berkas' => 'nullable|integer',
            'retensi_aktif' => 'nullable|string',
            'retensi_inaktif' => 'nullable|string',
            'nasib_akhir' => 'nullable|string',
            'lokasi_fisik' => 'nullable|string',
            'warna_berkas' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120', 
        ]);

        $nama_file = null;

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $nama_file = time() . '_' . \Str::slug($request->nama_arsip) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/arsip_dokumen', $nama_file);
        }

        Arsip::create([
            'subbag_id' => Auth::user()->subbag_id,
            'kategori_id' => $kategori->id,
            'user_id' => Auth::id(),
            'nomor_dokumen' => $request->nomor_dokumen,
            'nama_arsip' => $request->nama_arsip,
            'tahun_berkas' => $request->tahun_berkas,
            'jumlah_berkas' => $request->jumlah_berkas ?? 1,
            'retensi_aktif' => $request->retensi_aktif,
            'retensi_inaktif' => $request->retensi_inaktif,
            'nasib_akhir' => $request->nasib_akhir,
            'lokasi_fisik' => $request->lokasi_fisik,
            'warna_berkas' => $request->warna_berkas,
            'keterangan' => $request->keterangan,
            'file_dokumen' => $nama_file,
        ]);

        // ==========================================
        // REKAM AKTIVITAS: CREATE DOKUMEN
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'CREATE',
            'deskripsi' => 'Mengunggah dokumen baru: ' . $request->nama_arsip
        ]);

        return redirect()->back()->with('success', 'Registrasi dokumen berhasil diamankan di brankas!');
    }

    // ==========================================
    // FUNGSI BARU: MENAMPILKAN HALAMAN EDIT
    // ==========================================
    public function edit($kategori_id, $id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);
        $arsip = Arsip::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        
        return view('arsip.edit', compact('kategori', 'arsip'));
    }

    public function show($kategori_id, $id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);
        $arsip = Arsip::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        
        return view('arsip.show', compact('kategori', 'arsip'));
    }

    public function update(Request $request, $kategori_id, $id)
    {
        $arsip = Arsip::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);

        $request->validate([
            'nomor_dokumen' => 'required|string',
            'nama_arsip' => 'required|string|max:255',
            'file_dokumen' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ]);

        $data = [
            'nomor_dokumen' => $request->nomor_dokumen,
            'nama_arsip' => $request->nama_arsip,
            'tahun_berkas' => $request->tahun_berkas,
            'jumlah_berkas' => $request->jumlah_berkas,
            'retensi_aktif' => $request->retensi_aktif,
            'retensi_inaktif' => $request->retensi_inaktif,
            'nasib_akhir' => $request->nasib_akhir,
            'lokasi_fisik' => $request->lokasi_fisik,
            'warna_berkas' => $request->warna_berkas,
            'keterangan' => $request->keterangan,
        ];

        if ($request->has('hapus_file') && $request->hapus_file == '1') {
            if ($arsip->file_dokumen && Storage::exists('public/arsip_dokumen/' . $arsip->file_dokumen)) {
                Storage::delete('public/arsip_dokumen/' . $arsip->file_dokumen);
            }
            $data['file_dokumen'] = null;
        }

        if ($request->hasFile('file_dokumen')) {
            if ($arsip->file_dokumen && Storage::exists('public/arsip_dokumen/' . $arsip->file_dokumen)) {
                Storage::delete('public/arsip_dokumen/' . $arsip->file_dokumen);
            }
            $file = $request->file('file_dokumen');
            $nama_file = time() . '_' . \Str::slug($request->nama_arsip) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/arsip_dokumen', $nama_file);
            $data['file_dokumen'] = $nama_file;
        }

        $arsip->update($data);

        // ==========================================
        // REKAM AKTIVITAS: UPDATE DOKUMEN
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'UPDATE',
            'deskripsi' => 'Memperbarui data atau file dokumen: ' . $request->nama_arsip
        ]);

        // Mengembalikan pengguna ke halaman daftar arsip (index) setelah sukses update
        return redirect()->route('arsip.index', $kategori_id)->with('success', 'Data dokumen berhasil diperbarui!');
    }

    public function destroy($kategori_id, $id)
    {
        $arsip = Arsip::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $nama_arsip = $arsip->nama_arsip;
        
        $arsip->delete();

        // ==========================================
        // REKAM AKTIVITAS: DELETE DOKUMEN
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'DELETE',
            'deskripsi' => 'Membuang dokumen ke keranjang sampah: ' . $nama_arsip
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil dipindahkan ke Keranjang Sampah!');
    }

    public function massDestroy(Request $request, $kategori_id)
    {
        if (!$request->has('ids') || empty($request->ids)) {
            return redirect()->back()->withErrors(['error' => 'Pilih minimal satu dokumen untuk dihapus!']);
        }

        $arsips = Arsip::where('subbag_id', Auth::user()->subbag_id)
                    ->whereIn('id', $request->ids)
                    ->get();

        $jumlah = count($arsips);

        foreach ($arsips as $arsip) {
            if ($arsip->file_dokumen && \Storage::exists('public/arsip_dokumen/' . $arsip->file_dokumen)) {
                \Storage::delete('public/arsip_dokumen/' . $arsip->file_dokumen);
            }
            $arsip->delete();
        }

        // ==========================================
        // REKAM AKTIVITAS: HAPUS MASSAL
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'DELETE',
            'deskripsi' => 'Membuang ' . $jumlah . ' dokumen secara massal ke keranjang sampah.'
        ]);

        return redirect()->back()->with('success', $jumlah . ' dokumen berhasil dihapus secara massal!');
    }

    public function exportPdf(Request $request, $kategori_id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);
        
        $arsips = Arsip::where('kategori_id', $kategori_id)->latest();

        if ($request->filled('search')) {
            $arsips->where(function($q) use ($request) {
                $q->where('nama_arsip', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status_file')) {
            if ($request->status_file == 'ada') {
                $arsips->whereNotNull('file_dokumen');
            } elseif ($request->status_file == 'tidak') {
                $arsips->whereNull('file_dokumen');
            }
        }

        if ($request->filled('lokasi_fisik')) {
            $arsips->where('lokasi_fisik', $request->lokasi_fisik);
        }

        $arsips = $arsips->get();

        if ($request->filled('status_jra')) {
            $arsips = $arsips->filter(function($arsip) use ($request) {
                return $arsip->status_retensi == $request->status_jra;
            });
        }

        $pdf = \PDF::loadView('arsip.pdf', compact('kategori', 'arsips'))->setPaper('a4', 'landscape');
        $nama_file = 'Laporan_Arsip_' . \Str::slug($kategori->nama_kategori) . '_' . date('Ymd_His') . '.pdf';
        
        return $pdf->download($nama_file);
    }

    public function exportExcel(Request $request, $kategori_id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);
        
        $arsips = Arsip::where('kategori_id', $kategori_id)->latest();

        if ($request->filled('search')) {
            $arsips->where(function($q) use ($request) {
                $q->where('nama_arsip', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status_file')) {
            if ($request->status_file == 'ada') {
                $arsips->whereNotNull('file_dokumen');
            } elseif ($request->status_file == 'tidak') {
                $arsips->whereNull('file_dokumen');
            }
        }

        if ($request->filled('lokasi_fisik')) {
            $arsips->where('lokasi_fisik', $request->lokasi_fisik);
        }

        $arsips = $arsips->get();

        if ($request->filled('status_jra')) {
            $arsips = $arsips->filter(function($arsip) use ($request) {
                return $arsip->status_retensi == $request->status_jra;
            });
        }

        $nama_file = 'Laporan_Arsip_' . \Str::slug($kategori->nama_kategori) . '_' . date('Ymd_His') . '.xlsx';
        
        return Excel::download(new ArsipExport($arsips, $kategori), $nama_file);
    }

    public function downloadTemplate()
    {
        return Excel::download(new ArsipTemplateExport, 'Template_Import_Arsip.xlsx');
    }

    public function importExcel(Request $request, $kategori_id)
    {
        $request->validate([
            'file_excel' => 'required|file'
        ]);

        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($kategori_id);

        try {
            Excel::import(new ArsipImport($kategori->id, Auth::user()->subbag_id, Auth::id()), $request->file('file_excel'));
            return back()->with('success', 'Data arsip berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}