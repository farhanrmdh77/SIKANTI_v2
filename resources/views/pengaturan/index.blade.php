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

    /* ================= SAAS CARD & FORM ELEMENTS ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); overflow: hidden; position: relative; height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .saas-card:hover { box-shadow: 0 15px 45px -10px rgba(15, 23, 42, 0.12); }
    
    .form-control-modern { border-radius: 12px; border: 1px solid #cbd5e1; padding: 12px 16px; font-family: 'Poppins'; color: #334155; transition: 0.3s; background: #f8fafc; font-size: 0.95rem; width: 100%; box-sizing: border-box;}
    .form-control-modern:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15); outline: none; }
    
    .input-group-text.modern { background: #f1f5f9; border: 1px solid #cbd5e1; border-right: none; border-radius: 12px 0 0 12px; color: #94a3b8; transition: 0.3s; }
    .form-control-modern.with-icon { border-left: none; border-radius: 0 12px 12px 0; background: #f1f5f9; }
    .form-control-modern.with-icon:focus { background: #fff; }
    .form-control-modern.with-icon:focus + .input-group-prepend .input-group-text.modern { background: #fff; border-color: #2563eb; color: #2563eb; }

    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 24px; font-size: 0.95rem; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);}
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35); }
    
    .btn-dark-modern { background-color: #0f172a; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 24px; font-size: 0.95rem; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);}
    .btn-dark-modern:hover { background-color: #1e293b; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(15, 23, 42, 0.35); }

    /* UPLOAD AREA */
    .upload-area { background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; transition: all 0.3s ease; }
    .upload-area:hover { border-color: #3b82f6; background: #eff6ff; }

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
        .saas-card { border-radius: 16px; margin-bottom: 20px; height: auto;}
        
        .user-profile-text { display: none !important; }
        .upload-area { flex-direction: column; text-align: center; }
        .upload-area .mr-4 { margin-right: 0 !important; margin-bottom: 15px; }
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
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Pengaturan Sistem Terpusat</h3>
                    <small style="color: #64748b; font-weight: 500; font-size: 0.8rem;">BPK Perwakilan Provinsi Jambi</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="text-right mr-3 d-none d-md-block user-profile-text">
                    <div class="font-weight-bold" style="color: #0f172a; font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                    <div style="color: #64748b; font-size: 0.8rem; font-weight: 500;">{{ Auth::user()->email }}</div>
                </div>
                <div class="shadow-sm" style="width: 48px; height: 48px; font-size: 1.2rem; border-radius: 16px; display: flex; align-items: center; justify-content: center; background-color: #fff; color: #C8A35A; border: 1px solid #e2e8f0;">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/profil/'.Auth::user()->foto) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 16px;">
                    @else
                        <i class="fa-solid fa-user-shield"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-4">
            
            @if(Auth::user()->role == 'Superadmin')
            <div class="col-lg-7 mb-4">
                <div class="saas-card d-flex flex-column">
                    <div class="p-4 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                        <h5 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-building-flag text-primary mr-2"></i>Identitas Instansi (Global)</h5>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Perubahan logo dan nama ini akan merefleksikan seluruh tampilan aplikasi secara instan.</p>
                    </div>
                    
                    <div class="p-4 bg-white flex-grow-1">
                        <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="h-100 d-flex flex-column justify-content-between">
                            @csrf
                            
                            <div>
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">NAMA APLIKASI / BRAND</label>
                                    <input type="text" name="nama_aplikasi" class="form-control form-control-modern bg-white" value="{{ $pengaturan->nama_aplikasi ?? 'E-Arsip SIKANTI' }}" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">SUB JUDUL / SLOGAN</label>
                                    <input type="text" name="sub_judul" class="form-control form-control-modern bg-white" value="{{ $pengaturan->sub_judul ?? 'Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi' }}" placeholder="Contoh: Sistem Informasi Kearsipan Terintegrasi">
                                </div>

                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase d-block mb-2">LOGO APLIKASI (Opsional)</label>
                                    
                                    <div class="upload-area d-flex align-items-center p-3">
                                        <div class="mr-4 p-2 bg-white text-center shadow-sm flex-shrink-0" style="width: 100px; height: 100px; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                            @if(isset($pengaturan) && $pengaturan->logo_aplikasi)
                                                <img id="previewLogo" src="{{ asset('storage/pengaturan/' . $pengaturan->logo_aplikasi) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                                                <i id="defaultIcon" class="fa-solid fa-image text-muted" style="font-size: 2.5rem; display: none;"></i>
                                            @else
                                                <img id="previewLogo" src="" alt="Belum Ada" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                                                <i id="defaultIcon" class="fa-solid fa-image" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-grow-1 w-100">
                                            <div class="custom-file mb-2">
                                                <input type="file" name="logo_aplikasi" class="custom-file-input" id="logoInput" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event, 'previewLogo', 'defaultIcon')">
                                                <label class="custom-file-label bg-white" for="logoInput" style="border-radius: 10px; font-size: 0.85rem; height: 42px; line-height: 28px; border-color: #cbd5e1; color: #64748b; font-weight: 500;">Pilih gambar logo...</label>
                                            </div>
                                            <small class="d-block" style="color: #64748b; font-size: 0.75rem;"><i class="fa-solid fa-circle-info mr-1 text-primary"></i>Format: PNG transparan (Rasio 1:1 direkomendasikan).</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <hr style="border-color: #e2e8f0; margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary-modern w-100"><i class="fa-solid fa-save mr-2"></i> Simpan Pengaturan Instansi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="{{ Auth::user()->role == 'Superadmin' ? 'col-lg-5' : 'col-lg-12' }} mb-4">
                <div class="saas-card d-flex flex-column">
                    <div class="p-4 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                        <h5 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-user-tie text-primary mr-2"></i>Profil Akun Saya</h5>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Sesuaikan identitas personal, kata sandi, dan foto profil Anda.</p>
                    </div>
                    
                    <div class="p-4 bg-white flex-grow-1">
                        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="h-100 d-flex flex-column justify-content-between">
                            @csrf @method('PUT')
                            
                            <div>
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img id="previewAvatar" src="{{ Auth::user()->foto ? asset('storage/profil/'.Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=e2e8f0&color=475569&size=150' }}" class="rounded-circle shadow" style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #fff; background: #f8fafc; transition: all 0.3s ease;">
                                        
                                        <button type="button" id="btnHapusFoto" class="btn btn-danger position-absolute shadow-sm" style="bottom: 0; left: 0; border-radius: 50%; width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff; z-index: 10; {{ Auth::user()->foto ? '' : 'display: none !important;' }}" onclick="hapusFotoProfil('{{ urlencode(Auth::user()->name) }}')" title="Hapus Foto Profil">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>

                                        <label for="fotoInput" class="btn btn-primary-modern position-absolute shadow-sm" style="bottom: 0; right: 0; border-radius: 50%; width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff; z-index: 10;" title="Ganti Foto Profil">
                                            <i class="fa-solid fa-camera"></i>
                                        </label>
                                        
                                        <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/png, image/jpeg, image/jpg" onchange="previewImageBaru(event)">
                                        
                                        <input type="hidden" name="hapus_foto" id="hapusFotoInput" value="0">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">NAMA LENGKAP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text modern"><i class="fa-solid fa-user"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control form-control-modern with-icon" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">ALAMAT EMAIL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text modern"><i class="fa-solid fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control form-control-modern with-icon" value="{{ Auth::user()->email }}" readonly style="color: #94a3b8; cursor: not-allowed;">
                                    </div>
                                    <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;"><i class="fa-solid fa-lock mr-1 text-warning"></i> Email utama tidak dapat diubah secara sepihak.</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">UBAH SANDI (Opsional)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text modern"><i class="fa-solid fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password" class="form-control form-control-modern with-icon" placeholder="Kosongkan jika tidak ingin mengubah...">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <hr style="border-color: #e2e8f0; margin-bottom: 20px;">
                                <button type="submit" class="btn btn-dark-modern w-100"><i class="fa-solid fa-user-check mr-2"></i> Perbarui Profil Saya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        @if(Auth::user()->role == 'Superadmin')
        <div class="row mt-2">
            <div class="col-lg-12 mb-4">
                <div class="saas-card d-flex flex-column">
                    <div class="p-4 bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center" style="border-bottom: 1px solid #f1f5f9;">
                        <div class="mb-3 mb-md-0">
                            <h5 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-sitemap text-primary mr-2"></i>Manajemen Subbagian & Kode Klasifikasi</h5>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Kelola struktur organisasi yang nantinya menjadi pilihan saat mendaftarkan akun baru.</p>
                        </div>
                        <button type="button" class="btn btn-primary-modern flex-shrink-0" data-toggle="modal" data-target="#modalTambahSubbag">
                            <i class="fa-solid fa-plus mr-2"></i> Tambah Subbagian
                        </button>
                    </div>
                    
                    <div class="p-4 bg-white flex-grow-1">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                    <tr>
                                        <th class="py-3" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Kode Klasifikasi</th>
                                        <th class="py-3" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Nama Subbagian</th>
                                        <th class="py-3 text-center" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subbagians as $subbag)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;">
                                        <td class="align-middle">
                                            <span class="badge badge-light border" style="font-size: 0.85rem; padding: 6px 12px; border-radius: 8px; color: #0f172a; font-family: monospace;">{{ $subbag->kode_klasifikasi }}</span>
                                        </td>
                                        <td class="align-middle" style="font-weight: 500; color: #334155;">{{ $subbag->nama_subbag }}</td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-sm btn-light text-primary mx-1" style="border-radius: 8px;" data-toggle="modal" data-target="#modalEditSubbag{{ $subbag->id }}"><i class="fa-solid fa-edit"></i></button>
                                            <form action="{{ route('subbagian.destroy', $subbag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Subbagian ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger mx-1" style="border-radius: 8px;"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <div style="font-size: 2rem; color: #cbd5e1; margin-bottom: 10px;"><i class="fa-solid fa-sitemap"></i></div>
                                            Belum ada subbagian yang terdaftar.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@if(Auth::user()->role == 'Superadmin')
<!-- Modal Tambah Subbag -->
<div class="modal fade" id="modalTambahSubbag" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 20px 25px;">
                <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fa-solid fa-plus-circle text-primary mr-2"></i>Tambah Subbagian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subbagian.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Nama Subbagian / Bidang</label>
                        <input type="text" name="nama_subbag" class="form-control form-control-modern" placeholder="Contoh: Kepegawaian" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Kode Klasifikasi</label>
                        <input type="text" name="kode_klasifikasi" class="form-control form-control-modern" placeholder="Contoh: KP" required style="text-transform: uppercase;">
                        <small class="text-muted d-block mt-2">Kode klasifikasi akan menjadi identitas depan nomor arsip, e.g., <strong>KP</strong>/001/2026.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="padding: 15px 25px; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 10px; font-weight: 500;">Batal</button>
                    <button type="submit" class="btn btn-primary-modern"><i class="fa-solid fa-save mr-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Subbag -->
@foreach($subbagians as $subbag)
<div class="modal fade" id="modalEditSubbag{{ $subbag->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 20px 25px;">
                <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fa-solid fa-edit text-primary mr-2"></i>Edit Subbagian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subbagian.update', $subbag->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Nama Subbagian / Bidang</label>
                        <input type="text" name="nama_subbag" class="form-control form-control-modern" value="{{ $subbag->nama_subbag }}" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Kode Klasifikasi</label>
                        <input type="text" name="kode_klasifikasi" class="form-control form-control-modern" value="{{ $subbag->kode_klasifikasi }}" required style="text-transform: uppercase;">
                    </div>
                </div>
                <div class="modal-footer bg-light" style="padding: 15px 25px; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 10px; font-weight: 500;">Batal</button>
                    <button type="submit" class="btn btn-primary-modern"><i class="fa-solid fa-save mr-2"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

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
    // FUNGSI PREVIEW GAMBAR (LOGO & AVATAR)
    // ========================================================
    function previewImage(event, targetImgId, targetIconId) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById(targetImgId);
            output.src = reader.result;
            output.style.display = 'block';
            
            if(targetIconId) {
                var icon = document.getElementById(targetIconId);
                if(icon) icon.style.display = 'none';
            }
        };
        reader.readAsDataURL(event.target.files[0]);
        
        // Ubah text label file input khusus untuk Logo Instansi
        if(event.target.nextElementSibling && event.target.nextElementSibling.classList.contains('custom-file-label')) {
            let fileName = event.target.files[0].name;
            event.target.nextElementSibling.innerText = fileName;
        }
    }

    // ========================================================
    // FUNGSI HAPUS FOTO PROFIL (REAL-TIME UI)
    // ========================================================
    function hapusFotoProfil(userName) {
        // 1. Beri tahu sistem/backend bahwa user ingin menghapus foto
        document.getElementById('hapusFotoInput').value = '1';
        
        // 2. Kosongkan input file (berjaga-jaga jika user baru saja memilih gambar tapi batal)
        document.getElementById('fotoInput').value = '';
        
        // 3. Kembalikan gambar layar ke Avatar Inisial Abu-abu secara instan
        document.getElementById('previewAvatar').src = 'https://ui-avatars.com/api/?name=' + userName + '&background=e2e8f0&color=475569&size=150';
        
        // 4. Sembunyikan tombol hapus merah karena foto sudah kosong
        document.getElementById('btnHapusFoto').style.setProperty('display', 'none', 'important');
    }

    function previewImageBaru(event) {
        // Panggil fungsi preview gambar bawaan
        previewImage(event, 'previewAvatar', null);
        
        // Batalkan niat hapus (set value ke 0) karena user memilih foto baru
        document.getElementById('hapusFotoInput').value = '0';
        
        // Tampilkan kembali tombol hapus merah
        document.getElementById('btnHapusFoto').style.setProperty('display', 'flex', 'important');
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