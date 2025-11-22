@extends('layouts.app')

@section('title', 'Manajement Permissions')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajement Permissions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Permissions</a></div>
                <div class="breadcrumb-item">All Permissions</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Permissions</h2>
            <p class="section-lead">
                You can manage all Permissions, such as approving, rejecting and more.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Permission Requests</h4>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive table-striped">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Date</th>
                                            <th>Reason</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th width="160px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permissions as $p)
                                        <tr>
                                            <td>{{ $p->user->name }}</td>
                                            <td>{{ $p->date_permission }}</td>
                                            <td>{{ $p->reason }}</td>
                                            <td>
                                                @if($p->image)
                                                <a href="{{ asset('image/permission/' . $p->image) }}" target="_blank">
                                                    <img src="{{ asset('image/permission/' . $p->image) }}"
                                                        style="width:50px;height:50px;object-fit:cover;"
                                                        class="rounded">
                                                </a>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if($p->is_approved)
                                                <span class="badge badge-success">Approved</span>
                                                @else
                                                <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>

                                                @if(!$p->is_approved)
                                                <form class="d-inline" method="POST"
                                                    action="{{ route('company.permissions.approve', $p->id) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                                @endif

                                                <form class="d-inline" method="POST"
                                                    action="{{ route('company.permissions.reject', $p->id) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger">Reject</button>
                                                </form>

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No permission requests</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-3 float-right">
                                {{ $permissions->links() }}
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