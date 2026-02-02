@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Kategori Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

