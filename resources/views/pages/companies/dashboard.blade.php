@extends('layouts.app')

@section('title', 'Company Dashboard')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/asset/library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Company Dashboard</h1>
    </div>

    {{-- STATISTIK UTAMA --}}
    <div class="row">

      <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Total Employees</h4></div>
            <div class="card-body">{{ $totalEmployees }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-user-check"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Present Today</h4></div>
            <div class="card-body">{{ $todayPresent }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-clock"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Late</h4></div>
            <div class="card-body">{{ $todayLate }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-user-times"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header"><h4>Permission</h4></div>
            <div class="card-body">{{ $todayPermission }}</div>
          </div>
        </div>
      </div>

    </div>

    {{-- CHART --}}
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header"><h4>Attendance Statistics</h4></div>

          <div class="card-body text-center p-3">
            <canvas id="attendanceCompanyChart"></canvas>
          </div>
        </div>
      </div>

      {{-- TODAY ATTENDANCES --}}
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header"><h4>Today's Attendance</h4></div>

          <div class="card-body p-3">
            <ul class="list-unstyled list-unstyled-border">
              @forelse($todayAttendanceList as $a)
              <li class="media">
                <img class="rounded-circle mr-3" width="45"
                  src="{{ $a->user->image_url ?? asset('backend/asset/img/avatar/avatar-1.png') }}">
                <div class="media-body">
                  <div class="float-right text-{{ $a->status == 'late' ? 'danger' : 'success' }}">
                    {{ $a->time_in ?? '-' }}
                  </div>
                  <div class="media-title">{{ $a->user->name }}</div>
                  <span class="text-small text-muted">{{ ucfirst($a->status) }}</span>
                </div>
              </li>
              @empty
              <p class="text-center">No data today</p>
              @endforelse
            </ul>
          </div>

        </div>
      </div>
    </div>

    {{-- PERMISSION LIST --}}
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header"><h4>Permission Requests</h4></div>

          <div class="card-body p-0">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Reason</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tbody>
                @foreach($permissionList as $p)
                <tr>
                  <td>{{ $p->user->name }}</td>
                  <td>{{ $p->date_permission }}</td>
                  <td>{{ $p->reason }}</td>
                  <td>
                    <span class="badge badge-{{ $p->is_approved ? 'success' : 'warning' }}">
                      {{ $p->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>

            </table>
          </div>
        </div>
      </div>

      {{-- QUICK ACTIONS --}}
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header"><h4>Quick Actions</h4></div>
          <div class="card-body">
            <a href="{{ route('employees.index') }}" class="btn btn-primary mb-2">
              <i class="fas fa-user-plus"></i> Manage Employees
            </a>

            <a href="{{ route('company.shifts.index') }}" class="btn btn-info mb-2">
              <i class="fas fa-calendar"></i> Manage Shift
            </a>

            <a href="{{ route('company.attendances.index') }}" class="btn btn-warning mb-2">
              <i class="fas fa-clock"></i> Attendance List
            </a>

            <a href="{{ route('company.payrolls.index') }}" class="btn btn-success mb-2">
              <i class="fas fa-file-invoice"></i> Payroll
            </a>
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
new Chart(document.getElementById('attendanceCompanyChart'), {
  type: 'doughnut',
  data: {
    labels: ['Present', 'Late', 'Permission'],
    datasets: [{
      data: [{{ $todayPresent }}, {{ $todayLate }}, {{ $todayPermission }}],
      backgroundColor: ['#47c363', '#ffa426', '#fc544b']
    }]
  },
  options: {
    cutout: '70%',
    plugins: { legend: { position: 'bottom' } }
  }
});
</script>
@endpush
