@extends('layouts.app')

@section('title', 'Edit Shift')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/asset/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Shift</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Shifts</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Edit Shift</h2>

            <div class="card">
                <form method="POST" action="{{ route('company.shifts.update', $shift->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Form Edit Shift</h4>
                    </div>

                    <div class="card-body">

                        {{-- SHIFT NAME --}}
                        <div class="form-group">
                            <label>Shift Name</label>
                            <input type="text" name="name" 
                                   class="form-control" 
                                   value="{{ old('name', $shift->name) }}" 
                                   required>
                        </div>

                        {{-- START TIME --}}
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" name="start_time" 
                                   class="form-control" 
                                   value="{{ old('start_time', $shift->start_time) }}" 
                                   required>
                        </div>

                        {{-- END TIME --}}
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" name="end_time" 
                                   class="form-control" 
                                   value="{{ old('end_time', $shift->end_time) }}" 
                                   required>
                        </div>

                        {{-- GRACE PERIOD --}}
                        <div class="form-group">
                            <label>Grace Period (minutes)</label>
                            <input type="number" 
                                   name="grace_period_minutes" 
                                   class="form-control" 
                                   value="{{ old('grace_period_minutes', $shift->grace_period_minutes) }}">
                        </div>

                        {{-- DEFAULT SHIFT --}}
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_default"
                                       {{ $shift->is_default ? 'checked' : '' }}>
                                Set as default shift
                            </label>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('company.shifts.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
