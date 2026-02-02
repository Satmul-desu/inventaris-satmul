@extends('layouts.admin')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Barang Keluar</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.stock-out.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_id">Barang <span class="text-danger">*</span></label>
                        <select name="item_id" id="item_id" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->code }}) - Stok: {{ $item->stock }} {{ $item->unit->name }}
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
                        <label for="location_id">Lokasi Tujuan</label>
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
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

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="recipient">Penerima</label>
                        <input type="text" name="recipient" id="recipient" class="form-control" value="{{ old('recipient') }}" placeholder="Nama Penerima">
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Spacer -->
                </div>
            </div>

            <div class="form-group">
                <label for="note">Catatan</label>
                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note') }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.stock-out.index') }}" class="btn btn-secondary">
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
                <strong>Status:</strong> {!! $item->getStatusBadgeAttribute() !!}
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection

