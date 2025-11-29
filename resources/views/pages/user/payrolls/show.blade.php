@extends('layouts.app')

@section('title', 'Detail Slip Gaji')

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Detail Slip Gaji</h1>
        </div>

        <div class="card">
            <div class="card-body">

                <h4>Periode</h4>
                <p>{{ $payroll->period_start }} s/d {{ $payroll->period_end }}</p>

                <hr>

                <h4>Rincian Gaji</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tunjangan</th>
                        <td>Rp {{ number_format($payroll->allowance, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Lembur</th>
                        <td>Rp {{ number_format($payroll->overtime_pay, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Bonus</th>
                        <td>Rp {{ number_format($payroll->bonus, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Potongan</th>
                        <td>Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                    </tr>

                    <tr class="table-success">
                        <th>Gaji Bersih</th>
                        <td><strong>Rp {{ number_format($payroll->net_pay, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>

                <hr>

                <h4>Status Slip Gaji</h4>
                <p>
                    <span class="badge 
                        @if($payroll->status=='paid') badge-success
                        @elseif($payroll->status=='approved') badge-info
                        @else badge-warning @endif">
                        {{ ucfirst($payroll->status) }}
                    </span>
                </p>

                <div class="text-right">
                    <a href="{{ route('user.payrolls.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </div>
        </div>

    </section>
</div>
@endsection