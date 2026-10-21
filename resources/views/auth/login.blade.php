<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIKANTI BPK RI Jambi</title>
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Poppins (Utama) & Playfair Display (Khusus Selamat Datang) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <style>
        /* ================= KUNCI SCROLL MUTLAK GLOBAL ================= */
        html, body { 
            background-color: #ffffff; 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            padding: 0; 
            width: 100vw;
            height: 100vh; /* Mengunci tinggi layar mutlak */
            overflow: hidden !important; /* Menghilangkan scrollbar secara global */
        }

        #app > nav { display: none !important; }
        main { padding: 0 !important; }

        .login-wrapper { 
            height: 100vh; 
            width: 100vw;
            display: flex; 
            margin: 0 !important;
            overflow: hidden;
        }
        
        /* ================= SISI KIRI (BRANDING POLOS & ELEGAN) ================= */
        .login-left { 
            background: linear-gradient(135deg, #020617 0%, #0f172a 40%, #1e3a8a 100%);
            color: white; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            padding: 30px; 
            position: relative; 
            height: 100vh;
            overflow: hidden;
        }
        
        .app-logo { 
            max-width: 150px; 
            max-height: 150px;
            margin-bottom: 25px; 
            object-fit: contain;
            background-color: transparent !important; 
            filter: drop-shadow(0 0 30px rgba(96, 165, 250, 0.5)) drop-shadow(0 0 10px rgba(255, 255, 255, 0.1));
            animation: floatingGlow 4s ease-in-out infinite alternate;
            z-index: 2;
        }
        
        @keyframes floatingGlow {
            0% { filter: drop-shadow(0 0 20px rgba(96, 165, 250, 0.2)); transform: translateY(0px); }
            100% { filter: drop-shadow(0 0 40px rgba(96, 165, 250, 0.8)); transform: translateY(-8px); }
        }
        
        .bpk-text { 
            font-size: 0.85rem; 
            letter-spacing: 4px; 
            color: #94a3b8; 
            text-transform: uppercase; 
            margin-bottom: 5px; 
            font-weight: 700;
            z-index: 2;
        }

        .sikanti-title {
            background: linear-gradient(to right, #60a5fa, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
            letter-spacing: 1px;
            font-size: 3rem;
            text-shadow: 0px 10px 30px rgba(96, 165, 250, 0.2);
            margin-bottom: 10px;
            z-index: 2;
        }

        .sub-title-text {
            color: #cbd5e1; 
            max-width: 450px; 
            font-size: 0.95rem; 
            line-height: 1.5; 
            font-weight: 500;
            z-index: 2;
        }

        .glow-effect {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(15,23,42,0) 65%);
            top: -150px;
            left: -150px;
            border-radius: 50%;
            z-index: 1;
        }

        /* ================= SISI KANAN (FORM LOGIN SAAS PREMIUM) ================= */
        .login-right { 
            background-color: #ffffff; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh;
            padding: 20px;
            overflow: hidden; /* Mengunci scroll sisi kanan */
        }
        
        .login-form-box { 
            width: 100%; 
            max-width: 400px; 
        }

        /* ================= FONT KHUSUS "SELAMAT DATANG" ================= */
        .greeting-text {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }
        
        /* Input Form Gaya Modern (Soft UI) */
        .custom-input { 
            border-radius: 0 12px 12px 0; 
            padding: 10px 16px; 
            border: 2px solid transparent; 
            background-color: #f1f5f9; 
            color: #1e293b;
            transition: all 0.3s ease; 
            height: 48px; 
            font-size: 0.9rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            box-shadow: none !important;
        }
        
        .input-group-text {
            border-radius: 12px 0 0 12px;
            background-color: #f1f5f9;
            border: 2px solid transparent;
            border-right: none;
            padding: 0 18px;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .custom-input, 
        .input-group:focus-within .input-group-text { 
            border-color: #3b82f6; 
            background-color: #ffffff; 
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        }
        .input-group:focus-within .input-group-text i { color: #2563eb !important; }
        
        .btn-login { 
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff; 
            border-radius: 12px; 
            padding: 12px; 
            font-weight: 700; 
            font-size: 1rem;
            letter-spacing: 0.5px;
            width: 100%; 
            border: none; 
            transition: all 0.3s ease; 
            box-shadow: 0 8px 20px -5px rgba(37, 99, 235, 0.4);
        }
        
        .btn-login:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 12px 25px -5px rgba(37, 99, 235, 0.5); 
            color: #fff;
        }

        .app-logo-mobile {
            max-width: 80px;
            max-height: 80px;
            background: transparent !important;
            filter: drop-shadow(0 8px 12px rgba(37, 99, 235, 0.2));
            margin-bottom: 10px;
        }
        
        /* Custom Checkbox */
        .custom-control-label::before { border-radius: 6px; border: 2px solid #cbd5e1; top: 0.15rem; width: 1.15rem; height: 1.15rem;}
        .custom-control-label::after { top: 0.15rem; width: 1.15rem; height: 1.15rem;}
        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before { background-color: #2563eb; border-color: #2563eb; }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <!-- ================= SISI KIRI: BRANDING APLIKASI ================= -->
        <div class="col-lg-6 login-left d-none d-lg-flex text-center">
            <div class="glow-effect"></div>
            
            @php
                $app_setting = \App\Pengaturan::first();
            @endphp

            @if(isset($app_setting) && $app_setting->logo_aplikasi)
                <img src="{{ asset('storage/pengaturan/' . $app_setting->logo_aplikasi) }}" alt="Logo Aplikasi" class="app-logo">
            @else
                <!-- Fallback Jika Logo Belum Diupload -->
                <div class="text-white d-inline-flex justify-content-center align-items-center mb-4" style="width: 120px; height: 120px; border-radius: 30px; font-size: 3.5rem; background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%); box-shadow: 0 15px 30px rgba(37,99,235,0.4); z-index: 2;">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            @endif
            
            <div class="bpk-text">BPK Perwakilan Provinsi Jambi</div>
            
            <div class="sikanti-title">
                {{ isset($app_setting) ? $app_setting->nama_aplikasi : 'SIKANTI' }}
            </div>
            
            <p class="sub-title-text mx-auto">
                Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi
            </p>
        </div>

        <!-- ================= SISI KANAN: FORM LOGIN ================= -->
        <div class="col-lg-6 col-12 login-right">
            <div class="login-form-box">
                
                <!-- Tampilan Header Mobile -->
                <div class="text-center d-block d-lg-none mb-3 mt-2">
                    @if(isset($app_setting) && $app_setting->logo_aplikasi)
                        <img src="{{ asset('storage/pengaturan/' . $app_setting->logo_aplikasi) }}" alt="Logo" class="app-logo-mobile mb-2">
                    @else
                        <div class="text-white d-inline-flex justify-content-center align-items-center mb-2" style="width: 70px; height: 70px; border-radius: 18px; font-size: 2rem; background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%); box-shadow: 0 10px 20px rgba(37,99,235,0.3);">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    @endif
                    <h4 class="font-weight-bold text-dark mb-0" style="font-size: 1.2rem;">{{ isset($app_setting) ? $app_setting->nama_aplikasi : 'SIKANTI' }}</h4>
                </div>

                <!-- Bagian Selamat Datang yang Dimampatkan -->
                <div class="mb-4">
                    <h2 class="greeting-text">Selamat Datang!</h2>
                    <p style="color: #64748b; font-size: 0.95rem; font-weight: 400; margin-bottom: 0;">Silakan masuk menggunakan kredensial Anda.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-uppercase" style="letter-spacing: 1px; color: #64748b;">Alamat Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-envelope" style="color: #94a3b8; font-size: 1rem;"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email operasional...">
                        </div>
                        @error('email')
                            <span class="text-danger small mt-1 d-block font-weight-bold" role="alert"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-uppercase w-100 d-flex justify-content-between align-items-center" style="letter-spacing: 1px; color: #64748b; margin-bottom: 8px;">
                            Kata Sandi
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-capitalize" style="letter-spacing: 0; font-weight: 600; color: #3b82f6; transition: 0.2s; font-size: 0.85rem;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#3b82f6'">Lupa Sandi?</a>
                            @endif
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-lock" style="color: #94a3b8; font-size: 1rem;"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi rahasia...">
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block font-weight-bold" role="alert"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="custom-control custom-checkbox ml-1">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" style="padding-top: 3px; cursor: pointer; color: #64748b; font-size: 0.85rem;" for="remember">Biarkan saya tetap masuk</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login mb-3">
                        Masuk ke Sistem <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                    </button>
                    
                    <!-- LINK REGISTER MINIMALIS -->
                    @if (Route::has('register'))
                        <div class="text-center font-weight-bold" style="color: #64748b; font-size: 0.85rem;">
                            Belum memiliki kredensial? 
                            <a href="{{ route('register') }}" style="color: #3b82f6; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#3b82f6'">Daftar Sekarang</a>
                        </div>
                    @endif
                </form>
                
                <div class="text-center mt-4 pt-3 border-top small" style="color: #94a3b8; font-weight: 500; border-color: #f1f5f9 !important; font-size: 0.75rem;">
                    &copy; {{ date('Y') }} BPK Perwakilan Jambi. All rights reserved.
                    <div class="mt-1" style="font-size: 0.7rem; color: #94a3b8; opacity: 0.45; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.45'">
                        Developed by <span style="color: #2563eb; font-weight: 600;">Farhan</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>