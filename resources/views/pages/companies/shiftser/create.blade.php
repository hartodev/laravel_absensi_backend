@extends('layouts.app')

@section('title', 'Add Shifts')

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
            <h1>Add Shifts</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>0 
                <div class="breadcrumb-item">Shifts</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Add Shifts</h2>



            <div class="card">
                <form method="POST" action="{{ route('company.shifts.store') }}">
                    @csrf

                    <div class="card-header">
                        <h4>Form Create Shift</h4>
                    </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Shift Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Grace Period (minutes)</label>
                                    <input type="number" name="grace_period_minutes" class="form-control" value="15">
                                </div>

                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_default"> Set as default shift
                                    </label>
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save</button>
                                <a href="{{ route('company.shifts.index') }}" class="btn btn-secondary">Back</a>
                            </div>

                </form>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush