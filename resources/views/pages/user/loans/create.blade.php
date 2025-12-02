@extends('layouts.app')

@section('title', 'Add Form Loans ')

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
            <h1>Add Form Loans</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Loans</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Add Loans</h2>


             <div class="card">
                <form action="{{ route('user.loans.store') }}" method="POST">
                    @csrf

                    <div class="card-header">
                        <h4>Form Add Loan</h4>
                    </div>

                    <div class="card-body">

                      <div class="form-group">
                        <label>Jumlah Kasbon</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Cicilan (bulan)</label>
                        <input type="number" name="installments" class="form-control" required>
                    </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                        <a href="{{ route('user.loans.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush