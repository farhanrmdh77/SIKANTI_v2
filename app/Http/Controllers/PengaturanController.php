<?php

namespace App\Http\Controllers;

use App\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\RiwayatAktivitas;
use App\Subbagian;

class PengaturanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1. Tampilkan Halaman Pengaturan (Hanya Superadmin)
    public function index()
    {
        // Ambil data pengaturan pertama, jika belum ada di database, buat instansiasi kosong
        $pengaturan = Pengaturan::first() ?? new Pengaturan();
        
        $subbagians = collect();
        if (Auth::user()->role == 'Superadmin') {
            $subbagians = Subbagian::all();
        }

        return view('pengaturan.index', compact('pengaturan', 'subbagians'));
    }

    // Tampilkan Halaman Profil (Untuk Semua)
    public function profilIndex()
    {
        return view('pengaturan.profil');
    }

    // 2. Simpan Pembaruan Identitas Instansi (Kiri)
    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:100',
            'sub_judul' => 'nullable|string|max:255',
            'logo_aplikasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengaturan = Pengaturan::first();
        if (!$pengaturan) {
            $pengaturan = new Pengaturan();
        }

        $pengaturan->nama_aplikasi = $request->nama_aplikasi;
        $pengaturan->sub_judul = $request->sub_judul;

        // Logika Penggantian Logo Instansi
        if ($request->hasFile('logo_aplikasi')) {
            if ($pengaturan->logo_aplikasi && Storage::exists('public/pengaturan/' . $pengaturan->logo_aplikasi)) {
                Storage::delete('public/pengaturan/' . $pengaturan->logo_aplikasi);
            }

            $file = $request->file('logo_aplikasi');
            $nama_file = 'logo_aplikasi_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pengaturan', $nama_file);
            
            $pengaturan->logo_aplikasi = $nama_file;
        }

        $pengaturan->save();

        RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'UPDATE',
            'deskripsi' => 'Mengubah identitas aplikasi beserta sub-judulnya.'
        ]);

        return redirect()->back()->with('success', 'Identitas dan Logo aplikasi berhasil diperbarui!');
    }

    // 3. Simpan Pembaruan Profil Akun Personal (Kanan)
    public function updateProfil(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        // Validasi input profil
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6', // Syarat minimal sandi 6 karakter
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        // Update Nama
        $user->name = $request->name;

        // Update Sandi (Hanya jika kolom sandi diisi oleh pengguna)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // =======================================================
        // PENAMBAHAN BARU: LOGIKA HAPUS FOTO PROFIL
        // =======================================================
        if ($request->hapus_foto == '1') {
            // Hapus file fisik lama di storage jika ada
            if ($user->foto && Storage::exists('public/profil/' . $user->foto)) {
                Storage::delete('public/profil/' . $user->foto);
            }
            // Kosongkan nama file di database
            $user->foto = null;
        }

        // =======================================================
        // Logika Penggantian Foto Profil Baru
        // =======================================================
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika sebelumnya sudah punya (mencegah penumpukan file)
            if ($user->foto && Storage::exists('public/profil/' . $user->foto)) {
                Storage::delete('public/profil/' . $user->foto);
            }

            $file = $request->file('foto');
            // Penamaan file yang unik menghindari bentrok
            $nama_file = 'foto_profil_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Disimpan ke folder storage/app/public/profil
            $file->storeAs('public/profil', $nama_file);
            
            $user->foto = $nama_file;
        }

        $user->save();

        RiwayatAktivitas::create([
            'user_id' => $user->id,
            'subbag_id' => $user->subbag_id,
            'tipe_aksi' => 'UPDATE',
            'deskripsi' => 'Memperbarui profil akun (Nama/Sandi/Foto).'
        ]);

        return redirect()->back()->with('success', 'Profil akun Anda berhasil diperbarui!');
    }
}