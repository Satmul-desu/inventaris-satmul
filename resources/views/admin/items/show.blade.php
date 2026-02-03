@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Barang</h4>
            <div>
                <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">
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
                        <td width="150"><strong>Kode Barang</strong></td>
                        <td>{{ $item->code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>{{ $item->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td>{{ $item->category->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Satuan</strong></td>
                        <td>{{ $item->unit->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Stok</strong></td>
                        <td>
                            {{ $item->stock }} {{ $item->unit->name }}
                            {!! $item->getStatusBadgeAttribute() !!}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Min. Stok</strong></td>
                        <td>{{ $item->min_stock }} {{ $item->unit->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga Satuan</strong></td>
                        <td>{{ $item->formatted_price }}</td>
                    </tr>
                    @if($item->description)
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>{{ $item->description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>Aksi Cepat</h5>
                        <div class="btn-group-vertical w-100">
                            <a href="{{ route('admin.stock-in.create') }}?item_id={{ $item->id }}" class="btn btn-success">
                                <i class="fa fa-plus-circle"></i> Tambah Stok
                            </a>
                            <a href="{{ route('admin.stock-out.create') }}?item_id={{ $item->id }}" class="btn btn-danger">
                                <i class="fa fa-minus-circle"></i> Kurangi Stok
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h5>Riwayat Stok</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                        <th>Jumlah</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>User</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($item->stockLogs()->with('user')->latest()->paginate(10) as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td>{!! $log->getActionBadgeAttribute() !!}</td>
                        <td class="{{ $log->qty > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $log->qty > 0 ? '+' : '' }}{{ $log->qty }}
                        </td>
                        <td>{{ $log->previous_stock }}</td>
                        <td>{{ $log->current_stock }}</td>
                        <td>{{ $log->user->name ?? '-' }}</td>
                        <td>{{ $log->description ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada riwayat stok</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $item->stockLogs()->with('user')->latest()->paginate(10)->links() }}
        </div>
    </div>
</div>
@endsection

