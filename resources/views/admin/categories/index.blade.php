@extends('layouts.admin')

@section('title', 'Kategori Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Kategori</h4>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Barang</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td>{{ $category->items->count() }} barang</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" {{ $category->items->count() > 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

