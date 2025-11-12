@extends('layouts.app')

@section('title', 'Dashboard Absensi')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/asset/library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard Absensi</h1>
    </div>

    {{-- Statistik Utama --}}
    <div class="row">
      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-building"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Total Perusahaan</h4></div>
            <div class="card-body">8</div>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Total Karyawan</h4></div>
            <div class="card-body">125</div>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-user-check"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Hadir Hari Ini</h4></div>
            <div class="card-body">98</div>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-clock"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Terlambat</h4></div>
            <div class="card-body">7</div>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-user-times"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Izin / Cuti</h4></div>
            <div class="card-body">3</div>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-secondary">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Absen di Luar Area</h4></div>
            <div class="card-body">2</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Statistik Kehadiran (Doughnut Chart) --}}
    <div class="row">
      <div class="col-lg-8 col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4>Statistik Kehadiran</h4>
            <div class="card-header-action">
              <a href="#" class="btn active">Hari Ini</a>
              <a href="#" class="btn">Minggu Ini</a>
              <a href="#" class="btn">Bulan Ini</a>
            </div>
          </div>

          {{-- Tinggi card diatur agar compact --}}
          <div class="card-body text-center p-3" style="height: 450px;">
            <canvas id="attendanceDoughnut" style="max-height: 300px;"></canvas>

            <div class="statistic-details mt-2">
              <div class="statistic-details-item">
                <div class="detail-value">98</div>
                <div class="detail-name">Hadir</div>
              </div>
              <div class="statistic-details-item">
                <div class="detail-value">7</div>
                <div class="detail-name">Terlambat</div>
              </div>
              <div class="statistic-details-item">
                <div class="detail-value">3</div>
                <div class="detail-name">Izin / Cuti</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Daftar Kehadiran Hari Ini --}}
      <div class="col-lg-4 col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4>Kehadiran Hari Ini</h4>
          </div>
          <div class="card-body p-3">
            <ul class="list-unstyled list-unstyled-border">
              <li class="media">
                <img class="rounded-circle mr-3" width="45" src="{{ asset('backend/asset/img/avatar/avatar-1.png') }}" alt="avatar">
                <div class="media-body">
                  <div class="float-right text-success">07:55</div>
                  <div class="media-title">Andi Saputra</div>
                  <span class="text-small text-muted">Tepat waktu</span>
                </div>
              </li>
              <li class="media">
                <img class="rounded-circle mr-3" width="45" src="{{ asset('backend/asset/img/avatar/avatar-2.png') }}" alt="avatar">
                <div class="media-body">
                  <div class="float-right text-danger">08:17</div>
                  <div class="media-title">Rina Dewi</div>
                  <span class="text-small text-muted">Terlambat</span>
                </div>
              </li>
              <li class="media">
                <img class="rounded-circle mr-3" width="45" src="{{ asset('backend/asset/img/avatar/avatar-3.png') }}" alt="avatar">
                <div class="media-body">
                  <div class="float-right text-warning">Izin</div>
                  <div class="media-title">Budi Rahman</div>
                  <span class="text-small text-muted">Sakit</span>
                </div>
              </li>
            </ul>
            <div class="pt-1 pb-1 text-center">
              <a href="#" class="btn btn-primary btn-round btn-sm">Lihat Semua</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Permintaan Izin / Cuti dan Aksi Cepat --}}
    <div class="row">
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header"><h4>Permintaan Izin / Cuti</h4></div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped mb-0">
                <thead>
                  <tr><th>Nama</th><th>Tanggal</th><th>Alasan</th><th>Status</th></tr>
                </thead>
                <tbody>
                  <tr><td>Rizki Hidayat</td><td>11 Nov 2025</td><td>Sakit</td><td><span class="badge badge-warning">Menunggu</span></td></tr>
                  <tr><td>Sinta Nurhaliza</td><td>10-12 Nov 2025</td><td>Cuti Tahunan</td><td><span class="badge badge-success">Disetujui</span></td></tr>
                  <tr><td>Adi Pratama</td><td>9 Nov 2025</td><td>Urusan keluarga</td><td><span class="badge badge-danger">Ditolak</span></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {{-- Quick Actions --}}
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header"><h4>Aksi Cepat</h4></div>
          <div class="card-body">
            <a href="#" class="btn btn-primary mb-2"><i class="fas fa-user-plus"></i> Tambah Karyawan</a>
            <a href="#" class="btn btn-info mb-2"><i class="fas fa-calendar-plus"></i> Tambah Shift</a>
            <a href="#" class="btn btn-success mb-2"><i class="fas fa-file-export"></i> Export Laporan</a>
            <a href="#" class="btn btn-warning mb-2"><i class="fas fa-map-marker-alt"></i> Lihat Lokasi Absen</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/asset/library/chart.js/dist/Chart.min.js') }}"></script>
<script>
// Grafik Doughnut lebih kecil
const ctx2 = document.getElementById('attendanceDoughnut').getContext('2d');
new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Hadir', 'Terlambat', 'Izin / Cuti'],
    datasets: [{
      data: [98, 7, 3],
      backgroundColor: ['#47c363', '#ffa426', '#fc544b'],
      hoverOffset: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    cutout: '70%',
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          boxWidth: 12,
          font: { size: 11 }
        }
      }
    }
  }
});
</script>
@endpush
