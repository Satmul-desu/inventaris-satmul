@extends('layouts.admin')

@section('title', 'Supplier')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Supplier</h4>
            @if(auth()->user()->isOwner())
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Supplier
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th width="{{ auth()->user()->isOwner() ? '120' : '60' }}">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $index => $supplier)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $supplier->name }}</strong></td>
                        <td>{{ $supplier->phone ?? '-' }}</td>
                        <td>{{ Str::limit($supplier->address, 50) ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.suppliers.show', $supplier->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if(auth()->user()->isOwner())
                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
                        <td colspan="5" class="text-center">Tidak ada data supplier</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

