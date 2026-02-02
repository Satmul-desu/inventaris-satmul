@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Edit Supplier: {{ $supplier->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Nama Supplier <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Spacer -->
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

