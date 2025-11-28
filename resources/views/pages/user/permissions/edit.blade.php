@extends('layouts.app')

@section('title', 'Edit Permission')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('backend/asset/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Attendance</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('user.permissions.index') }}">Permissions</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Form Edit Attendance</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.permissions.update', $permission->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Tanggal Izin</label>
                            <input type="date" name="date_permission" class="form-control"
                                value="{{ $permission->date_permission }}" required>
                        </div>

                        <div class="form-group">
                            <label>Alasan</label>
                            <textarea name="reason" class="form-control" required>{{ $permission->reason }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Bukti Lama</label><br>
                            @if($permission->image)
                            <img src="{{ asset('image/permission/'.$permission->image) }}" width="100"
                                class="rounded mb-2">
                            @else
                            -
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Ganti Bukti (opsional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('user.permissions.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush