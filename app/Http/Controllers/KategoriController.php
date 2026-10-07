<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use Illuminate\Support\Facades\Auth;
use App\Subbagian;

class KategoriController extends Controller
{
    // Memastikan hanya admin yang sudah login yang bisa mengakses
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1. READ: Menampilkan daftar folder milik subbagian admin
    public function index(Request $request)
    {
        $query = Kategori::where('subbag_id', Auth::user()->subbag_id);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $kategoris = $query->orderBy('nama_kategori', 'asc')->get();
        $subbagians = Subbagian::whereNotNull('kode_klasifikasi')->get();
        
        return view('kategori.index', compact('kategoris', 'subbagians'));
    }

    // 2. CREATE: Menyimpan folder baru dan mengunci subbag_id-nya
    public function store(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string',
            'angka_kategori' => 'nullable|numeric',
            'deskripsi' => 'nullable|string'
        ]);

        $nama_kategori = $request->kode_klasifikasi;
        if ($request->kode_klasifikasi !== 'Lainnya') {
            $nama_kategori .= '.' . $request->angka_kategori;
        }

        Kategori::create([
            'subbag_id' => Auth::user()->subbag_id, // Otomatis mengikuti subbag admin
            'nama_kategori' => $nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Folder kategori berhasil dibuat!');
    }

    // 3. UPDATE: Memperbarui nama/deskripsi folder
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string',
            'angka_kategori' => 'nullable|numeric',
            'deskripsi' => 'nullable|string'
        ]);

        $nama_kategori = $request->kode_klasifikasi;
        if ($request->kode_klasifikasi !== 'Lainnya') {
            $nama_kategori .= '.' . $request->angka_kategori;
        }

        // Cari folder berdasarkan ID, TAPI pastikan itu milik subbagiannya
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        
        $kategori->update([
            'nama_kategori' => $nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Folder berhasil diperbarui!');
    }

    // 4. DELETE: Menghapus folder
    public function destroy($id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Folder berhasil dihapus!');
    }
}