<div class="sidebar">
    <div class="sidebar-header d-flex align-items-center">
        @if(isset($app_setting) && $app_setting->logo_aplikasi)
            <img src="{{ asset('storage/pengaturan/' . $app_setting->logo_aplikasi) }}" alt="Logo" class="mr-3" style="width: 48px; height: 48px; object-fit: contain; background: transparent; filter: drop-shadow(0 0 12px rgba(96, 165, 250, 0.7));">
        @else
            <div class="bg-primary text-white mr-3 shadow-lg" style="width: 48px; height: 48px; font-size: 1.2rem; border-radius: 14px; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-boxes-stacked"></i></div>
        @endif
        
        <div>
            <h5 class="mb-0 font-weight-bold" style="font-size: 1.15rem; letter-spacing: 0.5px; background: linear-gradient(to right, #60a5fa, #ffffff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 20px rgba(96, 165, 250, 0.1);">
                {{ isset($app_setting) ? $app_setting->nama_aplikasi : 'SIKANTI' }}
            </h5>
            <small style="color: #94a3b8; font-size: 0.6rem; display: block; line-height: 1.3; margin-top: 2px; font-weight: 500; letter-spacing: 0.5px;">
                {{ isset($app_setting) && $app_setting->sub_judul ? $app_setting->sub_judul : 'Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi' }}
            </small>
        </div>
    </div>

    <div class="px-4 mb-3 mt-4" style="color: #475569; font-weight: 700; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Navigasi Utama</div>
    
    <ul class="sidebar-menu">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
        
        @if(Auth::user()->role != 'Superadmin')
        <li><a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') || request()->routeIs('arsip.*') ? 'active' : '' }}"><i class="fa-solid fa-folder-open"></i> Gudang Folder</a></li>
        @endif
        
        @if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
        <li>
            <a href="{{ route('verifikasi.index') }}" class="{{ request()->routeIs('verifikasi.*') ? 'active' : '' }} d-flex align-items-center">
                <i class="fa-solid fa-shield-halved"></i> Verifikasi Akses
                <span id="badge-verifikasi-global" class="badge badge-danger ml-auto" style="display: none; border-radius: 8px; padding: 5px 8px; font-family: 'Poppins';">0</span>
            </a>
        </li>
        <li><a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Manajemen Tim</a></li>
        <li><a href="{{ route('sampah.index') }}" class="{{ request()->routeIs('sampah.*') ? 'active' : '' }}"><i class="fa-solid fa-trash-can"></i> Kelola Sampah</a></li>
        @endif
        
        @if(Auth::user()->role == 'Superadmin')
        <li><a href="{{ route('superadmin.users.index') }}" class="{{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users-gear"></i> Manajemen Pengguna</a></li>
        @endif

        <div class="px-4 mb-3 mt-4" style="color: #475569; font-weight: 700; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Sistem</div>
        
        <li><a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}"><i class="fa-solid fa-clock-rotate-left"></i> Jejak Aktivitas</a></li>

        <li><a href="{{ route('pengaturan.index') }}" class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"><i class="fa-solid fa-sliders"></i> Pengaturan Utama</a></li>
    </ul>

    <div class="mt-auto p-4 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
        @if(Auth::user()->role !== 'Superadmin')
        <div style="background: rgba(255,255,255,0.03); border-radius: 16px; padding: 15px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
            <small style="color: #64748b; font-size: 0.65rem; font-weight: 600; display: block; margin-bottom: 2px;">
                SEKTOR AKTIF • <span style="color: #fbbf24;">{{ Auth::user()->role ? strtoupper(Auth::user()->role) : 'USER' }}</span>
            </small>
            <strong style="color: #C8A35A; font-size: 0.9rem;">{{ Auth::user()->subbagian->nama_subbag ?? 'UMUM' }} ({{ Auth::user()->subbagian->kode_klasifikasi ?? 'XX' }})</strong>
        </div>
        @endif
        
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-block" style="background: rgba(225, 29, 72, 0.1); color: #fb7185; border-radius: 12px; font-weight: 600; font-size: 0.9rem; padding: 12px; transition: 0.3s;">
            <i class="fa-solid fa-right-from-bracket mr-2"></i> Akhiri Sesi
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</div>
