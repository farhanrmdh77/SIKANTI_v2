@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    #app > nav { display: none !important; }
    #app > main { padding-top: 0 !important; padding-bottom: 0 !important; }
    body { background-color: #f4f7fb; font-family: 'Poppins', sans-serif; overflow-x: hidden; margin: 0; color: #334155; }

    .dashboard-wrapper { display: flex; min-height: 100vh; width: 100%; }
    
    /* ================= SIDEBAR SAAS STYLE ================= */
    .sidebar { width: 280px; background-color: #0f172a; color: #fff; display: flex; flex-direction: column; flex-shrink: 0; position: sticky; top: 0; height: 100vh; box-shadow: 4px 0 24px rgba(0,0,0,0.05); z-index: 1000;}
    .sidebar-header { padding: 30px 25px 20px 25px; }
    
    .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; flex-grow: 1; overflow-y: auto; }
    .sidebar-menu::-webkit-scrollbar { width: 4px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 4px; }
    .sidebar-menu li { margin-bottom: 8px; }
    .sidebar-menu a { display: flex; align-items: center; color: #94a3b8; text-decoration: none; padding: 14px 18px; border-radius: 14px; font-weight: 500; font-size: 0.9rem; transition: all 0.3s ease; }
    .sidebar-menu a i { margin-right: 16px; font-size: 1.1rem; width: 24px; text-align: center; transition: all 0.3s ease; }
    
    .sidebar-menu a:hover { color: #fff; background-color: rgba(255,255,255,0.05); transform: translateX(5px); }
    .sidebar-menu a.active { background-color: #2563eb; color: #fff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3); }
    .sidebar-menu a.active i { color: #fff; }

    .main-content { flex-grow: 1; padding: 0 40px 80px 40px; min-height: 100vh; }
    
    /* ================= NAVBAR STICKY GLASSMORPHISM ================= */
    .top-navbar-sticky { position: sticky; top: 0; background-color: rgba(244, 247, 251, 0.85); -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px); z-index: 999; margin: 0 -40px 30px -40px; padding: 20px 40px; border-bottom: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.02); }

    /* ================= SAAS COMPONENTS & FORM ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); position: relative; }
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 30px; font-size: 0.95rem; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25); transition: 0.3s; display: inline-flex; align-items: center; }
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 12px 20px rgba(37, 99, 235, 0.3); }
    
    .btn-light-modern { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 600; padding: 12px 25px; font-size: 0.95rem; transition: 0.3s; text-decoration: none; display: inline-flex; align-items: center;}
    .btn-light-modern:hover { background-color: #e2e8f0; color: #0f172a; text-decoration: none; }

    .btn-back-modern { background-color: #fff; color: #475569; border: 1px solid #cbd5e1; border-radius: 12px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: 0.3s; margin-right: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); text-decoration: none;}
    .btn-back-modern:hover { background-color: #f1f5f9; color: #0f172a; transform: translateX(-3px); text-decoration: none;}

    .form-label-modern { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block; }
    .form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; background-color: #f8fafc; transition: all 0.3s ease; color: #334155; font-size: 0.9rem; width: 100%; height: auto;}
    .form-control-modern:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); outline: none; }
    textarea.form-control-modern { min-height: 120px; resize: vertical; }
    select.form-control-modern { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; padding-right: 40px; cursor: pointer; }
    
    .section-badge { display: inline-flex; align-items: center; background: #eff6ff; color: #2563eb; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; margin-bottom: 25px; border: 1px solid rgba(37, 99, 235, 0.1); }
    .section-badge.warning { background: #fef3c7; color: #d97706; border-color: rgba(217, 119, 6, 0.1); }
    
    .border-right-dashed { border-right: 2px dashed #f1f5f9; }
    @media (max-width: 991px) { .border-right-dashed { border-right: none; border-bottom: 2px dashed #f1f5f9; margin-bottom: 30px; padding-bottom: 30px; } }

    /* CUSTOM FILE UPLOAD DRAG & DROP STYLE */
    .file-upload-wrapper { position: relative; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 30px 20px; text-align: center; background-color: #f8fafc; transition: all 0.3s ease; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .file-upload-wrapper:hover { border-color: #3b82f6; background-color: #eff6ff; }
    .file-upload-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10; }
    .file-icon-large { font-size: 2.5rem; color: #94a3b8; margin-bottom: 10px; transition: 0.3s; }
    .file-upload-wrapper:hover .file-icon-large { color: #3b82f6; transform: translateY(-5px); }
    .file-upload-text { font-size: 0.9rem; color: #475569; font-weight: 600; margin-bottom: 5px; }

    /* Custom Month Picker */
    .mp-month-btn { background: transparent; border: 1px solid transparent; border-radius: 8px; color: #475569; padding: 8px 0; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; width: 100%; cursor: pointer; margin-bottom: 5px; }
    .mp-month-btn:hover { background: #f1f5f9; color: #0f172a; }
    .mp-month-btn.active { background: #2563eb; color: #fff; font-weight: 600; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2); }
    .mp-year-btn { border: none; background: #f1f5f9; color: #475569; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; padding: 0; }
    .mp-year-btn:hover { background: #e2e8f0; color: #0f172a; }

    /* RESPONSIVE */
    .mobile-menu-btn { display: none; background: transparent; border: none; color: #0f172a; font-size: 1.5rem; cursor: pointer; padding: 0; margin-right: 15px; transition: 0.3s; }
    .mobile-menu-btn:hover { color: #2563eb; }
    
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 9998; opacity: 0; transition: opacity 0.3s ease; }
    .sidebar-overlay.show { display: block; opacity: 1; }

    @media (max-width: 991px) {
        .sidebar { position: fixed; left: -300px; top: 0; height: 100vh; z-index: 9999; transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1); width: 280px; }
        .sidebar.show { left: 0; box-shadow: 10px 0 30px rgba(0,0,0,0.2); }
        .main-content { padding: 0 15px 80px 15px; width: 100%; }
        .top-navbar-sticky { margin: 0 -15px 25px -15px; padding: 15px; border-radius: 0 0 20px 20px; }
        .mobile-menu-btn { display: block; }
        .user-profile-text { display: none !important; }
    }
</style>

<div class="dashboard-wrapper">
    @include('layouts.sidebar')

    <div class="main-content">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <div class="top-navbar-sticky d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                <a href="{{ route('arsip.index', $kategori->id) }}" class="btn-back-modern" title="Batal Edit">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Pemutakhiran Dokumen</h3>
                    <small style="color: #64748b; font-weight: 500; font-size: 0.8rem;">Modul Gudang Folder Klasifikasi</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="text-right mr-3 d-none d-md-block user-profile-text">
                    <div class="font-weight-bold" style="color: #0f172a; font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                    <div style="color: #64748b; font-size: 0.8rem; font-weight: 500;">{{ Auth::user()->email }}</div>
                </div>
                <div class="shadow-sm" style="width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background-color: #fff; color: #C8A35A; border: 1px solid #e2e8f0; overflow: hidden;">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/profil/' . Auth::user()->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-user-shield"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="saas-card mb-5">
            <div class="px-5 py-4 border-bottom bg-white" style="border-radius: 20px 20px 0 0; border-color: #f1f5f9 !important;">
                <h4 class="font-weight-bold mb-0" style="color: #0f172a;">
                    <i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Edit Data Arsip
                </h4>
            </div>

            <form action="{{ route('arsip.update', [$kategori->id, $arsip->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <div class="px-5 py-5 bg-white">
                    <div class="row">
                        <div class="col-lg-6 border-right-dashed pr-lg-5">
                            <div class="section-badge">
                                <i class="fa-solid fa-circle-info mr-2"></i> Informasi Utama Berkas
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="form-label-modern">Kode Klas</label>
                                    <input type="text" class="form-control-modern font-weight-bold" name="nomor_dokumen" value="{{ $arsip->nomor_dokumen }}" required>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label-modern">Nama Berkas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-modern font-weight-bold" name="nama_arsip" value="{{ $arsip->nama_arsip }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Tahun Berkas <span class="text-danger">*</span></label>
                                    @php
                                        $bulan_val = '';
                                        $tahun_val = '';
                                        if ($arsip->tahun_berkas) {
                                            $parts = explode(' ', $arsip->tahun_berkas);
                                            if (count($parts) == 2) {
                                                $bulan_val = $parts[0];
                                                $tahun_val = $parts[1];
                                            } else {
                                                $tahun_val = $parts[0];
                                            }
                                        }
                                    @endphp
                                    <div class="position-relative">
                                        <!-- Visible Input Button -->
                                        <div id="custom-mp-toggle" class="form-control-modern d-flex align-items-center justify-content-between" style="cursor: pointer; background-color: #fff; padding: 10px 14px; min-height: 44px; height: auto;">
                                            <span id="custom-mp-text" class="{{ $arsip->tahun_berkas ? 'text-dark' : 'text-muted' }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-right: 10px; font-size: 0.85rem;">{{ $arsip->tahun_berkas ?? 'Bulan & Tahun' }}</span>
                                            <i class="fa-solid fa-calendar-days text-muted flex-shrink-0"></i>
                                        </div>
                                        
                                        <!-- Hidden Dropdown Popover -->
                                        <div id="custom-mp-popover" class="position-absolute shadow border rounded bg-white p-3 d-none" style="top: 100%; left: 0; right: 0; z-index: 1000; margin-top: 5px; min-width: 250px;">
                                            <!-- Year Selector Header -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <button type="button" class="mp-year-btn" id="mp-prev-year"><i class="fa-solid fa-chevron-left"></i></button>
                                                <h6 class="mb-0 fw-bold" id="mp-current-year" style="font-weight: bold; margin: 0;">{{ $tahun_val ?: date('Y') }}</h6>
                                                <button type="button" class="mp-year-btn" id="mp-next-year"><i class="fa-solid fa-chevron-right"></i></button>
                                            </div>
                                            
                                            <!-- Months Grid -->
                                            <div class="row mb-3" style="margin-left: -5px; margin-right: -5px;">
                                                <div class="col-3 px-1"><button type="button" class="mp-month-btn {{ $bulan_val == 'Januari' ? 'active' : '' }}" data-month="01">Jan</button></div>
                                                <div class="col-3 px-1"><button type="button" class="mp-month-btn {{ $bulan_val == 'Februari' ? 'active' : '' }}" data-month="02">Feb</button></div>
                                                <div class="col-3 px-1"><button type="button" class="mp-month-btn {{ $bulan_val == 'Maret' ? 'active' : '' }}" data-month="03">Mar</button></div>
                                                <div class="col-3 px-1"><button type="button" class="mp-month-btn {{ $bulan_val == 'April' ? 'active' : '' }}" data-month="04">Apr</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'Mei' ? 'active' : '' }}" data-month="05">Mei</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'Juni' ? 'active' : '' }}" data-month="06">Jun</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'Juli' ? 'active' : '' }}" data-month="07">Jul</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'Agustus' ? 'active' : '' }}" data-month="08">Ags</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'September' ? 'active' : '' }}" data-month="09">Sep</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'Oktober' ? 'active' : '' }}" data-month="10">Okt</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'November' ? 'active' : '' }}" data-month="11">Nov</button></div>
                                                <div class="col-3 px-1 mt-2"><button type="button" class="mp-month-btn {{ $bulan_val == 'Desember' ? 'active' : '' }}" data-month="12">Des</button></div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-sm btn-light" id="mp-clear-btn" style="font-size: 0.8rem; background: #f8f9fa; border: 1px solid #ddd; border-radius: 6px;">Clear Bulan</button>
                                                <button type="button" class="btn btn-sm btn-primary" id="mp-apply-btn" style="font-size: 0.8rem; background: #2563eb; border: none; border-radius: 6px; color: white;">Terapkan</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="tahun_berkas" id="hidden_tahun_berkas" value="{{ $arsip->tahun_berkas }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Jumlah (Lembar)</label>
                                    <input type="number" class="form-control-modern" name="jumlah_berkas" value="{{ $arsip->jumlah_berkas }}">
                                </div>
                            </div>
                            
                            <div class="form-group mb-0">
                                <label class="form-label-modern">Deskripsi (Uraian)</label>
                                <textarea class="form-control-modern" name="keterangan" placeholder="Catatan mengenai arsip ini...">{{ $arsip->keterangan }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 pl-lg-5">
                            <div class="section-badge warning mt-4 mt-lg-0">
                                <i class="fa-solid fa-scale-balanced mr-2"></i> Status, Retensi & Digitalisasi
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Retensi Aktif (Thn)</label>
                                    <input type="number" class="form-control-modern" name="retensi_aktif" value="{{ $arsip->retensi_aktif }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Retensi Inaktif (Thn)</label>
                                    <input type="number" class="form-control-modern" name="retensi_inaktif" value="{{ $arsip->retensi_inaktif }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Nasib Akhir</label>
                                    <select class="form-control-modern" name="nasib_akhir">
                                        <option value="" {{ empty($arsip->nasib_akhir) ? 'selected' : '' }}>-- Belum Ditentukan --</option>
                                        <option value="Musnah" {{ $arsip->nasib_akhir == 'Musnah' ? 'selected' : '' }}>Musnah</option>
                                        <option value="Permanen" {{ $arsip->nasib_akhir == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                                        <option value="Dinilai Kembali" {{ $arsip->nasib_akhir == 'Dinilai Kembali' ? 'selected' : '' }}>Dinilai Kembali</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Warna Map</label>
                                    <input type="text" class="form-control-modern" name="warna_berkas" value="{{ $arsip->warna_berkas }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label-modern">Lokasi Fisik Berkas</label>
                                <select class="form-control-modern" name="lokasi_fisik">
                                    <option value="Internal Subbagian" {{ $arsip->lokasi_fisik == 'Internal Subbagian' ? 'selected' : '' }}>Internal Subbagian</option>
                                    <option value="Diserahkan ke Umum" {{ $arsip->lokasi_fisik == 'Diserahkan ke Umum' ? 'selected' : '' }}>Diserahkan ke Bagian Umum</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-0 mt-4">
                                <label class="form-label-modern" style="color: #2563eb;">
                                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Update File Digital (Opsional)
                                </label>
                                <div class="file-upload-wrapper" style="padding: 20px 10px;">
                                    <input type="file" class="file-upload-input" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" onchange="updateFileName(this, 'fileNameDisplayEdit')">
                                    <i class="fa-solid fa-file-pen file-icon-large" style="font-size: 1.8rem;"></i>
                                    <div class="file-upload-text" id="fileNameDisplayEdit">Ganti file atau seret ke sini</div>
                                </div>
                                
                                @if($arsip->file_dokumen)
                                    <div class="p-3 bg-light rounded mt-3 d-flex justify-content-between align-items-center" style="border: 1px solid #cbd5e1;">
                                        <div class="d-flex align-items-center" style="max-width: 70%;">
                                            <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                            <span class="text-dark font-weight-bold text-truncate" style="font-size: 0.85rem;" title="{{ $arsip->file_dokumen }}">{{ $arsip->file_dokumen }}</span>
                                        </div>
                                        <div class="custom-control custom-checkbox text-right">
                                            <input type="checkbox" class="custom-control-input" id="hapus_file" name="hapus_file" value="1">
                                            <label class="custom-control-label text-danger font-weight-bold" for="hapus_file" style="cursor: pointer; padding-top: 2px; font-size: 0.85rem;">Hapus File</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="px-5 py-4 d-flex justify-content-between align-items-center" style="background: #f8fafc; border-top: 1px solid #f1f5f9; border-radius: 0 0 20px 20px;">
                    <div style="color: #94a3b8; font-size: 0.8rem; font-weight: 500;">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Terakhir diubah: {{ $arsip->updated_at->diffForHumans() }}
                    </div>
                    <div>
                        <a href="{{ route('arsip.index', $kategori->id) }}" class="btn-light-modern mr-2">Batal</a>
                        <button type="submit" class="btn-primary-modern">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('custom-mp-toggle');
        const popover = document.getElementById('custom-mp-popover');
        const displayText = document.getElementById('custom-mp-text');
        const hiddenInput = document.getElementById('hidden_tahun_berkas');
        const monthBtns = document.querySelectorAll('.mp-month-btn');
        const yearPrev = document.getElementById('mp-prev-year');
        const yearNext = document.getElementById('mp-next-year');
        const yearDisplay = document.getElementById('mp-current-year');
        const clearBtn = document.getElementById('mp-clear-btn');
        const applyBtn = document.getElementById('mp-apply-btn');

        let selectedMonth = '';
        let activeBtn = document.querySelector('.mp-month-btn.active');
        if (activeBtn) {
            selectedMonth = activeBtn.getAttribute('data-month');
        }

        let selectedYear = parseInt(yearDisplay.textContent) || new Date().getFullYear();
        let currentViewYear = selectedYear;

        const monthNames = {
            '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
            '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
            '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
        };

        yearDisplay.textContent = currentViewYear;

        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            popover.classList.toggle('d-none');
        });

        popover.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        document.addEventListener('click', function() {
            if (!popover.classList.contains('d-none')) {
                popover.classList.add('d-none');
            }
        });

        yearPrev.addEventListener('click', function() {
            currentViewYear--;
            yearDisplay.textContent = currentViewYear;
        });

        yearNext.addEventListener('click', function() {
            currentViewYear++;
            yearDisplay.textContent = currentViewYear;
        });

        monthBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                monthBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedMonth = this.getAttribute('data-month');
            });
        });

        clearBtn.addEventListener('click', function() {
            monthBtns.forEach(b => b.classList.remove('active'));
            selectedMonth = '';
        });

        applyBtn.addEventListener('click', function() {
            selectedYear = currentViewYear;
            let displayStr = '';
            let valStr = '';
            
            if (selectedMonth) {
                const monthName = monthNames[selectedMonth];
                displayStr = monthName + ' ' + selectedYear;
                valStr = monthName + ' ' + selectedYear;
            } else {
                displayStr = selectedYear.toString();
                valStr = selectedYear.toString();
            }
            
            displayText.textContent = displayStr;
            displayText.classList.remove('text-muted');
            displayText.classList.add('text-dark');
            hiddenInput.value = valStr;
            popover.classList.add('d-none');
        });
    });

    function updateFileName(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files.length > 0) {
            display.innerHTML = `<span class="text-primary font-weight-bold"><i class="fa-solid fa-check-circle mr-1"></i> ${input.files[0].name}</span>`;
        } else {
            display.innerHTML = 'Ganti file atau seret ke sini';
        }
    }

    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>
@endsection