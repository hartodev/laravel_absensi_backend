@extends('layouts.app')

@section('title', 'Add Payrolls ')

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
            <h1>Add Payrolls</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Payrolls</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Add Payrolls</h2>


            <div class="card">
                <div class="card-body">
                    <form action="{{ route('company.payrolls.store') }}" method="POST">
                        @csrf

                             <div class="form-group">
                            <label>Employee</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Select Employee --</option>
                                @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Period Start</label>
                            <input type="date" name="period_start" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Period End</label>
                            <input type="date" name="period_end" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Base Salary</label>
                            <input type="number" name="base_salary" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Allowance</label>
                            <input type="number" name="allowance" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Deductions</label>
                            <input type="number" name="deductions" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Overtime Pay</label>
                            <input type="number" name="overtime_pay" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Bonus</label>
                            <input type="number" name="bonus" class="form-control" min="0" required>
                        </div>

                            <div class="card-footer text-right">
                        <button class="btn btn-primary">Save</button>
                        <a href="{{ route('company.payrolls.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush