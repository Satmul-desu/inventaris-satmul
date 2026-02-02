@extends('layouts.admin')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Barang Masuk</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.stock-in.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_id">Barang <span class="text-danger">*</span></label>
                        <select name="item_id" id="item_id" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->code }}) - Stok: {{ $item->stock }}
                            </option>
                            @endforeach
                        </select>
                        @error('item_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="supplier_id">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="qty">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="qty" id="qty" class="form-control" value="{{ old('qty', 1) }}" required min="1">
                        @error('qty')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="note">Catatan</label>
                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note') }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.stock-in.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@if(request('item_id'))
@php $item = \App\Models\Item::find(request('item_id')) @endphp
@if($item)
<div class="card mt-3">
    <div class="card-header">Info Barang</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Kode:</strong> {{ $item->code }}
            </div>
            <div class="col-md-3">
                <strong>Nama:</strong> {{ $item->name }}
            </div>
            <div class="col-md-3">
                <strong>Stok Saat Ini:</strong> {{ $item->stock }} {{ $item->unit->name }}
            </div>
            <div class="col-md-3">
                <strong>Min. Stok:</strong> {{ $item->min_stock }}
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection

