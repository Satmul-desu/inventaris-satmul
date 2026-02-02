@extends('layouts.admin')

@section('title', 'Detail Barang Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Barang Keluar</h4>
            <div>
                <a href="{{ route('admin.stock-out.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Kode Transaksi</strong></td>
                        <td>#{{ $stockOut->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>{{ $stockOut->date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Barang</strong></td>
                        <td>{{ $stockOut->item->name }} ({{ $stockOut->item->code }})</td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi</strong></td>
                        <td>{{ $stockOut->location->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td class="text-danger font-weight-bold">{{ $stockOut->qty }} {{ $stockOut->item->unit->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Penerima</strong></td>
                        <td>{{ $stockOut->recipient ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>User</strong></td>
                        <td>{{ $stockOut->user->name }}</td>
                    </tr>
                    @if($stockOut->note)
                    <tr>
                        <td><strong>Catatan</strong></td>
                        <td>{{ $stockOut->note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

