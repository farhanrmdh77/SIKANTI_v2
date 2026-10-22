<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dokumen E-Arsip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #f8fafc; font-family: 'Nunito', sans-serif; }
        .mobile-container { max-width: 480px; margin: 0 auto; background: #fff; min-height: 100vh; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
        .header { background: #111827; padding: 30px 20px 40px 20px; border-radius: 0 0 24px 24px; color: #fff; text-align: center; }
        .card-arsip { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px; margin: -25px 20px 20px 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); position: relative; z-index: 10; }
        .btn-gold { background-color: #C8A35A; color: #fff; font-weight: bold; border-radius: 12px; padding: 12px; border: none; }
        .btn-gold:hover { background-color: #b5924e; color: #fff; }
        .form-control { border-radius: 10px; background-color: #f9fafb; border: 1px solid #e5e7eb; }
        .form-control:focus { border-color: #C8A35A; box-shadow: none; background-color: #fff; }
        
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #C8A35A; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="mobile-container pb-5">
    
    <div class="header">
        <div class="mb-2"><i class="fa-solid fa-shield-halved text-warning" style="font-size: 2rem;"></i></div>
        <h5 class="font-weight-bold mb-0">Verifikasi Keamanan</h5>
        <small class="text-white-50">Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi</small>
    </div>

    <div class="card-arsip">
        <div class="text-center mb-3">
            <span class="badge badge-primary bg-opacity-10 text-primary px-3 py-1 mb-2" style="border-radius: 6px; background-color: #eff6ff;">Dokumen Terkunci</span>
            <h5 class="font-weight-bold text-dark mb-1">{{ $arsip->nama_arsip }}</h5>
            <small class="text-muted font-weight-bold">KODE: {{ optional($arsip->kategori)->nama_kategori }} / {{ $arsip->nomor_dokumen }}</small>
        </div>

        <hr>

        @if(!$verifikasi)
            <p class="text-muted small text-center mb-4">Anda harus meminta izin akses kepada Admin / Pemegang Brankas untuk membuka detail dokumen ini.</p>
            
            <form action="{{ route('scan.request', $arsip->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold text-dark small">NAMA LENGKAP</label>
                    <input type="text" class="form-control" name="nama_pemohon" placeholder="Masukkan nama Anda..." required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-dark small">ASAL SUBBAGIAN</label>
                    <select class="form-control" name="subbagian_pemohon" required style="cursor: pointer; appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'%236b7280\' viewBox=\'0 0 16 16\'><path fill-rule=\'evenodd\' d=\'M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z\'/></svg>'); background-repeat: no-repeat; background-position: right 15px center; padding-right: 40px;">
                        <option value="" selected disabled>-- Pilih Subbagian --</option>
                        <option value="SDM">SDM</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="Hukum">Hukum</option>
                        <option value="Humas TU & Kalan">Humas TU & Kalan</option>
                        <option value="Umum & IT">Umum & IT</option>
                        <option value="Pemeriksa">Pemeriksa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-dark small">TUJUAN AKSES</label>
                    <textarea class="form-control" name="tujuan_akses" rows="2" placeholder="Jelaskan keperluan Anda meminjam/melihat arsip ini..." required></textarea>
                </div>
                <button type="submit" class="btn btn-gold btn-block mt-4 shadow-sm"><i class="fa-solid fa-paper-plane mr-2"></i> Minta Izin Akses</button>
            </form>

        @elseif($verifikasi->status == 'Menunggu')
            <div class="text-center py-4">
                <div class="loader mb-3"></div>
                <h6 class="font-weight-bold text-dark">Menunggu Persetujuan...</h6>
                <p class="text-muted small mb-0">Permintaan Anda sedang ditinjau oleh Admin. Layar ini akan diperbarui otomatis setelah disetujui.</p>
            </div>

        @elseif($verifikasi->status == 'Ditolak')
            <div class="text-center py-4">
                <i class="fa-solid fa-circle-xmark text-danger mb-3" style="font-size: 3rem;"></i>
                <h6 class="font-weight-bold text-danger">Akses Ditolak!</h6>
                <p class="text-muted small mb-3">Admin tidak mengizinkan Anda untuk mengakses arsip ini.</p>
                <div class="bg-light p-3 rounded text-left border">
                    <small class="font-weight-bold text-dark d-block mb-1">Catatan Admin:</small>
                    <small class="text-danger">"{{ $verifikasi->catatan_admin }}"</small>
                </div>
            </div>

        @elseif($verifikasi->status == 'Disetujui')
            <div class="text-center py-3 mb-3 border-bottom">
                <i class="fa-solid fa-circle-check text-success mb-2" style="font-size: 2.5rem;"></i>
                <h6 class="font-weight-bold text-success mb-0">Akses Diberikan!</h6>
            </div>

            <div class="mb-3">
                <small class="text-muted font-weight-bold d-block mb-1">DETAIL & URAIAN ARSIP:</small>
                <div class="p-3 bg-light rounded border" style="font-size: 0.9rem; line-height: 1.5; color: #374151; white-space: pre-line;">{{ $arsip->keterangan ?? 'Tidak ada uraian khusus.' }}</div>
            </div>

            <ul class="list-group list-group-flush mb-4 small">
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">Tahun Berkas:</span><span class="font-weight-bold">{{ $arsip->tahun_berkas ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">Jumlah Berkas:</span><span class="font-weight-bold">{{ $arsip->jumlah_berkas ?? '1' }} Lembar</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">Warna Map:</span>
                    <span class="font-weight-bold">
                        @if($arsip->warna_berkas) <span class="badge badge-light border">{{ $arsip->warna_berkas }}</span> @else - @endif
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">Jadwal Retensi:</span><span class="font-weight-bold">Aktif ({{ $arsip->retensi_aktif ?? '-' }} Thn) / Inaktif ({{ $arsip->retensi_inaktif ?? '-' }} Thn)</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">Status JRA:</span>
                    <span class="font-weight-bold">
                        @if($arsip->status_retensi == 'Musnah') <span class="text-danger"><i class="fa-solid fa-fire mr-1"></i> Telah Musnah</span>
                        @elseif($arsip->status_retensi == 'Permanen') <span class="text-primary"><i class="fa-solid fa-building-columns mr-1"></i> Permanen</span>
                        @elseif($arsip->status_retensi == 'Inaktif') <span class="text-warning">Inaktif</span>
                        @elseif($arsip->status_retensi == 'Aktif') <span class="text-success">Aktif</span>
                        @else <span class="text-secondary">{{ $arsip->status_retensi }}</span> @endif
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                    <span class="text-muted">Nasib Akhir:</span><span class="font-weight-bold">{{ $arsip->nasib_akhir ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0" style="border-top: 1px dashed #e2e8f0 !important; margin-top: 5px; padding-top: 10px !important;">
                    <span class="text-muted">Lokasi Fisik:</span><span class="font-weight-bold" style="color: #2563eb;"><i class="fa-solid fa-location-dot mr-1"></i> {{ $arsip->lokasi_fisik ?? '-' }}</span>
                </li>
            </ul>

            @if($verifikasi->izin_unduh && $arsip->file_dokumen)
                <div class="d-flex" style="gap: 10px;">
                    <button type="button" class="btn btn-info font-weight-bold py-2 flex-fill" style="border-radius: 12px; background-color: #0ea5e9; border:none;" data-toggle="modal" data-target="#modalPreview">
                        <i class="fa-solid fa-eye mr-1"></i> Pratinjau
                    </button>
                    <a href="{{ asset('storage/arsip_dokumen/'.$arsip->file_dokumen) }}" target="_blank" class="btn btn-primary font-weight-bold py-2 flex-fill" style="border-radius: 12px; background-color: #2563eb; border:none;">
                        <i class="fa-solid fa-cloud-arrow-down mr-1"></i> Unduh
                    </a>
                </div>
            @elseif(!$arsip->file_dokumen)
                <button class="btn btn-secondary btn-block font-weight-bold py-2" disabled style="border-radius: 12px;"><i class="fa-solid fa-ban mr-2"></i> File Digital Tidak Tersedia</button>
            @else
                <button class="btn btn-outline-danger btn-block font-weight-bold py-2" disabled style="border-radius: 12px;"><i class="fa-solid fa-lock mr-2"></i> Akses Unduhan Terkunci</button>
            @endif
            
        @endif
    </div>
</div>

@if($verifikasi && $verifikasi->status == 'Disetujui' && $verifikasi->izin_unduh && $arsip->file_dokumen)
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="modal-header bg-dark text-white border-0 py-3 px-4">
                <h6 class="modal-title font-weight-bold mb-0"><i class="fa-solid fa-file-magnifying-glass mr-2"></i> Pratinjau Dokumen</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 bg-light text-center" style="min-height: 300px;">
                @php
                    $ext = strtolower(pathinfo($arsip->file_dokumen, PATHINFO_EXTENSION));
                    $fileUrl = asset('storage/arsip_dokumen/'.$arsip->file_dokumen);
                @endphp
                
                @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ $fileUrl }}" alt="Preview" class="img-fluid m-3 rounded shadow-sm" style="max-height: 65vh; object-fit: contain;">
                
                @elseif($ext == 'pdf')
                    <div id="pdf-wrapper" style="height: 65vh; overflow-y: auto; background: #cbd5e1; padding: 15px;">
                        <div id="pdf-loading" class="text-center mt-5 text-dark">
                            <i class="fa-solid fa-spinner fa-spin fa-2x mb-2"></i><br><span class="font-weight-bold">Memuat Pratinjau PDF...</span>
                        </div>
                        <div id="pdf-render-area" class="d-flex flex-column align-items-center"></div>
                    </div>
                    
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                var url = '{{ $fileUrl }}';
                                var pdfjsLib = window['pdfjs-dist/build/pdf'];
                                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

                                var loadingTask = pdfjsLib.getDocument(url);
                                loadingTask.promise.then(function(pdf) {
                                    document.getElementById('pdf-loading').style.display = 'none';
                                    
                                    var totalPages = pdf.numPages;
                                    var maxPages = totalPages > 5 ? 5 : totalPages; // Batasi 5 halaman untuk kecepatan HP
                                    var renderArea = document.getElementById('pdf-render-area');

                                    for (let i = 1; i <= maxPages; i++) {
                                        pdf.getPage(i).then(function(page) {
                                            var scale = 1.2;
                                            var viewport = page.getViewport({scale: scale});
                                            
                                            var canvas = document.createElement('canvas');
                                            canvas.style.maxWidth = '100%';
                                            canvas.style.marginBottom = '15px';
                                            canvas.style.boxShadow = '0 4px 10px rgba(0,0,0,0.15)';
                                            canvas.style.backgroundColor = '#fff';
                                            
                                            var context = canvas.getContext('2d');
                                            canvas.height = viewport.height;
                                            canvas.width = viewport.width;
                                            
                                            var renderContext = { canvasContext: context, viewport: viewport };
                                            page.render(renderContext);
                                            renderArea.appendChild(canvas);
                                        });
                                    }
                                    
                                    if(totalPages > 5) {
                                        var info = document.createElement('div');
                                        info.className = "text-dark small mt-2 font-weight-bold bg-white p-2 rounded shadow-sm";
                                        info.innerText = "Pratinjau dibatasi 5 halaman. Silakan unduh untuk membaca keseluruhan.";
                                        renderArea.appendChild(info);
                                    }
                                }).catch(function(err) {
                                    document.getElementById('pdf-loading').innerHTML = '<i class="fa-solid fa-triangle-exclamation text-danger fa-2x mb-2"></i><br><span class="font-weight-bold">Gagal merender pratinjau.</span><br><small>Silakan gunakan tombol Lanjut Unduh di bawah.</small>';
                                });
                            }, 500); // Beri jeda 0.5 detik agar Modal HTML siap sepenuhnya
                        });
                    </script>
                
                @elseif(in_array($ext, ['doc', 'docx', 'xls', 'xlsx']))
                    <div class="p-3 bg-warning text-dark small font-weight-bold text-left border-bottom">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Catatan: Pratinjau Word/Excel membutuhkan akses server secara Online/Publik. Jika aplikasi ini diakses via Localhost, dokumen tidak akan muncul dan harus diunduh.
                    </div>
                    <iframe src="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true" width="100%" height="500px" style="border: none; display: block;"></iframe>
                
                @else
                    <div class="py-5 my-5">
                        <i class="fa-solid fa-file-circle-exclamation text-secondary mb-3" style="font-size: 4rem;"></i>
                        <h6 class="text-dark font-weight-bold">Format File (.{{ $ext }}) tidak didukung untuk pratinjau.</h6>
                        <p class="small text-muted mb-0">Silakan unduh file untuk melihat isi selengkapnya secara langsung.</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer border-0 bg-white px-4 py-3">
                <button type="button" class="btn btn-light border font-weight-bold" style="border-radius: 10px;" data-dismiss="modal">Tutup</button>
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary font-weight-bold" style="border-radius: 10px; background-color: #2563eb; border:none;">
                    <i class="fa-solid fa-cloud-arrow-down mr-1"></i> Lanjut Unduh
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($verifikasi)
<script>
    let currentStatus = '{{ $verifikasi->status }}';
    
    // Polling pintar: Memeriksa database setiap 3 detik di latar belakang
    setInterval(function() {
        fetch('{{ route("api.scan.status", $verifikasi->id) }}')
        .then(response => response.json())
        .then(data => {
            if(data.status !== currentStatus) {
                if(data.status === 'Disetujui') {
                    Swal.fire({
                        icon: 'success', 
                        title: 'Akses Diberikan!', 
                        text: 'Admin telah menyetujui permintaan Anda. Memuat dokumen...', 
                        showConfirmButton: false, 
                        timer: 2000,
                        timerProgressBar: true,
                        allowOutsideClick: false
                    }).then(() => { 
                        window.location.reload(); 
                    });
                } 
                else if(data.status === 'Ditolak' || data.status === 'Dihapus') {
                    Swal.fire({
                        icon: 'error', 
                        title: 'Akses Terputus!', 
                        text: 'Admin menolak/mencabut izin Anda. Mengalihkan...', 
                        showConfirmButton: false, 
                        timer: 2000,
                        timerProgressBar: true,
                        allowOutsideClick: false
                    }).then(() => { 
                        window.location.reload(); 
                    });
                }
                currentStatus = data.status;
            }
        })
        .catch(error => console.log('Menyambungkan ke server...'));
    }, 3000);
</script>
@endif
</body>
</html>