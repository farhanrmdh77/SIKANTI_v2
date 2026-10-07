import sys
import codecs
with codecs.open(r'd:\laragon\www\SIKANTI_V2\resources\views\arsip\show.blade.php', 'r', 'utf-8') as f:
    lines = f.readlines()

# find where <div class="saas-card mb-5"> is 
start = -1
for i, line in enumerate(lines):
    if '<div class="saas-card mb-5">' in line:
        start = i
        break

new_content = ''.join(lines[:start])

new_content += '''        <div class="saas-card mb-5">
            <div class="px-4 py-4 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h5 class="font-weight-bold mb-0" style="color: #1e293b; font-size: 1.25rem;">
                            <i class="fa-solid fa-circle-info text-primary mr-2"></i>Detail Uraian Arsip
                        </h5>
                        <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.9rem;">Informasi lengkap tentang arsip dokumen ini.</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        @if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
                        <a href="{{ route('arsip.edit', [\->id, \->id]) }}" class="btn btn-warning text-dark font-weight-bold mr-2" style="border-radius: 8px; font-size: 0.85rem;">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Arsip
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="row">
                    <!-- Detail Kiri -->
                    <div class="col-md-5 border-right pr-4">
                        <h6 class="font-weight-bold text-primary mb-3" style="font-size: 0.9rem;"><i class="fa-solid fa-list-check mr-2"></i>Spesifikasi Berkas</h6>
                        <table class="table table-borderless table-sm mb-0" style="font-size: 0.85rem;">
                            <tr>
                                <td width="45%" class="text-muted font-weight-bold pb-3">KODE KLASIFIKASI</td>
                                <td class="pb-3">: <strong class="text-dark">{{ Auth::user()->subbagian->kode_klasifikasi }}.{{ \->nomor_dokumen }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">NAMA BERKAS</td>
                                <td class="pb-3">: <span class="text-dark font-weight-bold">{{ \->nama_arsip }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">TAHUN & JUMLAH</td>
                                <td class="pb-3">: {{ \->tahun_berkas ?? '-' }} ({{ \->jumlah_berkas }} Berkas)</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">JADWAL RETENSI</td>
                                <td class="pb-3">: Aktif ({{ \->retensi_aktif ?? '-' }} Thn) | Inaktif ({{ \->retensi_inaktif ?? '-' }} Thn)</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">STATUS JRA</td>
                                <td class="pb-3">: 
                                    @if(\->status_retensi == 'Musnah') <span class="badge-modern badge-red">Telah Musnah</span>
                                    @elseif(\->status_retensi == 'Permanen') <span class="badge-modern badge-blue">Permanen</span>
                                    @elseif(\->status_retensi == 'Inaktif') <span class="badge-modern badge-yellow">Inaktif</span>
                                    @else <span class="badge-modern badge-green">Aktif</span> @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">NASIB AKHIR</td>
                                <td class="pb-3">: {{ \->nasib_akhir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted font-weight-bold pb-3">LOKASI & WARNA</td>
                                <td class="pb-3">: {{ \->lokasi_fisik ?? '-' }} <span class="badge badge-light border ml-1">{{ \->warna_berkas ?? '-' }}</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Detail Kanan -->
                    <div class="col-md-7 pl-4 d-flex flex-column">
                        <div class="flex-grow-1">
                            <h6 class="font-weight-bold text-warning mb-3" style="font-size: 0.9rem;"><i class="fa-solid fa-align-left mr-2"></i>Uraian Deskripsi</h6>
                            <div class="p-4 rounded shadow-sm" style="background: #f8fafc; min-height: 180px; font-size: 0.9rem; line-height: 1.7; border: 1px solid #e2e8f0; border-left: 4px solid #C8A35A;">{{ \->keterangan ?? 'Tidak ada deskripsi yang dilampirkan.' }}</div>
                        </div>
                        
                        <div class="mt-4">
                            @if(\->file_dokumen)
                                <a href="{{ asset('storage/arsip_dokumen/'.\->file_dokumen) }}" target="_blank" class="btn btn-primary-modern w-100 justify-content-center py-3" style="font-size: 0.95rem; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);">
                                    <i class="fa-solid fa-file-signature mr-2"></i> Buka / Unduh File Digital
                                </a>
                            @else
                                <button class="btn w-100 py-3 font-weight-bold" style="background: #f1f5f9; color: #94a3b8; border-radius: 10px; cursor: not-allowed; font-size: 0.95rem;" disabled>
                                    <i class="fa-solid fa-ban mr-2"></i> Tidak Ada File Digital
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- JS Scripts Sama seperti sebelumnya -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
        document.querySelector('.sidebar-overlay').classList.toggle('show');
    }
    function tutupToast() {
        const toast = document.getElementById('elegantToast');
        if (toast) {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 500);
        }
    }
    window.addEventListener('load', function() {
        const toast = document.getElementById('elegantToast');
        if (toast) {
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => { tutupToast(); }, 3000);
        }
    });
</script>
@endsection
'''

with codecs.open(r'd:\laragon\www\SIKANTI_V2\resources\views\arsip\show.blade.php', 'w', 'utf-8') as f:
    f.write(new_content)
print('Done writing show.blade.php')
