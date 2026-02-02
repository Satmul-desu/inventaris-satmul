@extends('layouts.admin')

@section('title', 'Tambah Supplier')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Supplier Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Supplier <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Spacer -->
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" class="form-control" rows="3">{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.suppliers.index') }}" class">
                    <i="btn btn-secondary class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

