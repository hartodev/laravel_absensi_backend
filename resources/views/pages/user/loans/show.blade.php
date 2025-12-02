@extends('layouts.app')

@section('title', 'Detail Kasbon')

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Detail Kasbon</h1>
        </div>

        <div class="card">
            <div class="card-body">

                <h4>Informasi Kasbon</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Total Kasbon</th>
                        <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Sisa Pembayaran</th>
                        <td>Rp {{ number_format($loan->balance, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Cicilan</th>
                        <td>{{ $loan->installments }}x</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge 
                                @if($loan->status=='approved') badge-success
                                @elseif($loan->status=='pending') badge-warning
                                @elseif($loan->status=='rejected') badge-danger
                                @else badge-info @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                    </tr>

                </table>

                <div class="text-right">
                    <a href="{{ route('user.loans.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </div>
        </div>

    </section>
</div>
@endsection