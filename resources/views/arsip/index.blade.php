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
    .text-truncate-custom { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal; line-height: 1.5; padding-bottom: 2px; max-width: 100%; }

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

@if(session('error'))
<div id="elegantToast" class="custom-toast-container toast-error">
    <button class="toast-close-btn" onclick="tutupToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-icon-circle"><i class="fa-solid fa-xmark"></i></div>
    <div class="toast-text-area">
        <h4>GAGAL!</h4>
        <p>{{ session('error') }}</p>
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
                <a href="{{ route('kategori.index') }}" class="btn-back-modern" title="Kembali">
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
            
            <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-white flex-wrap" style="border-bottom: 1px solid #f1f5f9;">
                <div class="w-100 mb-4">
                    <h5 class="font-weight-bold mb-0" style="color: #1e293b; font-size: 1.1rem;">Daftar Berkas Terdaftar</h5>
                    <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.85rem;" id="tableDescription">Kelola dokumen di dalam folder klasifikasi ini secara detail.</p>
                </div>
                
                <div class="d-flex align-items-center flex-wrap" style="gap: 15px;">
                    <button type="button" id="btnToggleMode" class="btn btn-secondary border-0 btn-sm font-weight-bold shadow-sm" style="border-radius: 8px; color: #ffffff; padding: 8px 15px; font-size: 0.85rem; white-space: nowrap;" onclick="toggleSelectionMode()">
                        <i class="fa-solid fa-list-check mr-1"></i> Pilih Massal
                    </button>

                    <button type="button" id="btnHapusMassal" class="btn btn-danger btn-sm font-weight-bold shadow-sm" style="display: none; border-radius: 8px; padding: 8px 15px; font-size: 0.85rem; white-space: nowrap; color: #ffffff;" onclick="konfirmasiHapusMassal()">
                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus (<span id="countTerpilih">0</span>)
                    </button>
                    
                    <a href="{{ route('arsip.export_pdf', array_merge(['kategori_id' => $kategori->id], request()->query())) }}" class="btn btn-sm shadow-sm" style="background-color: #ef4444; color: #ffffff; border-radius: 8px; padding: 8px 15px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; text-decoration: none; border: none; transition: 0.3s;" onmouseover="this.style.backgroundColor='#dc2626'; this.style.transform='translateY(-2px)'" onmouseout="this.style.backgroundColor='#ef4444'; this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-file-pdf mr-1"></i> Unduh PDF
                    </a>

                    <a href="{{ route('arsip.export_excel', array_merge(['kategori_id' => $kategori->id], request()->query())) }}" class="btn btn-sm shadow-sm" style="background-color: #22c55e; color: #ffffff; border-radius: 8px; padding: 8px 15px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; text-decoration: none; border: none; transition: 0.3s;" onmouseover="this.style.backgroundColor='#16a34a'; this.style.transform='translateY(-2px)'" onmouseout="this.style.backgroundColor='#22c55e'; this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-file-excel mr-1"></i> Unduh Excel
                    </a>

                    <button type="button" class="btn btn-sm shadow-sm" style="background-color: #3b82f6; color: #ffffff; border-radius: 8px; padding: 8px 15px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; text-decoration: none; border: none; transition: 0.3s;" onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-2px)'" onmouseout="this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(0)'" data-toggle="modal" data-target="#importExcelModal">
                        <i class="fa-solid fa-upload mr-1"></i> Import Excel
                    </button>

                    <span id="badgeTotal" class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 0.85rem;">
                        Total: {{ method_exists($arsips, 'total') ? $arsips->total() : $arsips->count() }}
                    </span>

                    <a href="{{ route('arsip.create', $kategori->id) }}" id="btnRegistrasi" class="btn btn-primary-modern btn-sm" style="padding: 8px 15px; border-radius: 8px; font-size: 0.85rem; text-decoration: none; color: #ffffff;">
                        <i class="fa-solid fa-plus mr-1"></i> Registrasi Arsip
                    </a>
                </div>
            </div>

            <div class="filter-wrapper">
                <form action="{{ route('arsip.index', $kategori->id) }}" method="GET" id="filterForm" class="m-0">
                    <div class="filter-flex-container">
                        
                        <div style="flex: 1 1 200px;">
                            <div class="input-group align-items-center" style="border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; overflow: hidden; height: 36px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0" style="padding-right: 10px; padding-left: 15px;"><i class="fa-solid fa-magnifying-glass" style="color: #94a3b8; font-size: 0.75rem;"></i></span>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 shadow-none pl-0 bg-white" placeholder="Cari nama arsip..." style="font-family: 'Poppins'; font-size: 0.75rem; height: 100%;">
                                @if(request('search'))
                                    <div class="input-group-append">
                                        <a href="{{ route('arsip.index', $kategori->id) }}" class="input-group-text bg-white border-0 text-danger" style="text-decoration: none;"><i class="fa-solid fa-xmark"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div style="flex: 0 0 110px;">
                            <select name="per_page" class="form-control filter-input-modern w-100" onchange="document.getElementById('filterForm').submit()">
                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Baris</option>
                                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 Baris</option>
                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Baris</option>
                                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Baris</option>
                            </select>
                        </div>

                        <div style="flex: 0 0 150px;">
                            <select name="status_jra" class="form-control filter-input-modern w-100" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Status JRA (Semua)</option>
                                <option value="Inaktif" {{ request('status_jra') == 'Inaktif' ? 'selected' : '' }}>Masa Inaktif</option>
                                <option value="Aktif" {{ request('status_jra') == 'Aktif' ? 'selected' : '' }}>Masa Aktif</option>
                                <option value="Musnah" {{ request('status_jra') == 'Musnah' ? 'selected' : '' }}>Telah Musnah</option>
                                <option value="Permanen" {{ request('status_jra') == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                            </select>
                        </div>

                        <div style="flex: 0 0 150px;">
                            <select name="status_file" class="form-control filter-input-modern w-100" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Status File (Semua)</option>
                                <option value="ada" {{ request('status_file') == 'ada' ? 'selected' : '' }}>Ada File Digital</option>
                                <option value="tidak" {{ request('status_file') == 'tidak' ? 'selected' : '' }}>Hanya Registrasi</option>
                            </select>
                        </div>

                        <div style="flex: 0 0 170px;">
                            <select name="lokasi_fisik" class="form-control filter-input-modern w-100" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Lokasi Fisik (Semua)</option>
                                <option value="Internal Subbagian" {{ request('lokasi_fisik') == 'Internal Subbagian' ? 'selected' : '' }}>Internal</option>
                                <option value="Diserahkan ke Umum" {{ request('lokasi_fisik') == 'Diserahkan ke Umum' ? 'selected' : '' }}>Ke Bagian Umum</option>
                            </select>
                        </div>
                        
                        @if(request('search') || request('status_jra') || request('status_file') || request('lokasi_fisik') || request('per_page'))
                            <div style="flex: 0 0 36px;">
                                <a href="{{ route('arsip.index', $kategori->id) }}" class="btn btn-white border d-flex align-items-center justify-content-center" style="border-radius: 8px; height: 36px; width: 36px; background: #fff;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right text-danger" style="font-size: 0.85rem;"></i>
                                </a>
                            </div>
                        @endif

                    </div>
                </form>
            </div>

            <div class="table-responsive bg-white">
                <table class="table table-modern mb-0" style="table-layout: fixed; width: 100%; min-width: 800px;">
                    <thead>
                        <tr>
                            <th width="4%" class="checkbox-column text-center">
                                <div class="custom-control custom-checkbox custom-checkbox-circle d-flex justify-content-center">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label" for="checkAll" style="margin-right: -1.5rem;"></label>
                                </div>
                            </th>
                            <th width="4%" class="number-column text-center">NO</th>
                            <th width="38%" class="text-center">IDENTITAS DOKUMEN</th>
                            <th width="22%">TAHUN & RETENSI</th>
                            <th width="14%" class="text-center">STATUS FILE</th>
                            <th width="18%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arsips as $arsip)
                            <tr>
                                <td class="checkbox-column text-center bg-light">
                                    <div class="custom-control custom-checkbox custom-checkbox-circle mt-1 d-flex justify-content-center">
                                        <input type="checkbox" class="custom-control-input checkItem" name="ids[]" value="{{ $arsip->id }}" id="checkItem{{ $arsip->id }}">
                                        <label class="custom-control-label" for="checkItem{{ $arsip->id }}" style="margin-right: -1.5rem;"></label>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-muted text-center number-column" style="font-size: 0.75rem;">{{ $loop->iteration }}</td>
                                
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="mr-3" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; background-color: #f1f5f9; color: #475569;">
                                            @php
                                                $ext = $arsip->file_dokumen ? strtolower(pathinfo($arsip->file_dokumen, PATHINFO_EXTENSION)) : '';
                                                $iconClass = 'fa-folder-closed'; $iconColor = '#475569';
                                                if($ext) {
                                                    if(in_array($ext, ['pdf'])) { $iconClass = 'fa-file-pdf'; $iconColor = '#e11d48'; }
                                                    elseif(in_array($ext, ['doc', 'docx'])) { $iconClass = 'fa-file-word'; $iconColor = '#2563eb'; }
                                                    elseif(in_array($ext, ['xls', 'xlsx'])) { $iconClass = 'fa-file-excel'; $iconColor = '#059669'; }
                                                    elseif(in_array($ext, ['png', 'jpg', 'jpeg'])) { $iconClass = 'fa-file-image'; $iconColor = '#d97706'; }
                                                }
                                            @endphp
                                            <i class="fa-solid {{ $iconClass }}" style="color: {{ $iconColor }};"></i>
                                        </div>
                                        <div class="text-truncate-wrapper">
                                            <a href="#" data-toggle="modal" data-target="#modalDetail{{ $arsip->id }}" class="font-weight-bold mb-1 text-truncate-custom" style="color: #1e293b; text-decoration: none; font-size: 0.8rem;" title="{{ $arsip->nama_arsip }}">
                                                {{ $arsip->nama_arsip }}
                                            </a>
                                            <div class="d-flex flex-wrap align-items-center" style="gap: 4px;">
                                                <span class="badge-modern badge-gray">{{ Auth::user()->subbagian->kode_klasifikasi }}.{{ $arsip->nomor_dokumen }}</span>
                                                <span class="badge-modern badge-blue"><i class="fa-solid fa-location-dot mr-1" style="font-size: 0.55rem;"></i>{{ $arsip->lokasi_fisik ?? 'Belum Diatur' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong class="d-block text-dark" style="font-size: 0.75rem; margin-bottom: 4px;">Tahun {{ $arsip->tahun_berkas ?? '-' }}</strong>
                                    @if($arsip->status_retensi == 'Musnah')
                                        <span class="badge-modern badge-red"><i class="fa-solid fa-fire mr-1" style="font-size: 0.6rem;"></i> Telah Musnah</span>
                                    @elseif($arsip->status_retensi == 'Permanen')
                                        <span class="badge-modern badge-blue"><i class="fa-solid fa-building-columns mr-1" style="font-size: 0.6rem;"></i> Permanen</span>
                                    @elseif($arsip->status_retensi == 'Inaktif')
                                        <span class="badge-modern badge-yellow">Inaktif ({{ $arsip->retensi_inaktif }} Thn)</span>
                                    @elseif($arsip->status_retensi == 'Aktif')
                                        <span class="badge-modern badge-green">Aktif ({{ $arsip->retensi_aktif }} Thn)</span>
                                    @else
                                        <span class="badge-modern badge-gray">Belum Diatur</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($arsip->file_dokumen)
                                        <span class="badge-modern badge-green">Ada File</span>
                                    @else
                                        <span class="badge-modern badge-yellow">Hanya Registrasi</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn-action-square btn-qr" title="Scan QR Code" data-toggle="modal" data-target="#modalQR{{ $arsip->id }}">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>
                                        <a href="{{ route('arsip.show', [$kategori->id, $arsip->id]) }}" class="btn-action-square btn-detail" title="Detail Arsip">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('arsip.edit', [$kategori->id, $arsip->id]) }}" class="btn-action-square btn-edit" title="Edit Arsip">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form id="form-hapus-arsip-{{ $arsip->id }}" action="{{ route('arsip.destroy', [$kategori->id, $arsip->id]) }}" method="POST" class="m-0 p-0 d-inline-block">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-action-square btn-delete" title="Hapus Arsip" onclick="konfirmasiHapusArsip({{ $arsip->id }})">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 bg-white">
                                    <div style="background: #f8fafc; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                                        <i class="fa-regular fa-folder-open" style="font-size: 1.8rem; color: #cbd5e1;"></i>
                                    </div>
                                    <h6 style="color: #475569; font-weight: 600; font-size: 0.85rem;">Belum Ada Dokumen Tersimpan</h6>
                                    <p class="small mb-0" style="color: #94a3b8;">Silakan klik "Registrasi Arsip" untuk menambah catatan dokumen.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($arsips, 'hasPages') && $arsips->hasPages())
            <div class="p-3 bg-white border-top d-flex justify-content-end" style="border-radius: 0 0 24px 24px;">
                {{ $arsips->onEachSide(1)->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
            @endif
            
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahArsip" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header bg-white px-5 pt-5 pb-4 border-0">
                <h4 class="modal-title font-weight-bold" style="color: #0f172a; font-family: 'Poppins', sans-serif;">
                    <i class="fa-solid fa-file-signature text-primary mr-2"></i> Registrasi Arsip Klasifikasi Baru
                </h4>
                <button type="button" class="close" data-dismiss="modal" style="background: #f1f5f9; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; opacity: 1; color: #64748b;">&times;</button>
            </div>

            <form action="{{ route('arsip.store', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-5 pb-5 pt-0">
                    <div class="row">
                        
                        <div class="col-lg-6 pr-lg-5 border-right-dashed">
                            <div class="section-badge">
                                <i class="fa-solid fa-circle-info mr-2"></i> Informasi Utama Berkas
                            </div>

                            <div class="row">
                                <div class="col-md-5 form-group">
                                    <label class="form-label-modern">Kode Klas</label>
                                    <input type="text" class="form-control-modern" name="nomor_dokumen" placeholder="Cth: 02.01" required>
                                </div>
                                <div class="col-md-7 form-group">
                                    <label class="form-label-modern">Nama Berkas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-modern" name="nama_arsip" placeholder="Cth: Dokumen Seleksi..." required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Tahun Berkas</label>
                                    <input type="text" class="form-control-modern" name="tahun_berkas" placeholder="Cth: Januari 2019" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Jumlah (Lembar)</label>
                                    <input type="number" class="form-control-modern" name="jumlah_berkas" placeholder="1" value="1">
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label-modern">Deskripsi (Opsional)</label>
                                <textarea class="form-control-modern" name="keterangan" placeholder="Tambahkan catatan khusus mengenai arsip ini..."></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 pl-lg-5">
                            <div class="section-badge warning">
                                <i class="fa-solid fa-scale-balanced mr-2"></i> Status & Jadwal Retensi
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Retensi Aktif (Thn)</label>
                                    <input type="number" class="form-control-modern" name="retensi_aktif" placeholder="Cth: 2">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Retensi Inaktif (Thn)</label>
                                    <input type="number" class="form-control-modern" name="retensi_inaktif" placeholder="Cth: 5">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Nasib Akhir</label>
                                    <select class="form-control-modern" name="nasib_akhir">
                                        <option value="" selected>-- Pilih --</option>
                                        <option value="Musnah">Musnah</option>
                                        <option value="Permanen">Permanen</option>
                                        <option value="Dinilai Kembali">Dinilai Kembali</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Warna Map</label>
                                    <input type="text" class="form-control-modern" name="warna_berkas" placeholder="Cth: Merah / Biru">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label-modern">Lokasi Fisik Berkas</label>
                                <select class="form-control-modern" name="lokasi_fisik">
                                    <option value="Internal Subbagian">Internal Subbagian</option>
                                    <option value="Diserahkan ke Umum">Diserahkan ke Bagian Umum</option>
                                </select>
                            </div>

                            <div class="form-group mb-0 mt-4">
                                <label class="form-label-modern" style="color: #d97706;"><i class="fa-solid fa-cloud-arrow-up mr-1"></i> File Digital (Maks 5MB)</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="file-upload-input" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png,.jpeg" onchange="updateFileName(this, 'fileNameDisplayNew')">
                                    <i class="fa-solid fa-file-arrow-up file-icon-large"></i>
                                    <div class="file-upload-text" id="fileNameDisplayNew">Pilih file atau seret ke sini</div>
                                    <div class="file-upload-info">PDF, Word, Excel, JPG, PNG</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer px-5 py-4 border-0">
                    <button type="button" class="btn btn-light font-weight-bold" style="border-radius: 12px; padding: 12px 25px; color: #64748b; background: #e2e8f0; border: none;" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 12px; padding: 12px 30px; background: #2563eb; border: none; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-save mr-2"></i> Simpan Arsip
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@foreach($arsips as $arsip)
    <div class="modal fade" id="modalQR{{ $arsip->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content text-center">
                <div class="modal-body p-4">
                    <h6 class="font-weight-bold text-dark mb-3">Scan Verifikasi</h6>
                    <div class="p-3 bg-white border rounded d-inline-block mb-3 shadow-sm">
                        {!! QrCode::size(150)->generate(route('scan.arsip', $arsip->id)) !!}
                    </div>
                    <p class="text-muted small mb-0 font-weight-bold">{{ $arsip->nama_arsip }}</p>
                    <button type="button" class="btn btn-light btn-block mt-3 font-weight-bold border" style="border-radius: 8px; font-size: 0.85rem;" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


@endforeach

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // LOGIKA FILE UPLOAD MODERN
    function updateFileName(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files.length > 0) {
            display.innerHTML = `<span class="text-primary"><i class="fa-solid fa-check-circle mr-1"></i> ${input.files[0].name}</span>`;
        } else {
            display.innerHTML = 'Pilih file atau seret ke sini';
        }
    }

    // LOGIKA TOAST NOTIFICATION MODERN
    function tutupToast() {
        const toast = document.getElementById('elegantToast');
        if(toast) {
            toast.classList.remove('show');
            setTimeout(() => { toast.remove(); }, 500);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('elegantToast');
        if(toast) {
            setTimeout(() => { toast.classList.add('show'); }, 100);
            setTimeout(() => { tutupToast(); }, 3100); 
        }
    });

    // LOGIKA SIDEBAR MOBILE
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // LOGIKA SWEETALERT UNTUK HAPUS SATUAN
    function konfirmasiHapusArsip(id) {
        Swal.fire({
            title: 'Hapus Dokumen?',
            text: "Dokumen ini akan dipindahkan ke Kelola Sampah dan tidak langsung terhapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-arsip-' + id).submit();
            }
        });
    }

    // LOGIKA UI KOTAK CENTANG (CHECKBOX)
    let isSelectionMode = false;

    function toggleSelectionMode() {
        isSelectionMode = !isSelectionMode;
        
        const checkboxColumns = document.querySelectorAll('.checkbox-column');
        const numberColumns = document.querySelectorAll('.number-column');
        const btnToggle = document.getElementById('btnToggleMode');
        const descText = document.getElementById('tableDescription');
        const btnRegistrasi = document.getElementById('btnRegistrasi');
        const badgeTotal = document.getElementById('badgeTotal'); 
        
        if (isSelectionMode) {
            checkboxColumns.forEach(col => col.style.display = 'table-cell');
            numberColumns.forEach(col => col.style.display = 'none');
            
            btnToggle.innerHTML = '<i class="fa-solid fa-xmark mr-1"></i> Batal Pilih';
            btnToggle.style.background = '#e2e8f0';
            descText.innerText = "Pilih dokumen yang ingin dihapus, lalu tekan tombol Hapus merah di kanan atas.";
            descText.style.color = '#e11d48';
            
            if(btnRegistrasi) btnRegistrasi.style.display = 'none';
            if(badgeTotal) badgeTotal.style.display = 'none';

        } else {
            checkboxColumns.forEach(col => col.style.display = 'none');
            numberColumns.forEach(col => col.style.display = 'table-cell');
            
            btnToggle.innerHTML = '<i class="fa-solid fa-list-check mr-1"></i> Pilih Massal';
            btnToggle.style.background = 'transparent';
            descText.innerText = "Kelola dokumen di dalam folder klasifikasi ini secara detail.";
            descText.style.color = '#64748b';
            
            const checkAll = document.getElementById('checkAll');
            if (checkAll) checkAll.checked = false;
            document.querySelectorAll('.checkItem').forEach(item => item.checked = false);
            toggleBtnHapus();
            
            if(btnRegistrasi) btnRegistrasi.style.display = 'inline-block';
            if(badgeTotal) badgeTotal.style.display = 'inline-block';
        }
    }

    function toggleBtnHapus() {
        const checkedCount = document.querySelectorAll('.checkItem:checked').length;
        document.getElementById('countTerpilih').innerText = checkedCount;
        
        if(checkedCount > 0) { document.getElementById('btnHapusMassal').style.display = 'inline-block'; } 
        else { document.getElementById('btnHapusMassal').style.display = 'none'; }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.checkItem');

        if(checkAll) {
            checkAll.addEventListener('change', function() {
                checkItems.forEach(item => item.checked = this.checked);
                toggleBtnHapus();
            });
        }

        checkItems.forEach(item => {
            item.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.checkItem:checked').length === checkItems.length;
                if(checkAll) checkAll.checked = allChecked;
                toggleBtnHapus();
            });
        });
    });

    // LOGIKA SWEETALERT UNTUK HAPUS MASSAL
    function konfirmasiHapusMassal() {
        const checkedItems = document.querySelectorAll('.checkItem:checked');
        if (checkedItems.length === 0) return;

        Swal.fire({
            title: 'Hapus Massal?',
            text: `Apakah Anda yakin ingin memindahkan ${checkedItems.length} dokumen arsip yang dipilih ke Kelola Sampah?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus Semua',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("arsip.massDestroy", $kategori->id) }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                checkedItems.forEach(item => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = item.value;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit(); 
            }
        });
    }

    // POLLING NOTIFIKASI REAL-TIME
    // HANYA UNTUK ADMIN
    @if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
    document.addEventListener('DOMContentLoaded', function() {
        let lastKnownId = 0; 
        function updateBadge(count) {
            const badge = document.getElementById('badge-verifikasi-global');
            if(badge) {
                if(count > 0) { badge.innerText = count; badge.style.display = 'inline-block'; } 
                else { badge.style.display = 'none'; }
            }
        }
        fetch('{{ route("api.verifikasi.pending") }}').then(res => res.json()).then(data => {
            if(data.latest_id) lastKnownId = data.latest_id;
            updateBadge(data.jumlah_pending);
        });
        setInterval(function() {
            fetch('{{ route("api.verifikasi.pending") }}').then(res => res.json()).then(data => {
                updateBadge(data.jumlah_pending);
                if(data.has_new && data.latest_id > lastKnownId) {
                    lastKnownId = data.latest_id;
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true });
                    Toast.fire({ icon: 'info', title: 'Permintaan Akses Baru!', text: data.nama + ' menunggu persetujuan Anda.' });
                }
            });
        }, 3000);
    });
    @endif
</script>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-white px-4 pt-4 pb-3 border-0">
                <h5 class="modal-title font-weight-bold" style="color: #0f172a; font-family: 'Poppins', sans-serif;">
                    <i class="fa-solid fa-file-excel text-success mr-2"></i> Import Arsip dari Excel
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="background: #f1f5f9; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; opacity: 1; color: #64748b;">&times;</button>
            </div>
            
            <form action="{{ route('arsip.import', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="alert alert-info" style="border-radius: 8px; font-size: 0.85rem;">
                        <i class="fa-solid fa-info-circle mr-1"></i> Silakan unduh template excel terlebih dahulu, isi data arsip, lalu unggah kembali di sini.
                        <br>
                        <a href="{{ route('arsip.template', $kategori->id) }}" class="btn btn-sm btn-outline-info mt-2" style="border-radius: 6px;">
                            <i class="fa-solid fa-download mr-1"></i> Unduh Template Excel
                        </a>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label for="file_excel" class="font-weight-bold" style="color: #475569; font-size: 0.9rem;">Pilih File Excel (.xlsx, .csv)</label>
                        <div class="custom-file mt-1">
                            <input type="file" class="custom-file-input" id="file_excel" name="file_excel" accept=".xlsx, .xls, .csv" required>
                            <label class="custom-file-label" for="file_excel" style="border-radius: 8px;">Pilih file...</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                    <button type="submit" class="btn btn-success" style="border-radius: 8px; font-weight: 500;">
                        <i class="fa-solid fa-upload mr-1"></i> Upload dan Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file_excel');
        const fileLabel = document.querySelector('.custom-file-label');
        
        if (fileInput && fileLabel) {
            fileInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file...';
                fileLabel.textContent = fileName;
            });
        }
    });
</script>

@endsection