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

    /* ================= SAAS FOLDER CARD ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; position: relative; }
    .folder-card { cursor: pointer; text-decoration: none; display: block; color: inherit; }
    .folder-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.15); border-color: #bfdbfe; }
    .folder-icon-wrapper { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: #eff6ff; color: #2563eb; margin-bottom: 20px; transition: 0.3s; }
    .folder-card:hover .folder-icon-wrapper { background: #2563eb; color: #fff; transform: scale(1.05); }

    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 10px 20px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: 0.3s; }
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }

    /* MODAL MODERN */
    .modal-content { border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .modal-header { border-bottom: 1px solid #f1f5f9; padding: 25px 30px; border-radius: 24px 24px 0 0; background: #fff; }
    .modal-body { padding: 30px; }
    .modal-footer { border-top: 1px solid #f1f5f9; padding: 20px 30px; background: #f8fafc; border-radius: 0 0 24px 24px; }
    .form-control-modern { border-radius: 12px; border: 1px solid #cbd5e1; padding: 12px 15px; font-family: 'Poppins'; color: #334155; }
    select.form-control-modern { height: auto !important; }
    .form-control-modern:focus { border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); outline: none; }
    .dropdown-menu-folder { border-radius: 16px; padding: 8px; min-width: 180px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }

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
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Gudang Folder Klasifikasi</h3>
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

        <div class="d-flex justify-content-between align-items-center mb-4 pt-2 flex-wrap" style="gap: 15px;">
            <h5 class="font-weight-bold text-dark mb-0">Brankas Subbagian {{ Auth::user()->subbagian->nama_subbag }}</h5>
            
            <div class="d-flex align-items-center flex-wrap" style="gap: 15px;">
                <div class="input-group align-items-center" style="border: 1px solid #cbd5e1; border-radius: 12px; background: #fff; overflow: hidden; height: 42px; width: 250px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-0" style="padding-right: 10px; padding-left: 15px;"><i class="fa-solid fa-magnifying-glass" style="color: #94a3b8; font-size: 0.85rem;"></i></span>
                    </div>
                    <input type="text" id="searchInput" class="form-control border-0 shadow-none pl-0 bg-white" placeholder="Cari folder..." style="font-family: 'Poppins'; font-size: 0.85rem; height: 100%;">
                    <div class="input-group-append" id="clearSearchBtn" style="display: none;">
                        <button type="button" class="input-group-text bg-white border-0 text-danger" style="background: transparent; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>

                <button class="btn btn-primary-modern" data-toggle="modal" data-target="#modalTambahFolder">
                    <i class="fa-solid fa-folder-plus mr-2"></i> Buat Folder Baru
                </button>
            </div>
        </div>

        <div class="row" id="folderContainer">
            @forelse($kategoris->sortBy('nama_kategori') as $kategori)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 folder-item" data-nama="{{ strtolower($kategori->nama_kategori) }}" data-deskripsi="{{ strtolower($kategori->deskripsi ?? '') }}">
                    <div class="saas-card folder-card p-4 h-100 position-relative" onclick="openFolder(event, '{{ route('arsip.index', $kategori->id) }}')">
                        
                        <div class="dropdown position-absolute" style="top: 20px; right: 20px; z-index: 10;">
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" type="button" data-toggle="dropdown" style="width: 32px; height: 32px; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-folder">
                                <button type="button" class="dropdown-item py-2 font-weight-bold bg-transparent" data-toggle="modal" data-target="#modalEdit{{ $kategori->id }}" style="color: #0284c7; border-radius: 8px; cursor: pointer; border: none; width: 100%; text-align: left;">
                                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Informasi
                                </button>
                                <div class="dropdown-divider border-light my-1"></div>
                                
                                <form id="form-hapus-kategori-{{ $kategori->id }}" action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="konfirmasiHapusKategori({{ $kategori->id }})" class="dropdown-item py-2 font-weight-bold bg-transparent" style="color: #e11d48; border-radius: 8px; cursor: pointer; border: none; width: 100%; text-align: left;">
                                        <i class="fa-solid fa-trash-can mr-2"></i> Hapus Folder
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="folder-icon-wrapper">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                        
                        <h5 class="font-weight-bold mb-1" style="color: #0f172a; font-size: 1.1rem;">{{ $kategori->nama_kategori }}</h5>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $kategori->deskripsi ?? 'Tidak ada keterangan.' }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top" style="border-color: #f1f5f9 !important;">
                            <div class="d-flex align-items-center" style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">
                                <i class="fa-solid fa-file-lines mr-2 text-primary"></i> 
                                {{ $kategori->arsips->count() ?? 0 }} Berkas Dokumen
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalEdit{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold text-dark"><i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Edit Folder Klasifikasi</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body">
                                    @php
                                        $isLainnya = true;
                                        $editKode = '';
                                        $editAngka = '';
                                        foreach($subbagians as $sb) {
                                            if ($sb->kode_klasifikasi && str_starts_with($kategori->nama_kategori, $sb->kode_klasifikasi . '.')) {
                                                $isLainnya = false;
                                                $editKode = $sb->kode_klasifikasi;
                                                $editAngka = substr($kategori->nama_kategori, strlen($sb->kode_klasifikasi) + 1);
                                                break;
                                            }
                                        }
                                        if ($isLainnya) {
                                            $editKode = 'Lainnya';
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold text-dark small text-uppercase">Kode Klasifikasi <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-modern kode-klasifikasi-edit" name="kode_klasifikasi" required>
                                                <option value="" disabled>-- Pilih Kode --</option>
                                                @foreach($subbagians as $sb)
                                                    @if($sb->kode_klasifikasi)
                                                        <option value="{{ $sb->kode_klasifikasi }}" {{ $editKode == $sb->kode_klasifikasi ? 'selected' : '' }}>{{ $sb->kode_klasifikasi }}</option>
                                                    @endif
                                                @endforeach
                                                <option value="Lainnya" {{ $editKode == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold text-dark small text-uppercase">Nama Folder (Angka) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control form-control-modern angka-kategori-edit" name="angka_kategori" value="{{ $editAngka }}" placeholder="Contoh: 1" {{ $editKode == 'Lainnya' ? 'disabled' : 'required' }}>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold text-dark small text-uppercase">Deskripsi (Opsional)</label>
                                        <textarea name="deskripsi" class="form-control form-control-modern" rows="3">{{ $kategori->deskripsi }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light font-weight-bold border" style="border-radius: 12px; padding: 10px 20px;" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary-modern">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12" id="emptyFolderState">
                    <div class="saas-card p-5 text-center">
                        <div style="font-size: 4.5rem; color: #e2e8f0; margin-bottom: 20px;"><i class="fa-solid fa-folder-plus"></i></div>
                        <h4 class="font-weight-bold text-dark">Gudang Folder Masih Kosong</h4>
                        <p style="color: #64748b; max-width: 400px; margin: 0 auto 25px auto;">Anda belum membuat klasifikasi folder apapun. Klik tombol "Buat Folder Baru" di kanan atas untuk mulai mengelola arsip.</p>
                        <button class="btn btn-primary-modern" data-toggle="modal" data-target="#modalTambahFolder">
                            <i class="fa-solid fa-plus mr-2"></i> Buat Folder Pertama
                        </button>
                    </div>
                </div>
            @endforelse

            <div class="col-12" id="emptySearchState" style="display: none;">
                <div class="saas-card p-5 text-center">
                    <div style="font-size: 4.5rem; color: #e2e8f0; margin-bottom: 20px;"><i class="fa-solid fa-magnifying-glass-minus"></i></div>
                    <h4 class="font-weight-bold text-dark">Folder Tidak Ditemukan</h4>
                    <p style="color: #64748b; max-width: 400px; margin: 0 auto;">Pencarian Anda tidak cocok dengan nama folder atau deskripsi manapun. Silakan coba kata kunci lain.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalTambahFolder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark"><i class="fa-solid fa-folder-plus text-primary mr-2"></i>Buat Folder Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-dark small text-uppercase">Kode Klasifikasi <span class="text-danger">*</span></label>
                            <select class="form-control form-control-modern" name="kode_klasifikasi" id="kode_klasifikasi_tambah" required>
                                <option value="" disabled selected>-- Pilih Kode --</option>
                                @foreach($subbagians as $sb)
                                    @if($sb->kode_klasifikasi)
                                        <option value="{{ $sb->kode_klasifikasi }}">{{ $sb->kode_klasifikasi }}</option>
                                    @endif
                                @endforeach
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-dark small text-uppercase">Nama Folder (Angka) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-modern" name="angka_kategori" id="angka_kategori_tambah" placeholder="Contoh: 1" required>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark small text-uppercase">Deskripsi Singkat (Opsional)</label>
                        <textarea class="form-control form-control-modern" name="deskripsi" rows="3" placeholder="Jelaskan isi dari folder klasifikasi ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold border" style="border-radius: 12px; padding: 10px 20px;" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-modern"><i class="fa-solid fa-save mr-1"></i> Simpan Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        // Toggle disable untuk tambah folder
        const selectTambah = document.getElementById('kode_klasifikasi_tambah');
        const inputAngkaTambah = document.getElementById('angka_kategori_tambah');
        if (selectTambah) {
            selectTambah.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    inputAngkaTambah.disabled = true;
                    inputAngkaTambah.required = false;
                    inputAngkaTambah.value = '';
                } else {
                    inputAngkaTambah.disabled = false;
                    inputAngkaTambah.required = true;
                }
            });
        }

        // Toggle disable untuk edit folder (event delegation)
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('kode-klasifikasi-edit')) {
                const row = e.target.closest('.row');
                if(row) {
                    const inputAngka = row.querySelector('.angka-kategori-edit');
                    if (inputAngka) {
                        if (e.target.value === 'Lainnya') {
                            inputAngka.disabled = true;
                            inputAngka.required = false;
                            inputAngka.value = '';
                        } else {
                            inputAngka.disabled = false;
                            inputAngka.required = true;
                        }
                    }
                }
            }
        });

        const toast = document.getElementById('elegantToast');
        if(toast) {
            setTimeout(() => { toast.classList.add('show'); }, 100);
            setTimeout(() => { tutupToast(); }, 3100); 
        }

        // Live Search / Client-side Filtering
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearchBtn');
        const folderItems = document.querySelectorAll('.folder-item');
        const emptySearchState = document.getElementById('emptySearchState');
        const emptyFolderState = document.getElementById('emptyFolderState');

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                let hasVisible = false;

                if(keyword.length > 0) {
                    clearBtn.style.display = 'block';
                } else {
                    clearBtn.style.display = 'none';
                }

                folderItems.forEach(item => {
                    const nama = item.getAttribute('data-nama');
                    const deskripsi = item.getAttribute('data-deskripsi');

                    if(nama.includes(keyword) || deskripsi.includes(keyword)) {
                        item.style.display = '';
                        hasVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if(folderItems.length > 0) {
                    if(!hasVisible && keyword.length > 0) {
                        emptySearchState.style.display = 'block';
                    } else {
                        emptySearchState.style.display = 'none';
                    }
                }
            });

            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.focus();
            });
        }
    });

    // OPEN FOLDER LOGIC
    function openFolder(event, url) {
        if (event.target.closest('.dropdown') || event.target.closest('.modal')) {
            return; 
        }
        window.location.href = url;
    }

    // SWEETALERT CONFIRM DELETE FOLDER
    function konfirmasiHapusKategori(id) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Folder beserta seluruh arsip di dalamnya akan dipindahkan ke keranjang sampah.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-kategori-' + id).submit();
            }
        });
    }

    // LOGIKA SIDEBAR MOBILE
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
</script>

@if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
<script>
    // REALTIME POLLING
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