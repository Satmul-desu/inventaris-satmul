@extends('layouts.admin')

@section('title', 'Detail Barang Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Barang Masuk</h4>
            <div>
                <a href="{{ route('admin.stock-in.index') }}" class="btn btn-secondary">
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
                        <td>#{{ $stockIn->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>{{ $stockIn->date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Barang</strong></td>
                        <td>{{ $stockIn->item->name }} ({{ $stockIn->item->code }})</td>
                    </tr>
                    <tr>
                        <td><strong>Supplier</strong></td>
                        <td>{{ $stockIn->supplier->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td class="text-success font-weight-bold">{{ $stockIn->qty }} {{ $stockIn->item->unit->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>User</strong></td>
                        <td>{{ $stockIn->user->name }}</td>
                    </tr>
                    @if($stockIn->note)
                    <tr>
                        <td><strong>Catatan</strong></td>
                        <td>{{ $stockIn->note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

