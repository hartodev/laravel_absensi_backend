@extends('layouts.app')

@section('title', 'Add Employees ')

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
            <h1>Add Employees</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Employees</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Add Employees</h2>



            <div class="card">
                <form method="POST" action="{{ route('employees.store') }}">
                    @csrf

                    <div class="card-header">
                        <h4>Form Create Employee</h4>
                    </div>

                    <div class="card">
                        <form method="POST" action="{{ route('employees.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Position</label>
                                    <input type="text" name="position" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Department</label>
                                    <input type="text" name="department" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save</button>
                                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush