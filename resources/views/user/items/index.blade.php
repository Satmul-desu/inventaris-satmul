@extends('layouts.user')

@section('title', 'Daftar Barang')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h4 class="mb-0">Daftar Barang</h4>
    </div>
    <div class="card-body">
        <form method="GET" class="row mb-4">
            <div class="col-md-9">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/kode barang..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td><strong>{{ $item->code }}</strong></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->unit->name }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{!! $item->getStatusBadgeAttribute() !!}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada barang</td>
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

