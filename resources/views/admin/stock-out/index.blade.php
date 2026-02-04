@extends('layouts.admin')

@section('title', 'Barang Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Barang Keluar</h4>
            @if(auth()->user()->isOwner())
            <a href="{{ route('admin.stock-out.create') }}" class="btn btn-danger">
                <i class="fa fa-minus"></i> Tambah Barang Keluar
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Sampai Tanggal">
            </div>
            <div class="col-md-3">
                <select name="item_id" class="form-control">
                    <option value="">Semua Barang</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Lokasi</th>
                        <th>Jumlah</th>
                        <th>Penerima</th>
                        <th>User</th>
                        <th width="{{ auth()->user()->isOwner() ? '100' : '60' }}">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockOuts as $index => $stockOut)
                    <tr>
                        <td>{{ $stockOuts->firstItem() + $index }}</td>
                        <td>{{ $stockOut->date->format('d/m/Y') }}</td>
                        <td>{{ $stockOut->item->name }}</td>
                        <td>{{ $stockOut->location->name ?? '-' }}</td>
                        <td class="text-danger font-weight-bold">-{{ $stockOut->qty }}</td>
                        <td>{{ $stockOut->recipient ?? '-' }}</td>
                        <td>{{ $stockOut->user->name }}</td>
                        <td>
                            <a href="{{ route('admin.stock-out.show', $stockOut->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if(auth()->user()->isOwner())
                            <form action="{{ route('admin.stock-out.destroy', $stockOut->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus? Stok akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data barang keluar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $stockOuts->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

