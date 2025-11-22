@extends('layouts.app')

@section('title', 'Detail Attendances')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Attendances</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Attendances</a></div>
                <div class="breadcrumb-item">All Attendances</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Detail Attendance</h2>
            <p class="section-lead">
                You can view the details of this attendance record.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    
              <div class="card">
            <div class="card-body">

                <h5>{{ $attendance->user->name }}</h5>
                <p>Tanggal: {{ $attendance->date }}</p>

                <table class="table table-bordered">
                    <tr>
                        <th>Time In</th>
                        <td>{{ $attendance->time_in ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Time Out</th>
                        <td>{{ $attendance->time_out ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $attendance->status }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Masuk</th>
                        <td>{{ $attendance->latlon_in ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Keluar</th>
                        <td>{{ $attendance->latlon_out ?? '-' }}</td>
                    </tr>
                </table>

                <a href="{{ route('company.attendances.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>
        </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('backend/asset/library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('backend/asset/js/page/features-posts.js') }}"></script>
@endpush