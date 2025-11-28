@extends('layouts.app')

@section('title', 'Permissions')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Permissions</h1>
            <div class="section-header-button">
                <a href="{{ route('user.permissions.create') }}" class="btn btn-primary">Add New</a>
            </div>
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
                You can manage all Permissions, such as editing, deleting and more.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Permissions</h4>
                        </div>
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('user.permissions.index') }}">
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
                                            <th>Alasan</th>
                                            <th>Bukti</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $p)
                                        <tr>
                                            <td>{{ $p->date_permission }}</td>
                                            <td>{{ $p->reason }}</td>
                                            <td>
                                                @if($p->image)
                                                <a href="{{ asset('image/permission/'.$p->image) }}" target="_blank">
                                                    <img src="{{ asset('image/permission/'.$p->image) }}"
                                                        style="width:50px;height:50px;object-fit:cover" class="rounded">
                                                </a>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $p->is_approved ? 'success' : 'warning' }}">
                                                    {{ $p->is_approved ? 'Disetujui' : 'Menunggu' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if(!$p->is_approved)
                                                <a href="{{ route('user.permissions.edit', $p->id) }}"
                                                    class="btn btn-sm btn-info">Edit</a>

                                                <form action="{{ route('user.permissions.destroy', $p->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin hapus?')">Hapus</button>
                                                </form>
                                                @else
                                                <span class="text-muted">No Action</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $permissions->withQueryString()->links() }}
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