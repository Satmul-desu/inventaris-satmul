@extends('layouts.admin')

@section('title', 'Satuan Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Satuan</h4>
            <a href="{{ route('admin.units.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Satuan
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Satuan</th>
                        <th>Jumlah Barang</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $index => $unit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $unit->name }}</strong></td>
                        <td>{{ $unit->items->count() }} barang</td>
                        <td>
                            <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" {{ $unit->items->count() > 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data satuan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

