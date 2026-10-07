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

    /* ================= SAAS COMPONENTS ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); overflow: hidden; position: relative; }
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 10px; font-weight: 600; padding: 10px 18px; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: 0.3s; display: inline-flex; align-items: center; }
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }
    
    .btn-back-modern { background-color: #fff; color: #475569; border: 1px solid #cbd5e1; border-radius: 12px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: 0.3s; margin-right: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); text-decoration: none;}
    .btn-back-modern:hover { background-color: #f1f5f9; color: #0f172a; transform: translateX(-3px); text-decoration: none;}

    /* FILTER & SEARCH MODERN */
    .filter-wrapper { background-color: #fff; border-bottom: 1px solid #e2e8f0; padding: 15px 24px; }
    .filter-flex-container { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
    .filter-input-modern { border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; font-size: 0.75rem; font-family: 'Poppins'; height: 36px; color: #475569; box-shadow: none; transition: 0.3s; outline: none; }
    .filter-input-modern:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    select.filter-input-modern { padding: 0 10px !important; cursor: pointer; }

    /* TABLE SAAS */
    .table-modern th { border-top: none; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 15px; font-weight: 700; background: #fafbfc; white-space: nowrap;}
    .table-modern td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 10px 15px; color: #334155; }
    .table-modern tr:hover td { background-color: #f8fafc; }

    /* BADGE SINGLE-LINE TABEL */
    .badge-modern { padding: 3px 6px; border-radius: 6px; font-size: 0.65rem; font-weight: 600; display: inline-flex; align-items: center; white-space: nowrap; }
    .badge-gray { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .badge-blue { background-color: #eff6ff; color: #2563eb; }
    .badge-green { background-color: #d1fae5; color: #059669; }
    .badge-yellow { background-color: #fef3c7; color: #d97706; }
    .badge-red { background-color: #ffe4e6; color: #e11d48; }

    /* TOMBOL AKSI KOTAK TABEL */
    .btn-action-square { width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; border: none; color: #fff; font-size: 0.75rem; margin: 0 2px; transition: 0.2s; cursor: pointer; text-decoration: none; }
    .btn-action-square:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
    .btn-qr { background-color: #10b981; } 
    .btn-detail { background-color: #3b82f6; } 
    .btn-edit { background-color: #6366f1; } 
    .btn-delete { background-color: #ef4444; } 

    .text-truncate-wrapper { min-width: 0; flex: 1; padding-right: 10px; }
    .text-truncate-custom { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal; line-height: 1.3; max-width: 100%; }

    /* CHECKBOX MASSAL */
    .checkbox-column { display: none; }
    .custom-checkbox-circle .custom-control-label::before { border-radius: 50% !important; border: 2px solid #cbd5e1; width: 1.1rem; height: 1.1rem; cursor: pointer; top: 0.2rem; left: -1.5rem;}
    .custom-checkbox-circle .custom-control-label::after { width: 1.1rem; height: 1.1rem; cursor: pointer; top: 0.2rem; left: -1.5rem;}
    .custom-checkbox-circle .custom-control-input:checked ~ .custom-control-label::before { background-color: #2563eb; border-color: #2563eb; }

    /* ================= MODAL & FORM SAAS MODERN ================= */
    .modal-content { border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .modal-header { border-bottom: 1px solid #f1f5f9; padding: 25px 30px; border-radius: 20px 20px 0 0; background: #fff; }
    .modal-body { padding: 30px; }
    .modal-footer { border-top: 1px solid #f1f5f9; padding: 20px 30px; background: #f8fafc; border-radius: 0 0 20px 20px; }
    
    .modal-xl { max-width: 1000px; }
    .form-label-modern { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block; }
    .form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; background-color: #f8fafc; transition: all 0.3s ease; color: #334155; font-size: 0.9rem; width: 100%; height: auto;}
    .form-control-modern:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); outline: none; }
    textarea.form-control-modern { min-height: 100px; resize: vertical; }
    select.form-control-modern { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; padding-right: 40px; }
    
    .section-badge { display: inline-flex; align-items: center; background: #eff6ff; color: #2563eb; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; margin-bottom: 20px; }
    .section-badge.warning { background: #fef3c7; color: #d97706; }
    
    .border-right-dashed { border-right: 2px dashed #f1f5f9; }
    @media (max-width: 991px) { .border-right-dashed { border-right: none; border-bottom: 2px dashed #f1f5f9; margin-bottom: 30px; padding-bottom: 30px; } }

    /* CUSTOM FILE UPLOAD DRAG & DROP STYLE */
    .file-upload-wrapper { position: relative; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 30px 20px; text-align: center; background-color: #f8fafc; transition: all 0.3s ease; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .file-upload-wrapper:hover { border-color: #3b82f6; background-color: #eff6ff; }
    .file-upload-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10; }
    .file-icon-large { font-size: 2.5rem; color: #94a3b8; margin-bottom: 10px; transition: 0.3s; }
    .file-upload-wrapper:hover .file-icon-large { color: #3b82f6; transform: translateY(-5px); }
    .file-upload-text { font-size: 0.9rem; color: #475569; font-weight: 600; margin-bottom: 5px; }
    .file-upload-info { font-size: 0.75rem; color: #94a3b8; }

    /* ================= SAAS PAGINATION ================= */
    .pagination { margin-bottom: 0; gap: 6px; }
    .page-item .page-link { border: none; border-radius: 10px; color: #64748b; font-weight: 600; font-size: 0.85rem; padding: 8px 16px; transition: all 0.3s ease; background: transparent; }
    .page-item .page-link:hover { background-color: #f1f5f9; color: #0f172a; transform: translateY(-2px); }
    .page-item.active .page-link { background-color: #2563eb; color: #fff; box-shadow: 0 6px 15px -3px rgba(37, 99, 235, 0.4); }
    .page-item.disabled .page-link { color: #cbd5e1; background: transparent; pointer-events: none; }

    /* ================= TOAST NOTIFICATION MODERN ================= */
    .custom-toast-container { position: fixed; top: 30px; right: -400px; background-color: #ffffff; padding: 20px 45px 20px 25px; border-radius: 16px; box-shadow: 0 15px 40px -5px rgba(0,0,0,0.15); display: flex; align-items: center; width: 380px; z-index: 99999; transition: right 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); overflow: hidden; }
    .custom-toast-container.show { right: 30px; }
    .toast-icon-circle { width: 48px; height: 48px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.4rem; flex-shrink: 0; margin-right: 18px; }
    .toast-success .toast-icon-circle { background-color: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
    .toast-error .toast-icon-circle { background-color: #ef4444; color: white; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }
    .toast-text-area h4 { font-size: 1.1rem; font-weight: 800; margin: 0 0 3px 0; color: #1e293b; letter-spacing: 0.5px; }
    .toast-text-area p { font-size: 0.85rem; color: #64748b; margin: 0; line-height: 1.4; }
    .toast-close-btn { position: absolute; top: 15px; right: 15px; background: transparent; border: none; color: #94a3b8; font-size: 1rem; cursor: pointer; transition: 0.2s; }
    .toast-close-btn:hover { color: #475569; }
    .toast-progress-bar { position: absolute; bottom: 0; left: 0; height: 5px; width: 100%; background-color: #10b981; animation: toastProgress 3s linear forwards; }
    .toast-error .toast-progress-bar { background-color: #ef4444; }
    @keyframes toastProgress { 0% { width: 100%; } 100% { width: 0%; } }

    /* ================= RESPONSIVITAS MOBILE (SMARTPHONE) ================= */
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
        .top-navbar-sticky h3 { font-size: 1.15rem !important; }
        .top-navbar-sticky small { font-size: 0.7rem !important; }
        .saas-card { border-radius: 16px; }
        
        .user-profile-text { display: none !important; }
    }
</style>

@if(session('success'))
<div id="elegantToast" class="custom-toast-container toast-success">
    <button class="toast-close-btn" onclick="tutupToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-icon-circle"><i class="fa-solid fa-check"></i></div>
    <div class="toast-text-area">
        <h4>SUKSES!</h4>
        <p>{{ session('success') }}</p>
    </div>
    <div class="toast-progress-bar"></div>
</div>
@endif

@if($errors->any())
<div id="elegantToast" class="custom-toast-container toast-error">
    <button class="toast-close-btn" onclick="tutupToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-icon-circle"><i class="fa-solid fa-xmark"></i></div>
    <div class="toast-text-area">
        <h4>PERHATIAN!</h4>
        <p>{{ $errors->first() }}</p>
    </div>
    <div class="toast-progress-bar"></div>
</div>
@endif

<div class="dashboard-wrapper">
    @include('layouts.sidebar')

    <div class="main-content">
        
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <div class="top-navbar-sticky d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <a href="{{ route('arsip.index', $kategori->id) }}" class="btn-back-modern" title="Kembali">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Koleksi Arsip: {{ $kategori->nama_kategori }}</h3>
                    <small style="color: #64748b; font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px;">
                        {{ $kategori->deskripsi }}
                    </small>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="text-right mr-3 d-none d-md-block user-profile-text">
                    <div class="font-weight-bold" style="color: #0f172a; font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                    <div style="color: #64748b; font-size: 0.8rem; font-weight: 500;">{{ Auth::user()->email }}</div>
                </div>
                <div class="shadow-sm" style="width: 45px; height: 45px; font-size: 1.2rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; background-color: #fff; color: #C8A35A; border: 1px solid #e2e8f0; overflow: hidden;">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/profil/' . Auth::user()->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-user-shield"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="saas-card mb-5">
            <div class="px-4 py-4 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h5 class="font-weight-bold mb-0" style="color: #1e293b; font-size: 1.25rem;">
                            <i class="fa-solid fa-circle-info text-primary mr-2"></i>Detail Uraian Arsip
                        </h5>
                        <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.9rem;">Informasi lengkap tentang arsip dokumen ini.</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        @if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
                        <a href="{{ route('arsip.edit', [$kategori->id, $arsip->id]) }}" class="btn btn-warning text-dark font-weight-bold mr-2" style="border-radius: 8px; font-size: 0.85rem;">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Arsip
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="row">
                    <!-- Detail Kiri -->
                    <div class="col-md-5 border-right pr-4">
                        <h6 class="font-weight-bold text-primary mb-3" style="font-size: 0.9rem;"><i class="fa-solid fa-list-check mr-2"></i>Spesifikasi Berkas</h6>
                        <table class="table table-borderless table-sm mb-0" style="font-size: 0.85rem;">
                            <tr>
                                <td width="45%" class="text-muted font-weight-bold pb-3">KODE KLASIFIKASI</td>
                                <td class="pb-3">: <strong class="text-dark">{{ Auth::user()->subbagian->kode_klasifikasi }}.{{ $arsip->nomor_dokumen }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">NAMA BERKAS</td>
                                <td class="pb-3">: <span class="text-dark font-weight-bold">{{ $arsip->nama_arsip }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">TAHUN & JUMLAH</td>
                                <td class="pb-3">: {{ $arsip->tahun_berkas ?? '-' }} ({{ $arsip->jumlah_berkas }} Berkas)</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">JADWAL RETENSI</td>
                                <td class="pb-3">: Aktif ({{ $arsip->retensi_aktif ?? '-' }} Thn) | Inaktif ({{ $arsip->retensi_inaktif ?? '-' }} Thn)</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">STATUS JRA</td>
                                <td class="pb-3">: 
                                    @if($arsip->status_retensi == 'Musnah') <span class="badge-modern badge-red">Telah Musnah</span>
                                    @elseif($arsip->status_retensi == 'Permanen') <span class="badge-modern badge-blue">Permanen</span>
                                    @elseif($arsip->status_retensi == 'Inaktif') <span class="badge-modern badge-yellow">Inaktif</span>
                                    @else <span class="badge-modern badge-green">Aktif</span> @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">NASIB AKHIR</td>
                                <td class="pb-3">: {{ $arsip->nasib_akhir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">LOKASI FISIK</td>
                                <td class="pb-3">: {{ $arsip->lokasi_fisik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">WARNA BERKAS</td>
                                <td class="pb-3">: <span class="badge badge-light border">{{ $arsip->warna_berkas ?? '-' }}</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Detail Kanan -->
                    <div class="col-md-7 pl-4 d-flex flex-column">
                        <div class="flex-grow-1">
                            <h6 class="font-weight-bold text-warning mb-3" style="font-size: 0.9rem;"><i class="fa-solid fa-align-left mr-2"></i>Uraian Deskripsi</h6>
                            <div class="p-4 rounded shadow-sm" style="background: #f8fafc; min-height: 180px; font-size: 0.9rem; line-height: 1.7; border: 1px solid #e2e8f0; border-left: 4px solid #C8A35A;">{{ $arsip->keterangan ?? 'Tidak ada deskripsi yang dilampirkan.' }}</div>
                        </div>
                        
                        <div class="mt-4">
                            @if($arsip->file_dokumen)
                                <a href="{{ asset('storage/arsip_dokumen/'.$arsip->file_dokumen) }}" target="_blank" class="btn btn-primary-modern w-100 justify-content-center py-3" style="font-size: 0.95rem; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);">
                                    <i class="fa-solid fa-file-signature mr-2"></i> Buka / Unduh File Digital
                                </a>
                            @else
                                <button class="btn w-100 py-3 font-weight-bold" style="background: #f1f5f9; color: #94a3b8; border-radius: 10px; cursor: not-allowed; font-size: 0.95rem;" disabled>
                                    <i class="fa-solid fa-ban mr-2"></i> Tidak Ada File Digital
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
        document.querySelector('.sidebar-overlay').classList.toggle('show');
    }
    function tutupToast() {
        const toast = document.getElementById('elegantToast');
        if (toast) {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 500);
        }
    }
    window.addEventListener('load', function() {
        const toast = document.getElementById('elegantToast');
        if (toast) {
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => { tutupToast(); }, 3000);
        }
    });
</script>
@endsection
