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

    /* ================= TAB PILLS MODERN ================= */
    .custom-pills { background: #e2e8f0; padding: 6px; border-radius: 14px; display: inline-flex; }
    .custom-pills .nav-link { border-radius: 10px; color: #64748b; font-weight: 600; font-size: 0.85rem; padding: 10px 24px; border: none; transition: 0.3s; background: transparent; display: flex; align-items: center; white-space: nowrap;}
    .custom-pills .nav-link:hover { color: #334155; }
    .custom-pills .nav-link.active { background-color: #fff; color: #2563eb; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

    /* ================= SAAS COMPONENTS ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); overflow: hidden; position: relative; }

    /* TABLE SAAS */
    .table-modern th { border-top: none; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; padding: 16px 20px; font-weight: 700; background: #fafbfc; white-space: nowrap;}
    .table-modern td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 15px 20px; color: #334155; font-size: 0.85rem; }
    .table-modern tr:hover td { background-color: #f8fafc; }

    /* BADGE & ICONS */
    .badge-modern { padding: 5px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 600; display: inline-flex; align-items: center; white-space: nowrap; }
    .badge-blue { background-color: #eff6ff; color: #2563eb; }
    .badge-gray { background-color: #f1f5f9; color: #475569; }

    /* ACTION BUTTONS */
    .btn-action-square { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; cursor: pointer; font-size: 0.9rem; margin: 0 3px;}
    .btn-restore { color: #fff; background: #10b981; } .btn-restore:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
    .btn-delete { color: #fff; background: #ef4444; } .btn-delete:hover { background: #dc2626; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }

    /* TEXT TRUNCATE */
    .text-truncate-wrapper { min-width: 0; flex: 1; padding-right: 10px; }
    .text-truncate-custom { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal; line-height: 1.3; max-width: 100%; }

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
        .user-profile-text { display: none !important; }
        
        /* Nav Pills bisa discroll ke samping di HP */
        .custom-pills-container { overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 5px; }
        .custom-pills { flex-wrap: nowrap; width: max-content; }
        .saas-card { border-radius: 16px; }
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
                <div>
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Manajemen Pemulihan Data</h3>
                    <small style="color: #64748b; font-weight: 500;">BPK Perwakilan Provinsi Jambi</small>
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

        <div class="custom-pills-container mb-4 pt-2">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-dokumen-tab" data-toggle="pill" href="#pills-dokumen" role="tab">
                        <i class="fa-solid fa-file-lines mr-2"></i> DOKUMEN TERBUANG 
                        @if((method_exists($arsip_sampah, 'total') ? $arsip_sampah->total() : $arsip_sampah->count()) > 0)
                            <span class="badge badge-danger ml-2" style="border-radius: 6px;">{{ method_exists($arsip_sampah, 'total') ? $arsip_sampah->total() : $arsip_sampah->count() }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-folder-tab" data-toggle="pill" href="#pills-folder" role="tab">
                        <i class="fa-solid fa-folder-open mr-2"></i> FOLDER TERBUANG 
                        @if((isset($kategori_sampah) ? (method_exists($kategori_sampah, 'total') ? $kategori_sampah->total() : $kategori_sampah->count()) : 0) > 0)
                            <span class="badge badge-warning text-dark ml-2" style="border-radius: 6px;">{{ method_exists($kategori_sampah, 'total') ? $kategori_sampah->total() : $kategori_sampah->count() }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
            
            <div class="tab-pane fade show active" id="pills-dokumen" role="tabpanel">
                <div class="saas-card">
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.1rem;">Katalog Dokumen Terbuang</h5>
                            <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.85rem;">Dokumen yang dihapus akan ditampung di sini sementara sebelum dimusnahkan.</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive bg-white">
                        <table class="table table-modern mb-0" style="table-layout: fixed; width: 100%; min-width: 700px;">
                            <thead>
                                <tr>
                                    <th width="45%" class="pl-4">IDENTITAS DOKUMEN</th>
                                    <th width="20%">WAKTU DIHAPUS</th>
                                    <th width="20%">UPLOADER</th>
                                    <th width="15%" class="text-center pr-4">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($arsip_sampah as $arsip)
                                    @php
                                        $ext = $arsip->file_dokumen ? strtolower(pathinfo($arsip->file_dokumen, PATHINFO_EXTENSION)) : '';
                                        $iconClass = 'fa-file-lines'; $iconColor = '#64748b'; $bgStyle = '#f1f5f9';
                                        
                                        if($ext) {
                                            if(in_array($ext, ['pdf'])) { $iconClass = 'fa-file-pdf'; $iconColor = '#e11d48'; $bgStyle = '#ffe4e6';}
                                            elseif(in_array($ext, ['doc', 'docx'])) { $iconClass = 'fa-file-word'; $iconColor = '#2563eb'; $bgStyle = '#eff6ff';}
                                            elseif(in_array($ext, ['xls', 'xlsx'])) { $iconClass = 'fa-file-excel'; $iconColor = '#059669'; $bgStyle = '#d1fae5';}
                                            elseif(in_array($ext, ['png', 'jpg', 'jpeg'])) { $iconClass = 'fa-file-image'; $iconColor = '#d97706'; $bgStyle = '#fef3c7';}
                                        }
                                    @endphp
                                    <tr>
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; background-color: {{ $bgStyle }}; color: {{ $iconColor }};">
                                                    <i class="fa-solid {{ $iconClass }}"></i>
                                                </div>
                                                <div class="text-truncate-wrapper">
                                                    <strong class="d-block text-dark text-truncate-custom" style="font-size: 0.95rem;" title="{{ $arsip->nama_arsip }}">{{ $arsip->nama_arsip }}</strong>
                                                    <div class="d-flex flex-wrap align-items-center mt-1" style="gap: 5px;">
                                                        <span class="badge-modern badge-gray">{{ Auth::user()->subbagian->kode_klasifikasi ?? 'XX' }}.{{ $arsip->nomor_dokumen }}</span>
                                                        <span class="badge-modern badge-blue">{{ $ext ? strtoupper($ext) : 'NO FILE' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="d-block text-danger" style="font-size: 0.85rem;">{{ $arsip->deleted_at->format('d M Y') }}</strong>
                                            <small style="color: #64748b; font-weight: 500;">Pukul {{ $arsip->deleted_at->format('H:i') }} WIB</small>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold" style="color: #334155; font-size: 0.85rem;"><i class="fa-regular fa-user mr-1 text-muted"></i> {{ Auth::user()->name }}</span>
                                        </td>
                                        <td class="text-center pr-4">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn-action-square btn-restore" title="Pulihkan Dokumen" onclick="konfirmasiPulihkan('arsip', {{ $arsip->id }})">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                </button>
                                                <button type="button" class="btn-action-square btn-delete" title="Musnahkan Permanen" onclick="konfirmasiMusnahkan('arsip', {{ $arsip->id }})">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>

                                                <form id="form-restore-arsip-{{ $arsip->id }}" action="{{ route('sampah.arsip.restore', $arsip->id) }}" method="POST" class="d-none">@csrf</form>
                                                <form id="form-force-arsip-{{ $arsip->id }}" action="{{ route('sampah.arsip.force', $arsip->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 bg-white">
                                            <div style="background: #f8fafc; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                                                <i class="fa-solid fa-file-circle-check" style="font-size: 1.8rem; color: #cbd5e1;"></i>
                                            </div>
                                            <h6 style="color: #475569; font-weight: 600; font-size: 0.9rem;">Keranjang Dokumen Bersih!</h6>
                                            <p class="small mb-0" style="color: #94a3b8;">Tidak ada arsip dokumen yang menunggu pemusnahan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(method_exists($arsip_sampah, 'hasPages') && $arsip_sampah->hasPages())
                    <div class="d-flex justify-content-end p-3 border-top bg-white" style="border-radius: 0 0 24px 24px; border-color: #f1f5f9 !important;">
                        {{ $arsip_sampah->onEachSide(1)->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="tab-pane fade" id="pills-folder" role="tabpanel">
                <div class="saas-card" style="border-top: 3px solid #f59e0b;">
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.1rem;">Katalog Folder Terbuang</h5>
                            <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.85rem;"><span class="text-danger font-weight-bold">Peringatan:</span> Memusnahkan folder akan ikut memusnahkan semua dokumen arsip di dalamnya.</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive bg-white">
                        <table class="table table-modern mb-0" style="table-layout: fixed; width: 100%; min-width: 600px;">
                            <thead>
                                <tr>
                                    <th width="50%" class="pl-4">NAMA FOLDER KLASIFIKASI</th>
                                    <th width="30%">WAKTU DIHAPUS</th>
                                    <th width="20%" class="text-center pr-4">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($kategori_sampah))
                                    @forelse($kategori_sampah as $kat)
                                        <tr>
                                            <td class="pl-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; background-color: #fef3c7; color: #d97706;">
                                                        <i class="fa-solid fa-folder-open"></i>
                                                    </div>
                                                    <div class="text-truncate-wrapper">
                                                        <strong class="d-block text-dark text-truncate-custom" style="font-size: 0.95rem;">{{ $kat->nama_kategori }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong class="d-block text-danger" style="font-size: 0.85rem;">{{ $kat->deleted_at->format('d M Y') }}</strong>
                                                <small style="color: #64748b; font-weight: 500;">Pukul {{ $kat->deleted_at->format('H:i') }} WIB</small>
                                            </td>
                                            <td class="text-center pr-4">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button type="button" class="btn-action-square btn-restore" title="Pulihkan Folder" onclick="konfirmasiPulihkan('kategori', {{ $kat->id }})">
                                                        <i class="fa-solid fa-rotate-left"></i>
                                                    </button>
                                                    <button type="button" class="btn-action-square btn-delete" title="Musnahkan Permanen" onclick="konfirmasiMusnahkan('kategori', {{ $kat->id }})">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>

                                                    <form id="form-restore-kategori-{{ $kat->id }}" action="{{ route('sampah.kategori.restore', $kat->id) }}" method="POST" class="d-none">@csrf</form>
                                                    <form id="form-force-kategori-{{ $kat->id }}" action="{{ route('sampah.kategori.force', $kat->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 bg-white">
                                                <div style="background: #f8fafc; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                                                    <i class="fa-solid fa-folder-minus" style="font-size: 1.8rem; color: #cbd5e1;"></i>
                                                </div>
                                                <h6 style="color: #475569; font-weight: 600; font-size: 0.9rem;">Tidak Ada Folder Terbuang</h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(isset($kategori_sampah) && method_exists($kategori_sampah, 'hasPages') && $kategori_sampah->hasPages())
                    <div class="d-flex justify-content-end p-3 border-top bg-white" style="border-radius: 0 0 24px 24px; border-color: #f1f5f9 !important;">
                        {{ $kategori_sampah->onEachSide(1)->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ========================================================
    // TOAST NOTIFICATION LOGIC
    // ========================================================
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

    // ========================================================
    // LOGIKA SIDEBAR MOBILE
    // ========================================================
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // ========================================================
    // SWEETALERT2: KONFIRMASI PULIHKAN & MUSNAHKAN
    // ========================================================
    function konfirmasiPulihkan(tipe, id) {
        let titleText = tipe === 'arsip' ? 'Pulihkan Dokumen?' : 'Pulihkan Folder?';
        let descText = tipe === 'arsip' ? 'Dokumen ini akan dikembalikan dengan aman ke Gudang Folder.' : 'Folder beserta isinya akan dikembalikan ke Gudang Folder.';

        Swal.fire({
            title: titleText,
            text: descText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-rotate-left mr-1"></i> Ya, Pulihkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-restore-${tipe}-${id}`).submit();
            }
        });
    }

    function konfirmasiMusnahkan(tipe, id) {
        let titleText = tipe === 'arsip' ? 'Musnahkan Dokumen?' : 'Peringatan Fatal!';
        let descText = tipe === 'arsip' 
            ? 'Dokumen beserta file digital fisiknya akan dihapus permanen dari peladen (server). Tindakan ini tidak dapat dibatalkan.' 
            : 'Memusnahkan folder ini akan ikut menghapus PERMANEN seluruh dokumen arsip di dalamnya. Anda yakin?';

        Swal.fire({
            title: titleText,
            text: descText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-fire mr-1"></i> Ya, Musnahkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-force-${tipe}-${id}`).submit();
            }
        });
    }

    // ========================================================
    // POLLING NOTIFIKASI REAL-TIME (VERIFIKASI BADGE)
    // ========================================================
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
</script>
@endsection