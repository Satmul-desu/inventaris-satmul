@extends('layouts.admin')

@section('title', 'Lokasi Penyimpanan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Lokasi</h4>
            @if(auth()->user()->isOwner())
            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Lokasi
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
                        <th>Nama Lokasi</th>
                        <th>Deskripsi</th>
                        <th width="{{ auth()->user()->isOwner() ? '120' : '60' }}">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $index => $location)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $location->name }}</strong></td>
                        <td>{{ $location->description ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.locations.show', $location->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if(auth()->user()->isOwner())
                            <a href="{{ route('admin.locations.edit', $location->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
                        <td colspan="4" class="text-center">Tidak ada data lokasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

