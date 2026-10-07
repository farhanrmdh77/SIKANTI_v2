<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubbagianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_subbag' => 'required|string|max:255',
            'kode_klasifikasi' => 'required|string|max:50|unique:subbagians,kode_klasifikasi',
        ]);

        \App\Subbagian::create([
            'nama_subbag' => $request->nama_subbag,
            'kode_klasifikasi' => strtoupper($request->kode_klasifikasi),
        ]);

        return redirect()->route('pengaturan.index')->with('success', 'Subbagian / Kode Klasifikasi berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subbagian = \App\Subbagian::findOrFail($id);

        $request->validate([
            'nama_subbag' => 'required|string|max:255',
            'kode_klasifikasi' => 'required|string|max:50|unique:subbagians,kode_klasifikasi,' . $id,
        ]);

        $subbagian->update([
            'nama_subbag' => $request->nama_subbag,
            'kode_klasifikasi' => strtoupper($request->kode_klasifikasi),
        ]);

        return redirect()->route('pengaturan.index')->with('success', 'Subbagian / Kode Klasifikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subbagian = \App\Subbagian::findOrFail($id);
        
        // Prevent deletion if there are users associated with it
        if ($subbagian->users()->count() > 0 || $subbagian->arsips()->count() > 0) {
            return redirect()->route('pengaturan.index')->with('error', 'Tidak dapat menghapus Subbagian karena masih memiliki Pengguna atau Arsip yang tertaut.');
        }

        $subbagian->delete();

        return redirect()->route('pengaturan.index')->with('success', 'Subbagian / Kode Klasifikasi berhasil dihapus.');
    }
}
