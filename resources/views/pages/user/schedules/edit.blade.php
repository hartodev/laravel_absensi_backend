@extends('layouts.app')

@section('title', 'Edit Schedules')

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
            <h1>Edit Schedules</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Schedules</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Schedules</h2>


            <div class="card">
                <form method="POST" action="{{ route('user.schedules.update', $schedule->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Form Edit Schedule</h4>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" value="{{ $schedule->title }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control">{{ $schedule->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Waktu Mulai</label>
                            <input type="datetime-local" name="start_datetime"
                                value="{{ str_replace(' ', 'T', $schedule->start_datetime) }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Pengingat</label>

                            @php
                            $rem = $schedule->reminder_offsets ? json_decode($schedule->reminder_offsets) : [];
                            @endphp

                            @foreach($rem as $r)
                            <input type="text" name="reminder_offsets[]" value="{{ $r }}" class="form-control mb-2">
                            @endforeach

                            <input type="text" name="reminder_offsets[]" class="form-control mb-2"
                                placeholder="Tambah pengingat">
                        </div>

                        <div class="form-group">
                            <label>Status Jadwal</label>
                            <select name="status" class="form-control" required>
                                <option value="upcoming" {{ $schedule->status=='upcoming'?'selected':'' }}>Upcoming
                                </option>
                                <option value="done" {{ $schedule->status=='done'?'selected':'' }}>Selesai</option>
                                <option value="canceled" {{ $schedule->status=='canceled'?'selected':'' }}>Dibatalkan
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_task_duty" {{ $schedule->is_task_duty ? 'checked':'' }}>
                                Tugas / Duty
                            </label>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush