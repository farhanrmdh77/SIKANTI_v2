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
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 10px 20px; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: 0.3s; display: inline-flex; align-items: center; }
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }

    /* TABLE SAAS */
    .table-modern th { border-top: none; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; padding: 16px 20px; font-weight: 700; background: #fafbfc; white-space: nowrap;}
    .table-modern td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 15px 20px; color: #334155; font-size: 0.85rem; }
    .table-modern tr:hover td { background-color: #f8fafc; }

    /* AVATAR PENGGUNA */
    .avatar-modern { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; flex-shrink: 0; margin-right: 15px; overflow: hidden; background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .avatar-modern img { width: 100%; height: 100%; object-fit: cover; }

    /* BADGE */
    .badge-modern { padding: 5px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 600; display: inline-flex; align-items: center; white-space: nowrap; }
    .badge-blue { background-color: #eff6ff; color: #2563eb; }
    .badge-gray { background-color: #f1f5f9; color: #475569; }
    .badge-green { background-color: #d1fae5; color: #059669; }

    /* ACTION BUTTONS */
    .action-btn-circle { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; cursor: pointer; font-size: 0.85rem; margin: 0 3px;}
    .btn-edit { color: #fff; background: #6366f1; } .btn-edit:hover { background: #4f46e5; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3); }
    .btn-delete { color: #fff; background: #ef4444; } .btn-delete:hover { background: #dc2626; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }

    /* MODAL & FORMS MODERN */
    .modal-content { border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .modal-header { border-bottom: 1px solid #f1f5f9; padding: 25px 30px; border-radius: 24px 24px 0 0; background: #fff; }
    .modal-body { padding: 30px; }
    .modal-footer { border-top: 1px solid #f1f5f9; padding: 20px 30px; background: #f8fafc; border-radius: 0 0 24px 24px; }
    
    .form-label-modern { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block; }
    .form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; background-color: #f8fafc; transition: all 0.3s ease; color: #334155; font-size: 0.9rem; width: 100%; height: auto;}
    .form-control-modern:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); outline: none; }
    select.form-control-modern { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; padding-right: 40px; }
    
    .section-badge { display: inline-flex; align-items: center; background: #eff6ff; color: #2563eb; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; margin-bottom: 20px; }
    .section-badge.warning { background: #fef3c7; color: #d97706; }
    
    .border-right-dashed { border-right: 2px dashed #f1f5f9; }
    
    /* TOAST NOTIFICATION */
    .custom-toast-container { position: fixed; top: 30px; right: -400px; background-color: #ffffff; padding: 20px 45px 20px 25px; border-radius: 16px; box-shadow: 0 15px 40px -5px rgba(0,0,0,0.15); display: flex; align-items: center; width: 380px; z-index: 99999; transition: right 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); overflow: hidden; }
    .custom-toast-container.show { right: 30px; }
    .toast-icon-circle { width: 48px; height: 48px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.4rem; flex-shrink: 0; margin-right: 18px; }
    .toast-success .toast-icon-circle { background-color: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
    .toast-error .toast-icon-circle { background-color: #ef4444; color: white; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }
    .toast-text-area h4 { font-size: 1.1rem; font-weight: 800; margin: 0 0 3px 0; color: #1e293b; letter-spacing: 0.5px; }
    .toast-text-area p { font-size: 0.85rem; color: #64748b; margin: 0; line-height: 1.4; }
    .toast-close-btn { position: absolute; top: 15px; right: 15px; background: transparent; border: none; color: #94a3b8; font-size: 1rem; cursor: pointer; transition: 0.2s; }
    .toast-progress-bar { position: absolute; bottom: 0; left: 0; height: 5px; width: 100%; background-color: #10b981; animation: toastProgress 3s linear forwards; }
    .toast-error .toast-progress-bar { background-color: #ef4444; }
    @keyframes toastProgress { 0% { width: 100%; } 100% { width: 0%; } }

    /* RESPONSIVITAS MOBILE */
    .mobile-menu-btn { display: none; background: transparent; border: none; color: #0f172a; font-size: 1.5rem; cursor: pointer; padding: 0; margin-right: 15px; transition: 0.3s; }
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
        .border-right-dashed { border-right: none; border-bottom: 2px dashed #f1f5f9; margin-bottom: 30px; padding-bottom: 30px; }
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
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Manajemen Pengguna Sektor</h3>
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

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3" style="gap: 15px;">
            <form action="{{ route('pengguna.index') }}" method="GET" class="m-0" style="flex: 1 1 300px; max-width: 450px;">
                <div class="input-group align-items-center" style="border: 1px solid #cbd5e1; border-radius: 12px; background: #fff; overflow: hidden; height: 46px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-0" style="padding-right: 10px; padding-left: 18px;"><i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i></span>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 shadow-none pl-0 bg-white" placeholder="Cari nama atau email pengguna..." style="font-family: 'Poppins'; font-size: 0.9rem; height: 100%;">
                    @if(request('search'))
                        <div class="input-group-append">
                            <a href="{{ route('pengguna.index') }}" class="input-group-text bg-white border-0 text-danger" style="text-decoration: none;"><i class="fa-solid fa-xmark"></i></a>
                        </div>
                    @endif
                </div>
            </form>

            <button class="btn btn-primary-modern flex-shrink-0" style="height: 46px;" data-toggle="modal" data-target="#modalTambahUser">
                <i class="fa-solid fa-user-plus mr-2"></i> Daftarkan Anggota
            </button>
        </div>

        <div class="saas-card">
            <div class="p-4 border-bottom" style="border-color: #f1f5f9 !important;">
                <h5 class="font-weight-bold mb-1" style="color: #0f172a;">Daftar Akun Operasional</h5>
                <p class="small mb-0" style="color: #64748b;">Seluruh personel yang memiliki otoritas akses ke brankas digital subbagian ini.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-modern mb-0" style="min-width: 700px;">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">NO</th>
                            <th width="35%">IDENTITAS PENGGUNA</th>
                            <th width="30%">ALAMAT EMAIL (USERNAME)</th>
                            <th width="15%" class="text-center">HAK AKSES</th>
                            <th width="15%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penggunas as $user)
                            <tr>
                                <td class="font-weight-bold text-muted text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-modern">
                                            @if($user->foto)
                                                <img src="{{ asset('storage/profil/' . $user->foto) }}" alt="Avatar">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <strong style="color: #1e293b; font-size: 0.95rem; display: block;">{{ $user->name }}</strong>
                                            @if($user->id == Auth::user()->id) 
                                                <span class="badge-modern badge-green mt-1" style="padding: 2px 6px; font-size: 0.6rem;"><i class="fa-solid fa-circle-check mr-1"></i> Sesi Anda Saat Ini</span> 
                                            @else
                                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 500;">Terdaftar di Sistem</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="font-weight: 500; color: #475569; font-size: 0.8rem; white-space: nowrap;">
                                        <i class="fa-regular fa-envelope mr-2 text-muted" style="font-size: 0.9rem;"></i> 
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($user->role == 'Admin' || empty($user->role))
                                        <span class="badge-modern badge-blue"><i class="fa-solid fa-user-shield mr-1"></i> Admin Sektor</span>
                                    @else
                                        <span class="badge-modern badge-gray"><i class="fa-solid fa-user-pen mr-1"></i> Staff Registrasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="action-btn-circle btn-edit" title="Edit Akun" data-toggle="modal" data-target="#modalEditUser{{ $user->id }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        @if($user->id != Auth::user()->id)
                                            <form id="form-hapus-pengguna-{{ $user->id }}" action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="d-inline m-0">
                                                @csrf @method('DELETE')
                                                <button type="button" class="action-btn-circle btn-delete" title="Hapus Akun" onclick="konfirmasiHapusPengguna({{ $user->id }})">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div style="background: #f8fafc; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                                        <i class="fa-solid fa-users-slash" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                                    </div>
                                    <h6 style="color: #475569; font-weight: 600;">Belum Ada Anggota Tim</h6>
                                    <p class="small mb-0" style="color: #94a3b8;">Klik tombol "Daftarkan Anggota" di atas untuk menambah pengguna baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-white px-5 pt-5 pb-4 border-0">
                <h4 class="modal-title font-weight-bold" style="color: #0f172a; font-family: 'Poppins', sans-serif;">
                    <i class="fa-solid fa-user-plus text-primary mr-2"></i> Daftarkan Anggota Baru
                </h4>
                <button type="button" class="close" data-dismiss="modal" style="background: #f1f5f9; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; opacity: 1; color: #64748b;">&times;</button>
            </div>
            
            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf
                <div class="modal-body px-5 pb-5 pt-0">
                    <div class="row">
                        <div class="col-lg-6 pr-lg-4 border-right-dashed">
                            <div class="section-badge">
                                <i class="fa-regular fa-id-card mr-2"></i> Identitas & Peran
                            </div>

                            <div class="form-group">
                                <label class="form-label-modern">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern" name="name" placeholder="Cth: Farhan Ramadhan" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label-modern">Alamat Email (Username) <span class="text-danger">*</span></label>
                                <input type="email" class="form-control-modern" name="email" placeholder="Cth: farhan@jambi.bpk.go.id" required>
                            </div>
                            
                            <div class="form-group mb-0">
                                <label class="form-label-modern">Hak Akses Sistem</label>
                                <select class="form-control-modern" name="role" required>
                                    <option value="Staff">Staff Registrasi (Akses Terbatas Gudang)</option>
                                    <option value="Admin">Admin Sektor (Akses Penuh)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 pl-lg-4">
                            <div class="section-badge warning">
                                <i class="fa-solid fa-shield-halved mr-2"></i> Kredensial Keamanan
                            </div>

                            <div class="form-group">
                                <label class="form-label-modern">Kata Sandi Baru <span class="text-danger">*</span></label>
                                <input type="password" class="form-control-modern" name="password" placeholder="Minimal 6 karakter..." required>
                            </div>
                            
                            <div class="form-group mb-0">
                                <label class="form-label-modern">Ulangi Kata Sandi <span class="text-danger">*</span></label>
                                <input type="password" class="form-control-modern" name="password_confirmation" placeholder="Ketik ulang kata sandi..." required>
                            </div>
                            
                            <div class="mt-4 p-3 rounded" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                                <p class="small text-muted mb-0 font-weight-bold"><i class="fa-solid fa-circle-info text-primary mr-1"></i> Catatan Keamanan:</p>
                                <p class="small text-muted mb-0" style="font-size: 0.75rem; line-height: 1.5; margin-top: 5px;">Sandi akan dienkripsi secara otomatis (Bcrypt). Pastikan memberikan sandi ini kepada pengguna yang bersangkutan agar mereka dapat masuk ke sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer px-5 py-4 border-0">
                    <button type="button" class="btn btn-light font-weight-bold" style="border-radius: 12px; padding: 12px 25px; color: #64748b; background: #e2e8f0; border: none;" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 12px; padding: 12px 30px; background: #2563eb; color: #ffffff; border: none; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-save mr-2"></i> Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($penggunas as $user)
    <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-white px-5 pt-5 pb-4 border-0">
                    <h4 class="modal-title font-weight-bold" style="color: #0f172a; font-family: 'Poppins', sans-serif;">
                        <i class="fa-solid fa-user-pen text-primary mr-2"></i> Ubah Informasi Akun
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" style="background: #f1f5f9; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; opacity: 1; color: #64748b;">&times;</button>
                </div>
                
                <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body px-5 pb-5 pt-0">
                        <div class="row">
                            <div class="col-lg-6 pr-lg-4 border-right-dashed">
                                <div class="section-badge">
                                    <i class="fa-regular fa-id-card mr-2"></i> Identitas & Peran
                                </div>

                                <div class="form-group">
                                    <label class="form-label-modern">Nama Lengkap</label>
                                    <input type="text" class="form-control-modern" name="name" value="{{ $user->name }}" required>
                                </div>
                                
                                <div class="form-group mb-0">
                                    <label class="form-label-modern">Alamat Email (Username)</label>
                                    <input type="email" class="form-control-modern" name="email" value="{{ $user->email }}" required>
                                </div>
                                
                                @if($user->id != Auth::user()->id)
                                <div class="form-group mt-3 mb-0">
                                    <label class="form-label-modern">Hak Akses Sistem</label>
                                    <select class="form-control-modern" name="role" required>
                                        <option value="Admin" {{ ($user->role == 'Admin' || empty($user->role)) ? 'selected' : '' }}>Admin Sektor (Akses Penuh)</option>
                                        <option value="Staff" {{ $user->role == 'Staff' ? 'selected' : '' }}>Staff Registrasi (Akses Terbatas Gudang)</option>
                                    </select>
                                </div>
                                @endif
                            </div>

                            <div class="col-lg-6 pl-lg-4">
                                <div class="section-badge warning">
                                    <i class="fa-solid fa-shield-halved mr-2"></i> Keamanan Opsional
                                </div>

                                <div class="form-group">
                                    <label class="form-label-modern">Ganti Kata Sandi Baru</label>
                                    <input type="password" class="form-control-modern" name="password" placeholder="Biarkan kosong jika tidak diubah...">
                                </div>
                                
                                <div class="form-group mb-0">
                                    <label class="form-label-modern">Konfirmasi Sandi Baru</label>
                                    <input type="password" class="form-control-modern" name="password_confirmation" placeholder="Ketik ulang sandi baru...">
                                </div>
                                
                                <div class="mt-4 p-3 rounded" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                                    <p class="small text-muted mb-0 font-weight-bold"><i class="fa-solid fa-circle-info text-primary mr-1"></i> Mode Pembaruan:</p>
                                    <p class="small text-muted mb-0" style="font-size: 0.75rem; line-height: 1.5; margin-top: 5px;">Anda tidak perlu mengisi kolom kata sandi apabila hanya ingin mengubah Nama, Email, atau Peran dari pengguna ini.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer px-5 py-4 border-0">
                        <button type="button" class="btn btn-light font-weight-bold" style="border-radius: 12px; padding: 12px 25px; color: #64748b; background: #e2e8f0; border: none;" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 12px; padding: 12px 30px; background: #2563eb; color: #ffffff; border: none; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25);">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    // SWEETALERT CONFIRM DELETE PENGGUNA
    function konfirmasiHapusPengguna(id) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Apakah Anda yakin ingin mencabut akses dan menghapus akun operasional ini dari sistem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-pengguna-' + id).submit();
            }
        });
    }

    // REALTIME POLLING VERIFIKASI PENDING
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
                    Toast.fire({ icon: 'info', title: 'Permintaan Akses Baru!', text: data.nama + ' sedang menunggu verifikasi Anda.' });
                }
            });
        }, 3000);
    });
</script>
@endsection