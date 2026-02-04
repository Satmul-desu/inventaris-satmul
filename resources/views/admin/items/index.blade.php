@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Barang</h4>
            @if(auth()->user()->isOwner())
            <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Barang
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/kode..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="stock_status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Menipis</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Habis</option>
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
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Min. Stok</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th width="{{ auth()->user()->isOwner() ? '120' : '60' }}">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                    <tr>
                        <td>{{ $items->firstItem() + $index }}</td>
                        <td><strong>{{ $item->code }}</strong></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->unit->name }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->min_stock }}</td>
                        <td>{{ $item->formatted_price }}</td>
                        <td>{!! $item->getStatusBadgeAttribute() !!}</td>
                        <td>
                            <a href="{{ route('admin.items.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if(auth()->user()->isOwner())
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
                        <td colspan="9" class="text-center">Tidak ada data barang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $items->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

