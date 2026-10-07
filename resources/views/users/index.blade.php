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
    
    .form-control-modern { border-radius: 12px; border: 1px solid #cbd5e1; padding: 12px 16px; font-family: 'Poppins'; color: #334155; transition: 0.3s; background: #f8fafc; font-size: 0.95rem; width: 100%; box-sizing: border-box; min-height: 48px; }
    .form-control-modern:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15); outline: none; }
    select.form-control-modern { appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px 16px; padding-right: 40px; }
    .password-wrapper { position: relative; }
    .password-wrapper .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0; outline: none; font-size: 1.1rem; transition: 0.2s; }
    .password-wrapper .toggle-password:hover { color: #334155; }
    .password-wrapper input { padding-right: 45px; }
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 24px; font-size: 0.95rem; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);}
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35); }

    /* ================= TOAST NOTIFICATION MODERN ================= */
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

    /* RESPONSIVE */
    .mobile-menu-btn { display: none; background: transparent; border: none; color: #0f172a; font-size: 1.5rem; cursor: pointer; padding: 0; margin-right: 15px; transition: 0.3s; }
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

@if(session('error') || $errors->any())
<div id="elegantToast" class="custom-toast-container toast-error">
    <button class="toast-close-btn" onclick="tutupToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-icon-circle"><i class="fa-solid fa-xmark"></i></div>
    <div class="toast-text-area">
        <h4>PERHATIAN!</h4>
        <p>{{ session('error') ?? $errors->first() }}</p>
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
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Manajemen Pengguna</h3>
                    <small style="color: #64748b; font-weight: 500; font-size: 0.8rem;">Kelola seluruh akun Admin dan Staff Subbagian</small>
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
            <div class="col-lg-12 mb-4">
                <div class="saas-card d-flex flex-column">
                    <div class="p-4 bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center" style="border-bottom: 1px solid #f1f5f9;">
                        <div class="mb-3 mb-md-0">
                            <h5 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-users text-primary mr-2"></i>Daftar Pengguna</h5>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">Seluruh akun Admin Subbag dan Staff terdaftar di sistem.</p>
                        </div>
                        <button type="button" class="btn btn-primary-modern flex-shrink-0" data-toggle="modal" data-target="#modalTambahUser">
                            <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pengguna Baru
                        </button>
                    </div>
                    
                    <div class="p-4 bg-white flex-grow-1">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                    <tr>
                                        <th class="py-3" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Nama Pengguna</th>
                                        <th class="py-3" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Email</th>
                                        <th class="py-3" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Role</th>
                                        <th class="py-3" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Subbagian (Kode)</th>
                                        <th class="py-3 text-center" style="color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $u)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;">
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3 shadow-sm" style="width: 36px; height: 36px; border-radius: 10px; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e2e8f0;">
                                                    @if($u->foto)
                                                        <img src="{{ asset('storage/profil/'.$u->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <i class="fa-solid fa-user" style="color: #94a3b8; font-size: 0.9rem;"></i>
                                                    @endif
                                                </div>
                                                <strong style="color: #0f172a;">{{ $u->name }}</strong>
                                            </div>
                                        </td>
                                        <td class="align-middle text-muted">{{ $u->email }}</td>
                                        <td class="align-middle">
                                            @if($u->role == 'Admin')
                                                <span class="badge" style="background: rgba(234, 179, 8, 0.15); color: #ca8a04; border-radius: 8px; padding: 6px 12px;"><i class="fa-solid fa-user-shield mr-1"></i> Admin</span>
                                            @else
                                                <span class="badge" style="background: rgba(96, 165, 250, 0.15); color: #2563eb; border-radius: 8px; padding: 6px 12px;"><i class="fa-solid fa-user mr-1"></i> Staff</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span style="font-weight: 500; color: #334155;">{{ $u->subbagian->nama_subbag ?? '-' }}</span><br>
                                            <small class="text-muted"><i class="fa-solid fa-tag mr-1 text-primary"></i>{{ $u->subbagian->kode_klasifikasi ?? '-' }}</small>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-sm btn-light text-primary mx-1" style="border-radius: 8px;" data-toggle="modal" data-target="#modalEditUser{{ $u->id }}"><i class="fa-solid fa-edit"></i></button>
                                            <form action="{{ route('superadmin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger mx-1" style="border-radius: 8px;"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <div style="font-size: 2rem; color: #cbd5e1; margin-bottom: 10px;"><i class="fa-solid fa-users-slash"></i></div>
                                            Belum ada pengguna terdaftar (Selain Superadmin).
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

    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 20px 25px;">
                <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fa-solid fa-user-plus text-primary mr-2"></i>Tambah Pengguna Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-modern" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Email</label>
                        <input type="email" name="email" class="form-control form-control-modern" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password_tambah" class="form-control form-control-modern" minlength="6" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_tambah', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small text-uppercase mb-2">Role</label>
                                <select name="role" class="form-control form-control-modern" required>
                                    <option value="Admin">Admin Subbag</option>
                                    <option value="Staff">Staff / User</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small text-uppercase mb-2">Subbagian / Bidang</label>
                                <select name="subbag_id" class="form-control form-control-modern" required>
                                    <option value="" disabled selected>Pilih Subbagian...</option>
                                    @foreach($subbagians as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->nama_subbag }} ({{ $sub->kode_klasifikasi }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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

<!-- Modal Edit User -->
@foreach($users as $u)
<div class="modal fade" id="modalEditUser{{ $u->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 20px 25px;">
                <h5 class="modal-title font-weight-bold" style="color: #0f172a;"><i class="fa-solid fa-user-edit text-primary mr-2"></i>Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.users.update', $u->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-modern" value="{{ $u->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Email</label>
                        <input type="email" name="email" class="form-control form-control-modern" value="{{ $u->email }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase mb-2">Password Baru (Opsional)</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password_edit_{{ $u->id }}" class="form-control form-control-modern" minlength="6" placeholder="Kosongkan jika tidak diubah...">
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_edit_{{ $u->id }}', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small text-uppercase mb-2">Role</label>
                                <select name="role" class="form-control form-control-modern" required>
                                    <option value="Admin" {{ $u->role == 'Admin' ? 'selected' : '' }}>Admin Subbag</option>
                                    <option value="Staff" {{ $u->role == 'Staff' ? 'selected' : '' }}>Staff / User</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small text-uppercase mb-2">Subbagian / Bidang</label>
                                <select name="subbag_id" class="form-control form-control-modern" required>
                                    @foreach($subbagians as $sub)
                                        <option value="{{ $sub->id }}" {{ $u->subbag_id == $sub->id ? 'selected' : '' }}>{{ $sub->nama_subbag }} ({{ $sub->kode_klasifikasi }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

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

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
