@extends('layouts.app')

@section('title', 'Add Schedules ')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet"
    href="{{ asset('backend/asset/library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
<link rel="stylesheet"
    href="{{ asset('backend/asset/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Add Schedules</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Schedules</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Add Schedules</h2>



            <div class="card">
                <form method="POST" action="{{ route('user.schedules.store') }}">
                    @csrf

                    <div class="card-header">
                        <h4>Form Create Schedule</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi (opsional)</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Waktu Mulai</label>
                            <input type="datetime-local" name="start_datetime" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Pengingat (menit sebelum)</label>
                            <input type="text" name="reminder_offsets[]" class="form-control mb-2" placeholder="5">
                            <input type="text" name="reminder_offsets[]" class="form-control mb-2" placeholder="15">
                            <input type="text" name="reminder_offsets[]" class="form-control" placeholder="60">
                            <small class="text-muted">Kosongkan jika tidak perlu.</small>
                        </div>

                        <div class="form-group">
                            <label>Lokasi (opsional)</label>
                            <input type="text" class="form-control mb-2" name="location[lat]" placeholder="Latitude">
                            <input type="text" class="form-control" name="location[lng]" placeholder="Longitude">
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_task_duty"> Tugas / Duty
                            </label>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush