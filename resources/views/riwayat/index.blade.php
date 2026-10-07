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

    /* ================= SAAS CARD & WIDGETS ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); overflow: hidden; position: relative; }
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 10px; font-weight: 600; padding: 10px 20px; font-size: 0.85rem; height: 42px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: 0.3s; cursor: pointer;}
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }

    /* FILTER & SEARCH MODERN */
    .filter-wrapper { background-color: #fff; border-bottom: 1px solid #e2e8f0; padding: 15px 24px; }
    .filter-flex-container { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
    .filter-input-modern { border: 1px solid #cbd5e1; border-radius: 10px; background: #fff; font-size: 0.85rem; font-family: 'Poppins'; height: 42px; color: #475569; box-shadow: none; transition: 0.3s; outline: none; }
    .filter-input-modern:focus { border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }

    /* TABLE SAAS */
    .table-modern th { border-top: none; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; padding: 18px 20px; font-weight: 700; background: #fafbfc; white-space: nowrap;}
    .table-modern td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 15px 20px; color: #334155; }
    .table-modern tr:hover td { background-color: #f8fafc; }

    /* BADGE & AVATAR MODERN */
    .badge-modern { padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; letter-spacing: 0.5px; white-space: nowrap; }
    .badge-gray { background-color: #f1f5f9; color: #64748b; }
    .badge-blue { background-color: #eff6ff; color: #2563eb; }
    .badge-green { background-color: #d1fae5; color: #059669; }
    .badge-yellow { background-color: #fef3c7; color: #d97706; }
    .badge-red { background-color: #ffe4e6; color: #e11d48; }

    .avatar-box { width: 40px; height: 40px; border-radius: 12px; background-color: #f8fafc; border: 1px solid #e2e8f0; color: #475569; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);}

    /* DATE PILL SEPARATOR */
    .date-pill { background: #e2e8f0; color: #334155; padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }

    /* SAAS PAGINATION */
    .pagination { margin-bottom: 0; gap: 6px; }
    .page-item .page-link { border: none; border-radius: 10px; color: #64748b; font-weight: 600; font-size: 0.85rem; padding: 8px 16px; transition: all 0.3s ease; background: transparent; }
    .page-item .page-link:hover { background-color: #f1f5f9; color: #0f172a; transform: translateY(-2px); }
    .page-item.active .page-link { background-color: #2563eb; color: #fff; box-shadow: 0 6px 15px -3px rgba(37, 99, 235, 0.4); }
    .page-item.disabled .page-link { color: #cbd5e1; background: transparent; pointer-events: none; }

    /* RESPONSIVITAS MOBILE (SMARTPHONE) */
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
        
        .filter-flex-container { flex-direction: column; align-items: stretch; }
        .btn-primary-modern { width: 100%; }
        .saas-card { border-radius: 16px; }
    }
</style>

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
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Audit Trail & Jejak Aktivitas</h3>
                    <small style="color: #64748b; font-weight: 500; font-size: 0.8rem;">BPK Perwakilan Provinsi Jambi</small>
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

        <div class="saas-card mb-5 mt-4">
            
            <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-white flex-wrap gap-2" style="border-bottom: 1px solid #f1f5f9;">
                <div>
                    <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.1rem;">Catatan Aktivitas Sektor</h5>
                    <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.85rem;">Rekam jejak seluruh pergerakan data dan otorisasi dari semua pengguna sistem.</p>
                </div>
                
                <div>
                    <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 0.85rem;">
                        Total Log: {{ method_exists($riwayats, 'total') ? $riwayats->total() : $riwayats->count() }}
                    </span>
                </div>
            </div>

            <div class="filter-wrapper">
                <form action="{{ route('riwayat.index') }}" method="GET" class="m-0">
                    <div class="filter-flex-container">
                        <div style="flex: 1 1 auto;">
                            <div class="input-group align-items-center" style="border: 1px solid #cbd5e1; border-radius: 10px; background: #fff; overflow: hidden; height: 42px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0" style="padding-right: 10px; padding-left: 15px;"><i class="fa-solid fa-magnifying-glass" style="color: #94a3b8; font-size: 0.9rem;"></i></span>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 shadow-none pl-0 bg-white" placeholder="Cari nama pelaku atau deskripsi kejadian..." style="font-family: 'Poppins'; font-size: 0.9rem; height: 100%;">
                                @if(request('search'))
                                    <div class="input-group-append">
                                        <a href="{{ route('riwayat.index') }}" class="input-group-text bg-white border-0 text-danger" style="text-decoration: none;"><i class="fa-solid fa-xmark"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div style="flex: 0 0 auto;">
                            <button type="submit" class="btn btn-primary-modern m-0">
                                <i class="fa-solid fa-filter mr-2"></i> Filter Log
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive bg-white">
                <table class="table table-modern mb-0" style="table-layout: fixed; width: 100%; min-width: 800px;">
                    <thead>
                        <tr>
                            <th width="15%" class="pl-4">WAKTU</th>
                            <th width="30%">PELAKU SISTEM</th>
                            <th width="18%" class="text-center">JENIS AKSI</th>
                            <th width="37%">KETERANGAN DETAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            \Carbon\Carbon::setLocale('id'); 
                            $lastDate = null; 
                        @endphp
                        
                        @forelse($riwayats as $log)
                            @php
                                // LOGIKA PENGELOMPOKKAN TANGGAL
                                $currentDate = $log->created_at->format('Y-m-d');
                                
                                if ($currentDate == \Carbon\Carbon::today()->format('Y-m-d')) {
                                    $tanggal_header = 'Hari ini - ' . $log->created_at->isoFormat('dddd, D MMMM Y');
                                } elseif ($currentDate == \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                                    $tanggal_header = 'Kemarin - ' . $log->created_at->isoFormat('dddd, D MMMM Y');
                                } else {
                                    $tanggal_header = $log->created_at->isoFormat('dddd, D MMMM Y');
                                }

                                // LOGIKA BADGE WARNA
                                $badgeClass = 'badge-gray';
                                if($log->tipe_aksi == 'CREATE') { $badgeClass = 'badge-green'; } 
                                elseif($log->tipe_aksi == 'UPDATE') { $badgeClass = 'badge-blue'; } 
                                elseif($log->tipe_aksi == 'DELETE') { $badgeClass = 'badge-red'; } 
                                elseif($log->tipe_aksi == 'VERIFIKASI') { $badgeClass = 'badge-yellow'; } 
                            @endphp

                            @if($lastDate != $currentDate)
                                <tr>
                                    <td colspan="4" class="pb-3 pt-4 pl-4" style="background-color: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                                        <div class="date-pill">
                                            <i class="fa-regular fa-calendar-days text-primary mr-2"></i>{{ $tanggal_header }}
                                        </div>
                                    </td>
                                </tr>
                                @php $lastDate = $currentDate; @endphp
                            @endif

                            <tr>
                                <td class="pl-4">
                                    <div class="font-weight-bold" style="color: #475569; font-size: 0.85rem;"><i class="fa-regular fa-clock mr-1 text-muted"></i> {{ $log->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box mr-3">
                                            {{ strtoupper(substr($log->user->name ?? '?', 0, 2)) }}
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark" style="font-size: 0.9rem;">{{ $log->user->name ?? 'User Terhapus' }}</strong>
                                            <small style="color: #64748b; font-weight: 500;">{{ $log->user->email ?? 'Sistem BPK' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge-modern {{ $badgeClass }}">
                                        {{ $log->tipe_aksi }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #334155; font-size: 0.85rem; line-height: 1.5; padding-right: 15px;">
                                        {{ $log->deskripsi }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 bg-white">
                                    <div style="background: #f8fafc; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                                        <i class="fa-solid fa-clock-rotate-left" style="font-size: 1.8rem; color: #cbd5e1;"></i>
                                    </div>
                                    <h6 style="color: #475569; font-weight: 600; font-size: 0.9rem;">Belum Ada Catatan Aktivitas</h6>
                                    <p class="small mb-0" style="color: #94a3b8;">Jejak pergerakan data akan otomatis direkam di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($riwayats, 'hasPages') && $riwayats->hasPages())
            <div class="p-3 bg-white border-top d-flex justify-content-end" style="border-radius: 0 0 20px 20px;">
                {{ $riwayats->onEachSide(1)->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
            @endif
            
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