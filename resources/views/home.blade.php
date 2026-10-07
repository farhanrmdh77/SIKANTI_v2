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
    /* Menu Aktif dengan Biru Digital SIKANTI */
    .sidebar-menu a.active { background-color: #2563eb; color: #fff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3); }
    .sidebar-menu a.active i { color: #fff; }

    .main-content { flex-grow: 1; padding: 0 40px 80px 40px; min-height: 100vh; }
    
    /* ================= NAVBAR STICKY GLASSMORPHISM ================= */
    .top-navbar-sticky { 
        position: sticky; top: 0; background-color: rgba(244, 247, 251, 0.85); 
        -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px); 
        z-index: 999; margin: 0 -40px 30px -40px; padding: 20px 40px; 
        border-bottom: 1px solid rgba(226, 232, 240, 0.8); 
        box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.02);
    }

    /* ================= SAAS CARD & WIDGETS ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; position: relative; }
    .saas-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.12); }
    
    /* Banner Welcome BPK Emas & Navy */
    .welcome-banner { background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: white; border-radius: 24px; position: relative; overflow: hidden; border-left: 6px solid #C8A35A; box-shadow: 0 15px 30px rgba(30, 58, 138, 0.2); }
    .welcome-banner::after { content: ''; position: absolute; right: -50px; top: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(200, 163, 90, 0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none; }

    /* Widget Boxes */
    .stat-icon-box { width: 56px; height: 56px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 20px; }
    .icon-blue { background-color: #eff6ff; color: #2563eb; }
    .icon-indigo { background-color: #e0e7ff; color: #4f46e5; }
    .icon-emerald { background-color: #d1fae5; color: #059669; }
    .icon-rose { background-color: #ffe4e6; color: #e11d48; }

    .stat-value { font-size: 2.2rem; font-weight: 700; color: #0f172a; line-height: 1.2; font-family: 'Poppins', sans-serif;}
    .stat-label { font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }

    /* ================= TABLE & TIMELINE ================= */
    .table-modern th { border-top: none; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 20px; font-weight: 600; background: #f8fafc; }
    .table-modern td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 20px; color: #334155; }
    .table-modern tr:hover td { background-color: #f8fafc; }

    /* BADGE SINGLE-LINE TABEL */
    .badge-modern { padding: 5px 10px; border-radius: 6px; font-size: 0.65rem; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; line-height: 1; vertical-align: middle; }
    .badge-modern i { font-size: 0.65rem; display: flex; align-items: center; margin-top: -1px; }
    .badge-gray { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .badge-blue { background-color: #eff6ff; color: #2563eb; }
    .badge-green { background-color: #d1fae5; color: #059669; }
    .badge-yellow { background-color: #fef3c7; color: #d97706; }
    .badge-red { background-color: #ffe4e6; color: #e11d48; }

    .timeline { border-left: 2px solid #e2e8f0; padding-left: 25px; list-style: none; margin: 0 0 0 15px; }
    .timeline-item { position: relative; margin-bottom: 30px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item::before { content: ''; position: absolute; left: -32px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background-color: #2563eb; border: 3px solid #fff; box-shadow: 0 0 0 4px #eff6ff; }
    .timeline-item.danger::before { background-color: #e11d48; box-shadow: 0 0 0 4px #ffe4e6; }
    .timeline-item.success::before { background-color: #059669; box-shadow: 0 0 0 4px #d1fae5; }
    .timeline-item.warning::before { background-color: #d97706; box-shadow: 0 0 0 4px #fef3c7; }

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
                <div>
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Beranda {{ Auth::user()->role == 'Staff' ? 'Personel' : 'Eksekutif' }}</h3>
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

        <div class="welcome-banner p-5 mb-5 d-flex justify-content-between align-items-center">
            <div style="z-index: 1;">
                <h2 class="font-weight-bold mb-2" style="font-family: 'Poppins', sans-serif;">Selamat Datang kembali, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                <p class="mb-0" style="color: #94a3b8; font-size: 1.05rem; max-width: 600px;">Pusat kendali arsip Anda siap digunakan. Pantau volume dokumen dan aktivitas pergerakan klasifikasi subbagian Anda hari ini.</p>
            </div>
            <div class="d-none d-lg-block" style="z-index: 1;">
                <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); padding: 15px 25px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); min-width: 140px; text-align: center;">
                    <div style="color: #94a3b8; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; margin-bottom: 10px;">TANGGAL SISTEM</div>
                    <div style="font-size: 3.5rem; font-weight: 800; color: #fff; line-height: 0.8;">{{ \Carbon\Carbon::now()->format('d') }}</div>
                    <div style="font-size: 1.3rem; font-weight: 700; color: #fff; margin-top: 8px; line-height: 1;">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM') }}</div>
                    <div style="font-size: 1rem; font-weight: 500; color: #cbd5e1; line-height: 1.2; margin-top: 2px;">{{ \Carbon\Carbon::now()->format('Y') }}</div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="saas-card p-4 h-100">
                    <div class="stat-icon-box icon-blue"><i class="fa-solid fa-folder-tree"></i></div>
                    <div class="stat-label">Total Folder</div>
                    <div class="stat-value">{{ $total_folder ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="saas-card p-4 h-100">
                    <div class="stat-icon-box icon-indigo"><i class="fa-solid fa-file-lines"></i></div>
                    <div class="stat-label">Total Dokumen</div>
                    <div class="stat-value">{{ $total_arsip ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="saas-card p-4 h-100">
                    <div class="stat-icon-box icon-emerald"><i class="fa-solid fa-box-archive"></i></div>
                    <div class="stat-label">Retensi Aktif</div>
                    <div class="stat-value">{{ $arsip_aktif ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="saas-card p-4 h-100">
                    <div class="stat-icon-box icon-rose"><i class="fa-solid fa-fire"></i></div>
                    <div class="stat-label">Telah Musnah</div>
                    <div class="stat-value">{{ $arsip_selesai ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="saas-card p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="font-weight-bold mb-1" style="color: #0f172a;">
                                {{ Auth::user()->role == 'Superadmin' ? 'Volume Dokumen per Subbagian' : 'Volume Dokumen per Folder' }}
                            </h5>
                            <span style="color: #64748b; font-size: 0.85rem;">Statistik distribusi arsip secara Real-time</span>
                        </div>
                        <span class="badge" style="background: #eff6ff; color: #2563eb; padding: 8px 12px; border-radius: 10px; font-weight: 600;">Grafik Area</span>
                    </div>
                    <div class="flex-grow-1 position-relative" style="min-height: 320px;">
                        <canvas id="folderChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="saas-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h5 class="font-weight-bold mb-0" style="color: #0f172a;">Aktivitas Terkini</h5>
                        
                        @if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
                        <a href="{{ route('riwayat.index') }}" style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: 0.2s;">Detail</a>
                        @endif
                    </div>
                    
                    <div style="max-height: 320px; overflow-y: auto; padding-right: 15px;">
                        <ul class="timeline">
                            @php \Carbon\Carbon::setLocale('id'); @endphp
                            @forelse($riwayat_dashboard ?? [] as $log)
                                @php
                                    $timeline_color = ''; 
                                    if($log->tipe_aksi == 'CREATE') $timeline_color = 'success'; 
                                    elseif($log->tipe_aksi == 'DELETE') $timeline_color = 'danger'; 
                                    elseif($log->tipe_aksi == 'VERIFIKASI') $timeline_color = 'warning'; 
                                @endphp
                                
                                <li class="timeline-item {{ $timeline_color }}">
                                    <div style="color: #94a3b8; font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">{{ $log->created_at->diffForHumans() }}</div>
                                    <strong style="color: #1e293b; font-size: 0.95rem; display: block; margin-bottom: 2px;">
                                        {{ $log->user->name ?? 'User Terhapus' }}
                                    </strong>
                                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin: 0;">{{ $log->deskripsi }}</p>
                                </li>
                            @empty
                                <li class="timeline-item">
                                    <strong style="color: #94a3b8;">Belum ada aktivitas.</strong>
                                    <p style="color: #cbd5e1; font-size: 0.85rem;">Ruang kerja masih kosong.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="saas-card">
            <div class="p-4 border-bottom" style="border-color: #f1f5f9 !important;">
                <h5 class="font-weight-bold mb-1" style="color: #0f172a;">Registrasi Berkas Terbaru</h5>
                <p class="small mb-0" style="color: #64748b;">5 dokumen terakhir yang masuk ke dalam brankas digital.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="40%">NAMA & DESKRIPSI DOKUMEN</th>
                            <th width="20%">KODE / FOLDER</th>
                            <th width="15%" class="text-center align-middle">STATUS RETENSI</th>
                            <th width="25%">WAKTU REGISTRASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arsip_terbaru ?? [] as $arsip)
                            @php
                                // Logika Dinamis Penentuan Ikon File Berdasarkan Ekstensi
                                $ext = $arsip->file_dokumen ? strtolower(pathinfo($arsip->file_dokumen, PATHINFO_EXTENSION)) : '';
                                $iconClass = 'fa-file-lines'; // Default Icon
                                $iconColor = '#475569'; // Default Color (Slate)

                                if(in_array($ext, ['pdf'])) {
                                    $iconClass = 'fa-file-pdf';
                                    $iconColor = '#ef4444'; // Red
                                } elseif(in_array($ext, ['doc', 'docx'])) {
                                    $iconClass = 'fa-file-word';
                                    $iconColor = '#2563eb'; // Blue
                                } elseif(in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                    $iconClass = 'fa-file-excel';
                                    $iconColor = '#10b981'; // Green
                                } elseif(in_array($ext, ['ppt', 'pptx'])) {
                                    $iconClass = 'fa-file-powerpoint';
                                    $iconColor = '#f97316'; // Orange
                                } elseif(in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
                                    $iconClass = 'fa-file-image';
                                    $iconColor = '#8b5cf6'; // Purple
                                } elseif(in_array($ext, ['zip', 'rar', '7z'])) {
                                    $iconClass = 'fa-file-zipper';
                                    $iconColor = '#f59e0b'; // Amber
                                }
                            @endphp
                            
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 46px; height: 46px; border-radius: 14px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: {{ $iconColor }}; font-size: 1.2rem; margin-right: 15px;">
                                            <i class="fa-solid {{ $iconClass }}"></i>
                                        </div>
                                        <div>
                                            <strong style="color: #1e293b; font-size: 0.95rem; display: block;">{{ $arsip->nama_arsip }}</strong>
                                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 500;"><i class="fa-solid fa-location-dot mr-1 text-primary"></i>{{ $arsip->lokasi_fisik ?? 'Belum Diatur' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: #0f172a; font-weight: 700; font-size: 0.95rem; display: block;">{{ optional($arsip->subbagian)->kode_klasifikasi ?? '-' }}.{{ $arsip->nomor_dokumen }}</span>
                                    <small style="color: #64748b; font-weight: 500;">{{ optional($arsip->kategori)->nama_kategori ?? 'Folder Terhapus' }}</small>
                                </td>
                                <td class="text-center align-middle">
                                    @if($arsip->status_retensi == 'Musnah')
                                        <span class="badge-modern badge-red"><i class="fa-solid fa-fire mr-1"></i> Musnah</span>
                                    @elseif($arsip->status_retensi == 'Permanen')
                                        <span class="badge-modern badge-blue"><i class="fa-solid fa-building-columns mr-1"></i> Permanen</span>
                                    @elseif($arsip->status_retensi == 'Inaktif')
                                        <span class="badge-modern badge-yellow">Inaktif</span>
                                    @elseif($arsip->status_retensi == 'Aktif')
                                        <span class="badge-modern badge-green">Aktif</span>
                                    @else
                                        <span class="badge-modern badge-gray">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="color: #1e293b; font-weight: 600; font-size: 0.9rem;">{{ $arsip->created_at->diffForHumans() }}</div>
                                    <small style="color: #94a3b8; font-weight: 500;">{{ $arsip->created_at->format('d M Y, H:i') }} WIB</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fa-solid fa-folder-open mb-3" style="font-size: 3rem; color: #cbd5e1;"></i>
                                    <h6 style="color: #64748b; font-weight: 600;">Belum Ada Arsip</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // TOAST NOTIFICATION LOGIC
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

    // GRAFIK FOLDER LOGIC
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('folderChart');
        if(!canvas) return; // Mencegah error jika canvas tidak ada
        
        const ctx = canvas.getContext('2d');
        
        let gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
        gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.5)'); 
        gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0.0)'); 
        
        // Menyiapkan dan mengurutkan data berdasarkan abjad nomenklatur (A-Z)
        @php
            $chartData = collect($kategoris_chart ?? [])->sortBy('nama_kategori')->values();
        @endphp

        const labelsFolder = [
            @foreach($chartData as $k) '{{ $k->nama_kategori }}', @endforeach
        ];
        
        const dataJumlah = [
            @foreach($chartData as $k) {{ $k->arsips_count }}, @endforeach
        ];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsFolder,
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: dataJumlah,
                    borderColor: '#2563eb',
                    backgroundColor: gradientBlue,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { font: { family: 'Poppins', weight: '500', size: 12 }, color: '#94a3b8' },
                        grid: { display: false } 
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { family: 'Poppins', weight: '500' }, color: '#94a3b8', padding: 10 },
                        border: { display: false },
                        grid: { color: 'rgba(226, 232, 240, 0.5)', drawBorder: false }
                    }
                }
            }
        });
    });
</script>

@if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
@endif
@endsection