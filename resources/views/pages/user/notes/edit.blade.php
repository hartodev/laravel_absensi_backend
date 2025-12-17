@extends('layouts.app')

@section('title', 'Edit Note')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Note</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('user.notes.index') }}">Notes</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('user.notes.update', $note->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Form Edit Note</h4>
                    </div>

                    <div class="card-body">
                        {{-- TITLE --}}
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $note->title) }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NOTE --}}
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note"
                                      class="form-control @error('note') is-invalid @enderror"
                                      rows="5"
                                      required>{{ old('note', $note->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('user.notes.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@endsection
