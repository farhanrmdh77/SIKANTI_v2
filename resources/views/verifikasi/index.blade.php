@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    #app > nav { display: none !important; }
    #app > main { padding-top: 0 !important; padding-bottom: 0 !important; }
    body { background-color: #f4f7fb; font-family: 'Poppins', sans-serif; overflow-x: hidden; margin: 0; color: #334155; }

    .dashboard-wrapper { display: flex; min-height: 100vh; width: 100%; }
    
    /* ================= SIDEBAR SAAS STYLE (100% KONSISTEN) ================= */
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
    .custom-pills .nav-link { border-radius: 10px; color: #64748b; font-weight: 600; font-size: 0.85rem; padding: 10px 24px; border: none; transition: 0.3s; background: transparent; }
    .custom-pills .nav-link:hover { color: #334155; }
    .custom-pills .nav-link.active { background-color: #fff; color: #2563eb; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

    /* ================= KARTU PERMINTAAN SAAS ================= */
    .request-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 24px; padding: 24px; margin-bottom: 20px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative; overflow: hidden;}
    .request-card:hover { border-color: #cbd5e1; box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.15); transform: translateY(-5px);}
    .applicant-box { background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 16px; padding: 15px 20px; margin-top: 20px; }

    /* BADGE MODERN */
    .badge-modern { padding: 5px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; white-space: nowrap; margin: 0;}
    .badge-gray { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .badge-blue { background-color: #eff6ff; color: #2563eb; }
    .badge-green { background-color: #d1fae5; color: #059669; }
    .badge-yellow { background-color: #fef3c7; color: #d97706; }
    .badge-red { background-color: #ffe4e6; color: #e11d48; }

    /* MODAL SAAS */
    .modal-content { border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .modal-header { border-bottom: 1px solid #f1f5f9; padding: 25px 30px; border-radius: 24px 24px 0 0; background: #fff; }
    .modal-body { padding: 30px; }
    .modal-footer { border-top: 1px solid #f1f5f9; padding: 20px 30px; background: #f8fafc; border-radius: 0 0 24px 24px; }
    .form-control-modern { border-radius: 12px; border: 1px solid #cbd5e1; padding: 12px 15px; font-family: 'Poppins'; color: #334155; transition: 0.3s; background: #f8fafc; font-size: 0.85rem;}
    .form-control-modern:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); outline: none; }
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 10px 20px; font-size: 0.85rem; transition: 0.3s; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }

    /* ================= TOAST NOTIFICATION MODERN ================= */
    .custom-toast-container { position: fixed; top: 30px; right: -400px; background-color: #ffffff; padding: 20px 45px 20px 25px; border-radius: 16px; box-shadow: 0 15px 40px -5px rgba(0,0,0,0.15); display: flex; align-items: center; width: 380px; z-index: 99999; transition: right 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); overflow: hidden; }
    .custom-toast-container.show { right: 30px; }
    .toast-icon-circle { width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.3rem; flex-shrink: 0; margin-right: 18px; }
    .toast-success .toast-icon-circle { background-color: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
    .toast-error .toast-icon-circle { background-color: #ef4444; color: white; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }
    .toast-text-area h4 { font-size: 1rem; font-weight: 800; margin: 0 0 4px 0; color: #1e293b; letter-spacing: 0.5px; }
    .toast-text-area p { font-size: 0.85rem; color: #6b7280; margin: 0; line-height: 1.4; }
    .toast-close-btn { position: absolute; top: 15px; right: 15px; background: transparent; border: none; color: #94a3b8; font-size: 1rem; cursor: pointer; transition: 0.2s; }
    .toast-close-btn:hover { color: #475569; }
    .toast-progress-bar { position: absolute; bottom: 0; left: 0; height: 4px; width: 100%; background-color: #10b981; animation: toastProgress 3s linear forwards; }
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
        
        .request-card { padding: 15px; border-radius: 16px; }
        .applicant-box { padding: 12px; }
        .custom-pills { overflow-x: auto; white-space: nowrap; width: 100%; }
        
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
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Loket Verifikasi Akses</h3>
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

        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center" id="pills-tertunda-tab" data-toggle="pill" href="#pills-tertunda" role="tab">
                        TERTUNDA @if($menunggu->count() > 0) <span class="badge badge-danger ml-2" style="border-radius: 6px;">{{ $menunggu->count() }}</span> @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="pills-disetujui-tab" data-toggle="pill" href="#pills-disetujui" role="tab">
                        DISETUJUI @if($disetujui->count() > 0) <span class="badge badge-gray ml-2">{{ $disetujui->count() }}</span> @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="pills-ditolak-tab" data-toggle="pill" href="#pills-ditolak" role="tab">
                        DITOLAK @if($ditolak->count() > 0) <span class="badge badge-gray ml-2">{{ $ditolak->count() }}</span> @endif
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
            
            <div class="tab-pane fade show active" id="pills-tertunda" role="tabpanel">
                @forelse($menunggu as $req)
                    <div class="request-card" style="border-left: 4px solid #f59e0b;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <span class="badge-modern badge-yellow mb-2"><i class="fa-solid fa-qrcode mr-1"></i> Permintaan Pemindaian QR</span>
                                <small class="text-muted ml-2 font-weight-bold" style="font-size: 0.7rem;"><i class="fa-regular fa-clock mr-1"></i> {{ $req->created_at->format('d M, H:i') }}</small>
                                <h5 class="font-weight-bold mb-1 mt-1" style="color: #0f172a; font-size: 1.1rem;">{{ $req->arsip->nama_arsip }}</h5>
                                <div class="text-muted" style="font-size: 0.8rem; font-weight: 500;">
                                    <span class="mr-2"><i class="fa-solid fa-hashtag mr-1"></i>{{ $req->arsip->nomor_dokumen }}</span>
                                    <span><i class="fa-regular fa-folder mr-1"></i>{{ optional($req->arsip->kategori)->nama_kategori }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-white font-weight-bold text-danger mr-2" data-toggle="modal" data-target="#modalTolak{{ $req->id }}" style="border-radius: 10px; font-size: 0.85rem; border: 1px solid #e2e8f0; padding: 8px 16px; background: #fff; transition: 0.2s;" onmouseover="this.style.background='#ffe4e6'; this.style.borderColor='#fda4af';" onmouseout="this.style.background='#fff'; this.style.borderColor='#e2e8f0';">Tolak</button>
                                
                                <button class="btn btn-primary-modern" data-toggle="modal" data-target="#modalSetuju{{ $req->id }}">Setujui Akses</button>
                            </div>
                        </div>

                        <div class="applicant-box d-flex align-items-start">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; margin-right: 15px;">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold text-dark" style="font-size: 0.9rem;">{{ $req->nama_pemohon }} <span class="badge badge-light border text-muted ml-1" style="font-weight: 500;">Bag. {{ $req->subbagian_pemohon }}</span></div>
                                <div style="color: #64748b; font-size: 0.8rem; margin-top: 4px; font-style: italic;">"{{ $req->tujuan_akses }}"</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalSetuju{{ $req->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1rem;"><i class="fa-solid fa-check-circle text-success mr-2"></i>Verifikasi & Izinkan Akses</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form action="{{ route('verifikasi.approve', $req->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-4 p-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                            <div class="custom-control custom-switch mb-2">
                                                <input type="checkbox" class="custom-control-input" id="izinUnduh{{ $req->id }}" name="izin_unduh" value="1">
                                                <label class="custom-control-label" for="izinUnduh{{ $req->id }}" style="cursor: pointer;"></label>
                                            </div>
                                            
                                            <label for="izinUnduh{{ $req->id }}" style="cursor: pointer; display: block; margin: 0;">
                                                <div class="font-weight-bold text-dark" style="font-size: 0.85rem;">Beri Akses Unduh Dokumen Digital</div>
                                                <div class="small text-muted mt-1" style="font-size: 0.75rem; font-weight: normal;">Centang jika pemohon diizinkan mengunduh file (PDF/DOC) dari sistem.</div>
                                            </label>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="text-muted small font-weight-bold text-uppercase">Tinggalkan Catatan (Opsional)</label>
                                            <input type="text" class="form-control form-control-modern" name="catatan_admin" placeholder="Cth: Disetujui untuk diakses sesuai ketentuan.">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light font-weight-bold border" data-dismiss="modal" style="border-radius: 10px; font-size: 0.85rem;">Batal</button>
                                        <button type="submit" class="btn btn-primary-modern">Berikan Izin Akses</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalTolak{{ $req->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold text-danger" style="font-size: 1rem;"><i class="fa-solid fa-ban mr-2"></i>Tolak Akses Pemohon</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form action="{{ route('verifikasi.reject', $req->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group mb-0">
                                            <label class="text-muted small font-weight-bold text-uppercase">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control form-control-modern" name="catatan_admin" rows="3" placeholder="Sebutkan alasan agar pemohon mengetahuinya..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light font-weight-bold border" data-dismiss="modal" style="border-radius: 10px; font-size: 0.85rem;">Batal</button>
                                        <button type="submit" class="btn text-white font-weight-bold" style="background: #ef4444; border-radius: 10px; padding: 10px 18px; font-size: 0.85rem;">Konfirmasi Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div style="background: #f8fafc; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                            <i class="fa-solid fa-shield-cat" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                        </div>
                        <h6 class="font-weight-bold text-secondary mb-1">Tidak Ada Antrean Verifikasi</h6>
                        <p class="small mb-0" style="color: #94a3b8;">Semua permintaan akses dokumen dari pegawai telah diselesaikan.</p>
                    </div>
                @endforelse
            </div>

            <div class="tab-pane fade" id="pills-disetujui" role="tabpanel">
                @forelse($disetujui as $req)
                    <div class="request-card" style="border-left: 4px solid #10b981;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="mb-3 mb-md-0 pr-0 pr-md-3">
                                <div class="d-flex flex-wrap align-items-center mb-2" style="gap: 8px;">
                                    <span class="badge-modern badge-green"><i class="fa-solid fa-check mr-1"></i> Akses Terbuka</span>
                                    
                                    @if($req->izin_unduh) 
                                        <span class="badge-modern badge-gray" id="badge-unduh-{{ $req->id }}"><i class="fa-solid fa-download mr-1"></i> Izin Unduh Aktif</span> 
                                    @else
                                        <button type="button" id="btn-izin-unduh-{{ $req->id }}" class="btn btn-sm btn-white border border-primary text-primary m-0" style="padding: 3px 8px; border-radius: 6px; font-size: 0.65rem; font-weight: 600; line-height: 1; background: #fff; transition: 0.2s;" onclick="berikanIzinUnduh({{ $req->id }})" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#fff'">
                                            <i class="fa-solid fa-unlock mr-1"></i> Boleh Unduh
                                        </button>
                                        <span class="badge-modern badge-gray" id="badge-unduh-{{ $req->id }}" style="display: none;"><i class="fa-solid fa-download mr-1"></i> Izin Unduh Aktif</span> 
                                    @endif
                                </div>
                                <h5 class="font-weight-bold mb-1 mt-1 text-break" style="color: #0f172a; font-size: 1.05rem;">{{ $req->arsip->nama_arsip }}</h5>
                            </div>
                            
                            <form action="{{ route('verifikasi.reject', $req->id) }}" method="POST" id="form-cabut-{{ $req->id }}" class="flex-shrink-0 mt-2 mt-md-0">
                                @csrf @method('PUT')
                                <input type="hidden" name="catatan_admin" value="Akses dicabut secara manual oleh Admin.">
                                <button type="button" class="btn btn-white text-danger border font-weight-bold w-100" style="border-radius: 10px; font-size: 0.8rem; background: #fff;" onclick="konfirmasiCabut({{ $req->id }})">Cabut Akses</button>
                            </form>
                        </div>
                        
                        <div class="applicant-box d-flex align-items-start bg-white" style="border-color: #f1f5f9;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; margin-right: 15px;">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div class="w-100">
                                <div class="font-weight-bold text-dark" style="font-size: 0.85rem;">{{ $req->nama_pemohon }} <span class="text-muted font-weight-normal">({{ $req->subbagian_pemohon }})</span></div>
                                <div class="d-flex flex-wrap mt-2 pt-2" style="border-top: 1px dashed #e2e8f0; font-size: 0.75rem; color: #64748b; gap: 15px;">
                                    <span><strong class="text-dark">Verifier:</strong> {{ $req->diverifikasi_oleh }}</span>
                                    <span><strong class="text-dark">Diproses:</strong> {{ $req->updated_at->format('d/m/Y H:i') }}</span>
                                    <span><strong class="text-dark">Catatan:</strong> "{{ $req->catatan_admin }}"</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div style="background: #f8fafc; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;"><i class="fa-solid fa-check-double" style="font-size: 2.5rem; color: #cbd5e1;"></i></div>
                        <h6 class="font-weight-bold text-secondary mb-1">Riwayat Kosong</h6>
                        <p class="small mb-0" style="color: #94a3b8;">Belum ada riwayat akses yang disetujui.</p>
                    </div>
                @endforelse
            </div>

            <div class="tab-pane fade" id="pills-ditolak" role="tabpanel">
                @forelse($ditolak as $req)
                    <div class="request-card" style="border-left: 4px solid #ef4444;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <span class="badge-modern badge-red mb-2"><i class="fa-solid fa-ban mr-1"></i> Akses Ditolak / Dicabut</span>
                                <h5 class="font-weight-bold mb-1 mt-1 text-break" style="color: #0f172a; font-size: 1.05rem;">{{ $req->arsip->nama_arsip }}</h5>
                            </div>
                            
                            <form action="{{ route('verifikasi.destroy', $req->id) }}" method="POST" id="form-hapus-{{ $req->id }}" class="flex-shrink-0">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-white border text-danger w-100" style="border-radius: 10px; font-size: 0.9rem;" title="Hapus Riwayat Permanen" onclick="konfirmasiHapus({{ $req->id }})"><i class="fa-regular fa-trash-can mr-1"></i> Hapus</button>
                            </form>
                        </div>
                        <div class="applicant-box d-flex align-items-start bg-white" style="border-color: #f1f5f9;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; margin-right: 15px;"><i class="fa-regular fa-user"></i></div>
                            <div class="w-100">
                                <div class="font-weight-bold text-dark" style="font-size: 0.85rem;">{{ $req->nama_pemohon }} <span class="text-muted font-weight-normal">({{ $req->subbagian_pemohon }})</span></div>
                                <div class="d-flex flex-wrap mt-2 pt-2" style="border-top: 1px dashed #e2e8f0; font-size: 0.75rem; color: #64748b; gap: 15px;">
                                    <span><strong class="text-dark">Diproses:</strong> {{ $req->updated_at->format('d/m/Y H:i') }}</span>
                                    <span class="text-danger"><strong class="text-danger">Alasan Ditolak:</strong> "{{ $req->catatan_admin }}"</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div style="background: #f8fafc; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;"><i class="fa-solid fa-broom" style="font-size: 2.5rem; color: #cbd5e1;"></i></div>
                        <h6 class="font-weight-bold text-secondary mb-1">Riwayat Bersih</h6>
                        <p class="small mb-0" style="color: #94a3b8;">Tidak ada riwayat penolakan akses.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
    // SCRIPT SWEETALERT2: CABUT & HAPUS
    // ========================================================
    function konfirmasiCabut(id) {
        Swal.fire({
            title: 'Cabut Izin Akses?',
            text: "Pegawai ini tidak akan bisa lagi melihat dokumen tersebut.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-ban mr-1"></i> Ya, Cabut',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-cabut-' + id).submit();
            }
        });
    }

    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Log riwayat penolakan ini akan dihapus dari sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-' + id).submit();
            }
        });
    }

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
    // FITUR "BOLEH UNDUH" AJAX REAL-TIME
    // ========================================================
    function berikanIzinUnduh(id) {
        Swal.fire({
            title: 'Berikan Akses Unduh?',
            text: "Pegawai akan langsung dapat mengunduh dokumen ini tanpa perlu Anda merefresh halaman.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-unlock mr-1"></i> Ya, Izinkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang membuka akses unduh untuk pegawai.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch(`/verifikasi/${id}/allow-download`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ _method: 'PUT' })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Akses Terbuka!',
                            text: 'Izin unduh berhasil diberikan secara real-time.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        
                        document.getElementById('btn-izin-unduh-' + id).style.display = 'none';
                        document.getElementById('badge-unduh-' + id).style.display = 'inline-flex';
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Sistem tidak dapat dihubungi. Pastikan Route/Controller sudah diatur.', 'error');
                });
            }
        });
    }

    // ========================================================
    // POLLING NOTIFIKASI REAL-TIME
    // ========================================================
    document.addEventListener('DOMContentLoaded', function() {
        let lastKnownId = {{ $menunggu->first()->id ?? 0 }}; 

        function updateBadge(count) {
            const badge = document.getElementById('badge-verifikasi-global');
            if(badge) {
                if(count > 0) { badge.innerText = count; badge.style.display = 'inline-block'; } 
                else { badge.style.display = 'none'; }
            }
        }

        fetch('{{ route("api.verifikasi.pending") }}').then(res => res.json()).then(data => {
            if(data.latest_id && lastKnownId === 0) lastKnownId = data.latest_id;
            updateBadge(data.jumlah_pending);
        });

        setInterval(function() {
            fetch('{{ route("api.verifikasi.pending") }}').then(res => res.json()).then(data => {
                updateBadge(data.jumlah_pending);

                if(data.has_new && data.latest_id > lastKnownId) {
                    lastKnownId = data.latest_id;
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true });
                    Toast.fire({ icon: 'info', title: 'Permintaan Akses Baru!', text: data.nama + ' menunggu persetujuan Anda.' });

                    fetch(window.location.href).then(response => response.text()).then(html => {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');
                        if(document.getElementById('pills-tertunda')) {
                            document.getElementById('pills-tertunda').innerHTML = doc.getElementById('pills-tertunda').innerHTML;
                            document.getElementById('pills-tab').innerHTML = doc.getElementById('pills-tab').innerHTML;
                        }
                    });
                }
            });
        }, 3000);
    });
</script>
@endsection