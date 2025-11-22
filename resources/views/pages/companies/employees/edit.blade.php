@extends('layouts.app')

@section('title', 'Edit Employees')

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
            <h1>Edit Employees</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Employees</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Employees</h2>

         <div class="card">
        <form method="POST" action="{{ route('employees.update', $employee->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $employee->name }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $employee->email }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $employee->phone }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Position</label>
                    <input type="text" name="position" value="{{ $employee->position }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" value="{{ $employee->department }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Password (Opsional)</label>
                    <input type="password" name="password" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>

            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush