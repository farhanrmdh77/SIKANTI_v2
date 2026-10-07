<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

// ==========================================
// ROUTE PUBLIK UNTUK SCANNER HP PEGAWAI
// (Tanpa Middleware Auth agar Pegawai Bisa Akses)
// ==========================================
Route::get('/arsip/{id}/scan', 'VerifikasiController@scan')->name('scan.arsip');
Route::post('/arsip/{id}/scan', 'VerifikasiController@requestAkses')->name('scan.request');

// API Check Real-time untuk HP Pegawai (Mengecek status ACC secara background)
Route::get('/api/scan-status/{verifikasi_id}', 'VerifikasiController@apiCheckPegawai')->name('api.scan.status');


// ==========================================
// ROUTE MODULE SIKANTI (E-ARSIP) - AREA ADMIN
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Route untuk Gudang Folder (Kategori)
    Route::resource('kategori', 'KategoriController')->except(['create', 'show', 'edit']);
    
    // Route untuk Isi Folder (Arsip) berdasarkan Kategori ID
    Route::get('/kategori/{kategori_id}/arsip', 'ArsipController@index')->name('arsip.index');
    Route::get('/kategori/{kategori_id}/arsip/export-pdf', 'ArsipController@exportPdf')->name('arsip.export_pdf');
    Route::get('/kategori/{kategori_id}/arsip/export-excel', 'ArsipController@exportExcel')->name('arsip.export_excel');
    Route::get('/kategori/{kategori_id}/arsip/template', 'ArsipController@downloadTemplate')->name('arsip.template');
    Route::post('/kategori/{kategori_id}/arsip/import', 'ArsipController@importExcel')->name('arsip.import');
    
    // INI ADALAH ROUTE BARU UNTUK HALAMAN EDIT DAN SHOW YANG DITAMBAHKAN 
    Route::get('/kategori/{kategori_id}/arsip/create', 'ArsipController@create')->name('arsip.create');
    Route::get('/kategori/{kategori_id}/arsip/{id}/edit', 'ArsipController@edit')->name('arsip.edit');
    Route::get('/kategori/{kategori_id}/arsip/{id}', 'ArsipController@show')->name('arsip.show');

    Route::post('/kategori/{kategori_id}/arsip', 'ArsipController@store')->name('arsip.store');
    Route::put('/kategori/{kategori_id}/arsip/{id}', 'ArsipController@update')->name('arsip.update');

    // POSISI KRUSIAL: mass-destroy WAJIB diletakkan di atas rute hapus satuan ({id})
    Route::delete('/kategori/{kategori_id}/arsip/mass-destroy', 'ArsipController@massDestroy')->name('arsip.massDestroy');
    
    // Rute hapus satuan diletakkan di urutan paling bawah
    Route::delete('/kategori/{kategori_id}/arsip/{id}', 'ArsipController@destroy')->name('arsip.destroy');

    // ROUTE VERIFIKASI AKSES (Dasbor Admin)
    Route::get('/verifikasi', 'VerifikasiController@index')->name('verifikasi.index');
    Route::put('/verifikasi/{id}/approve', 'VerifikasiController@approve')->name('verifikasi.approve');
    Route::put('/verifikasi/{id}/reject', 'VerifikasiController@reject')->name('verifikasi.reject');
    Route::delete('/verifikasi/{id}', 'VerifikasiController@destroy')->name('verifikasi.destroy');
    Route::put('/verifikasi/{id}/allow-download', 'VerifikasiController@allowDownload')->name('verifikasi.allow_download');
    
    // API Check Real-time untuk Dasbor Admin (Mengecek masuknya request baru)
    Route::get('/api/verifikasi-pending', 'VerifikasiController@apiCheckAdmin')->name('api.verifikasi.pending');

    // ROUTE MANAJEMEN PENGGUNA SEKTOR
    Route::get('/manajemen-pengguna', 'PenggunaController@index')->name('pengguna.index');
    Route::post('/manajemen-pengguna', 'PenggunaController@store')->name('pengguna.store');
    Route::put('/manajemen-pengguna/{id}', 'PenggunaController@update')->name('pengguna.update');
    Route::delete('/manajemen-pengguna/{id}', 'PenggunaController@destroy')->name('pengguna.destroy');

    // ROUTE KELOLA SAMPAH
    Route::get('/kelola-sampah', 'SampahController@index')->name('sampah.index');
    Route::post('/kelola-sampah/kategori/{id}/restore', 'SampahController@restoreKategori')->name('sampah.kategori.restore');
    Route::delete('/kelola-sampah/kategori/{id}/force', 'SampahController@forceDeleteKategori')->name('sampah.kategori.force'); 
    Route::post('/kelola-sampah/arsip/{id}/restore', 'SampahController@restoreArsip')->name('sampah.arsip.restore');
    Route::delete('/kelola-sampah/arsip/{id}/force', 'SampahController@forceDeleteArsip')->name('sampah.arsip.force');

    // ROUTE RIWAYAT AKTIVITAS
    Route::get('/riwayat-aktivitas', 'RiwayatController@index')->name('riwayat.index');

    // ROUTE PENGATURAN & PROFIL (SEMUA PENGGUNA)
    Route::get('/pengaturan', 'PengaturanController@index')->name('pengaturan.index');
    Route::put('/profil/update', 'PengaturanController@updateProfil')->name('profil.update');

    // ROUTE PENGATURAN UTAMA (KHUSUS SUPERADMIN)
    Route::middleware(['is_superadmin'])->group(function () {
        Route::post('/pengaturan/update', 'PengaturanController@update')->name('pengaturan.update');
        
        // Manajemen Pengguna (Superadmin)
        Route::resource('superadmin/users', 'UserController')->names('superadmin.users');
        
        // Manajemen Subbagian / Kode Klasifikasi
        Route::resource('subbagian', 'SubbagianController')->except(['create', 'show', 'edit']);
    });

});