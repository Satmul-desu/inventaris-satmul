@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Barang Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.items.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code">Kode Barang <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $suggestedCode ?? '') }}" placeholder="BRG-001">
                            <div class="input-group-append">
                                <span class="input-group-text bg-info text-white" title="Kode barang akan di-generate otomatis">
                                    <i class="fa fa-magic"></i> Auto
                                </span>
                            </div>
                        </div>
                        <small class="text-muted">Kode akan di-generate otomatis. Anda dapat mengubahnya jika diperlukan.</small>
                        @error('code')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="unit_id">Satuan <span class="text-danger">*</span></label>
                        <select name="unit_id" id="unit_id" class="form-control" required>
                            <option value="">Pilih Satuan</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="stock">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', 0) }}" required min="0">
                        @error('stock')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="min_stock">Minimal Stok <span class="text-danger">*</span></label>
                        <input type="number" name="min_stock" id="min_stock" class="form-control" value="{{ old('min_stock', 0) }}" required min="0">
                        @error('min_stock')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Harga Satuan (Rp)</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', 0) }}" min="0" step="0.01">
                        @error('price')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

