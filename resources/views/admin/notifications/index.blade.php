@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Notifikasi</h4>
            <div>
                <a href="{{ route('admin.notifications.mark-all-read') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-check"></i> Tandai Semua Dibaca
                </a>
                <a href="{{ route('admin.notifications.clear-all') }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus semua notifikasi?')">
                    <i class="fa fa-trash"></i> Hapus Semua
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Status</th>
                        <th>Barang</th>
                        <th>Pesan</th>
                        <th>Waktu</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                    <tr class="{{ $notification->is_read ? '' : 'bg-light' }}">
                        <td>
                            @if($notification->is_read)
                            <span class="badge badge-secondary">Dibaca</span>
                            @else
                            <span class="badge badge-warning">Baru</span>
                            @endif
                        </td>
                        <td>{{ $notification->item->name ?? '-' }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if(!$notification->is_read)
                            <a href="{{ route('admin.notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-success" title="Tandai Dibaca">
                                <i class="fa fa-check"></i>
                            </a>
                            @endif
                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Hapus notifikasi ini?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada notifikasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection

