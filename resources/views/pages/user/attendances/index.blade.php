@extends('layouts.app')

@section('title', 'Attendances')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Attendances</h1>
            <!-- <div class="section-header-button">
                    <a href="{{ route('attendances.create') }}" class="btn btn-primary">Add New</a>
                </div> -->
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Attendances</a></div>
                <div class="breadcrumb-item">All Attendances</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Attendances</h2>
            <p class="section-lead">
                You can manage all Attendances, such as editing, deleting and more.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Posts</h4>
                        </div>
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('user.attendances.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Status</th>
                                            <th>Overtime</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($attendances as $a)
                                        <tr>
                                            <td>{{ $a->date }}</td>

                                            <td>
                                                {{ $a->time_in ?? '-' }} <br>
                                                <small class="text-muted">{{ $a->latlon_in }}</small>
                                            </td>

                                            <td>
                                                {{ $a->time_out ?? '-' }} <br>
                                                <small class="text-muted">{{ $a->latlon_out }}</small>
                                            </td>

                                            <td>
                                                <span class="badge 
                                            @if($a->status=='late') badge-warning
                                            @elseif($a->status=='absent') badge-danger
                                            @elseif($a->status=='permission') badge-info
                                            @else badge-success
                                            @endif
                                        ">
                                                    {{ ucfirst($a->status) }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $a->overtime_minutes }} menit <br>
                                                @if($a->approved_overtime)
                                                <span class="badge badge-success">Approved</span>
                                                @else
                                                <span class="badge badge-secondary">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $attendances->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('backend/asset/library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('backend/asset/js/page/features-posts.js') }}"></script>
@endpush