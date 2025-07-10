@extends('layouts.admin.tabler')
@section('content')
<div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                  Buat Kode
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                </div>
              </div>
            </div>
    <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Kode</h3>
                  </div>
                  <div class="card-body">
                    <div class="row row-cards">
                      <div class="col-md">
                        <div class="card">
                          <div class="card-status-top bg-red"></div>
                          <div class="card-header">
                            <h3 class="card-title">Kode Presensi</h3>
                          </div>

                          <div class="card-body p-0 text-center ">
                          <h1 id="kode-acak" class="display-1">Memuat...</h1>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

@endsection
@push('myscript')
<script>
    function loadKodeAcak() {
        fetch('/api/kode-acak')
            .then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error " + response.status);
                }
                return response.json();
            })
            .then(data => {
                const kodeEl = document.getElementById('kode-acak');
                if (kodeEl) {
                    kodeEl.textContent = data.kode;
                }
            })
            .catch(error => {
                console.error('Gagal memuat kode:', error);
                const kodeEl = document.getElementById('kode-acak');
                if (kodeEl) {
                    kodeEl.textContent = 'ERROR';
                }
            });
    }

    // Panggil saat pertama kali halaman dibuka
    loadKodeAcak();

    // Jalankan ulang setiap 30 detik (30000 ms)
    setInterval(loadKodeAcak, 100000);
</script>
@endpush
