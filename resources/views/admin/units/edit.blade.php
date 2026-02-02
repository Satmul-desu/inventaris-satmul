@extends('layouts.admin')

@section('title', 'Edit Satuan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Edit Satuan: {{ $unit->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Nama Satuan <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $unit->name) }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

