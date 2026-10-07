<?php

namespace App\Http\Controllers;

use App\Arsip;
use App\Kategori;
use App\RiwayatAktivitas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Auth::user()->role;
        $subbag_id = Auth::user()->subbag_id;

        if ($role == 'Superadmin') {
            // 1. Hitung Total Folder (Kategori) Global
            $total_folder = Kategori::count();

            // 2. Ambil Semua Arsip Global
            $semua_arsip = Arsip::orderBy('created_at', 'desc')->get();
            $total_arsip = $semua_arsip->count();

            // 3. Kelompokkan berdasarkan Status Retensi JRA Global
            $arsip_aktif = $semua_arsip->where('status_retensi', 'Aktif')->count();
            $arsip_inaktif = $semua_arsip->where('status_retensi', 'Inaktif')->count();
            $arsip_selesai = $semua_arsip->whereIn('status_retensi', ['Musnah', 'Permanen'])->count();

            // 4. Ambil 5 Arsip Terakhir Global
            $arsip_terbaru = $semua_arsip->take(5);

            // 5. Data Chart: Jumlah arsip per subbagian
            $kategoris_chart = \App\Subbagian::withCount('arsips')->get()->map(function($subbag) {
                return (object)[
                    'nama_kategori' => $subbag->nama_subbag,
                    'arsips_count' => $subbag->arsips_count
                ];
            });

            // 6. Riwayat Aktivitas Global
            $riwayat_dashboard = RiwayatAktivitas::with('user')
                                    ->where('tipe_aksi', '!=', 'FORCE_DELETE') // tidak memantau force delete
                                    ->latest()
                                    ->take(5)
                                    ->get();
        } else {
            // 1. Hitung Total Folder (Kategori)
            $total_folder = Kategori::where('subbag_id', $subbag_id)->count();

            // 2. Ambil Semua Arsip milik Subbagian
            $semua_arsip = Arsip::where('subbag_id', $subbag_id)->orderBy('created_at', 'desc')->get();
            $total_arsip = $semua_arsip->count();

            // 3. Kelompokkan berdasarkan Status Retensi JRA
            $arsip_aktif = $semua_arsip->where('status_retensi', 'Aktif')->count();
            $arsip_inaktif = $semua_arsip->where('status_retensi', 'Inaktif')->count();
            $arsip_selesai = $semua_arsip->whereIn('status_retensi', ['Musnah', 'Permanen'])->count();

            // 4. Ambil 5 Arsip Terakhir
            $arsip_terbaru = $semua_arsip->take(5);

            // 5. LOGIKA BARU: Ambil data Gudang Folder beserta hitungan jumlah berkas di dalamnya
            $kategoris_chart = Kategori::where('subbag_id', $subbag_id)
                                ->withCount('arsips')
                                ->get();

            // 6. RIWAYAT AKTIVITAS REAL-TIME UNTUK WIDGET DASHBOARD
            $riwayat_dashboard = RiwayatAktivitas::with('user')
                                    ->where('subbag_id', $subbag_id)
                                    ->latest()
                                    ->take(5)
                                    ->get();
        }

        return view('home', compact(
            'total_folder', 
            'total_arsip', 
            'arsip_aktif', 
            'arsip_inaktif', 
            'arsip_selesai', 
            'arsip_terbaru',
            'kategoris_chart',
            'riwayat_dashboard' 
        ));
    }
}