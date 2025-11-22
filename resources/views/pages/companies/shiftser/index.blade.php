@extends('layouts.app')

@section('title', 'Manajement Shifts')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajement Shifts</h1>
            <div class="section-header-button">
                <a href="{{ route('create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Employees</a></div>
                <div class="breadcrumb-item">All Employees</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Shifts</h2>
            <p class="section-lead">
                You can manage all Shifts, such as editing, deleting and more.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Posts</h4>
                        </div>
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('index') }}">
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
                                            <th>Name</th>
                                            <th>Time</th>
                                            <th>Grace</th>
                                            <th>Default</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($shifts as $s)
                                        <tr>
                                            <td>{{ $s->name }}</td>
                                            <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
                                            <td>{{ $s->grace_period_minutes }} min</td>
                                            <td>
                                                @if($s->is_default)
                                                <span class="badge badge-success">Default</span>
                                                @else
                                                -
                                                @endif
                                            </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('edit', $s->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('destroy', $s->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No shift found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $shifts->withQueryString()->links() }}
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