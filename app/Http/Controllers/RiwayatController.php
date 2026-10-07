<?php

namespace App\Http\Controllers;

use App\RiwayatAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Hapus riwayat yang sudah lebih dari 30 hari untuk mencegah data terlalu menumpuk
        RiwayatAktivitas::where('created_at', '<', now()->subDays(30))->delete();

        $query = RiwayatAktivitas::with('user')->latest();

        // Jika bukan superadmin, batasi hanya riwayat di subbagiannya sendiri
        if (Auth::user()->role !== 'Superadmin') {
            $query->where('subbag_id', Auth::user()->subbag_id);
        }

        // Fitur Pencarian Kata Kunci
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Gunakan pagination agar halaman tidak berat jika log sudah mencapai ribuan
        $riwayats = $query->paginate(20);

        return view('riwayat.index', compact('riwayats'));
    }
}