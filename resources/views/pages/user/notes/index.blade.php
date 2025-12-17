@extends('layouts.app')

@section('title', 'Notes')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/asset/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Notes</h1>
            <div class="section-header-button">
                <a href="{{ route('user.notes.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Notes</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <h2 class="section-title">My Notes</h2>
            <p class="section-lead">
                Manage your personal notes.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h4>All Notes</h4>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Judul</th>
                                            <th>Catatan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($notes as $n)
                                        <tr>
                                            <td>{{ $n->created_at->format('d M Y') }}</td>
                                            <td>{{ $n->title }}</td>
                                            <td>{{ Str::limit($n->note, 50) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.notes.edit', $n->id) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <form action="{{ route('user.notes.destroy', $n->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Hapus catatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Belum ada catatan
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="float-right">
                                {{ $notes->withQueryString()->links() }}
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
<script src="{{ asset('backend/asset/library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
