@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Peminjaman</h4>
            <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Peminjaman
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row mb-4">
            <div class="col-md-2">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nama Peminjam...">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Hilang</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Dari Tgl">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Sampai Tgl">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.borrowings.index') }}" class="btn btn-secondary btn-block">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal Pinjam</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $index => $borrowing)
                    <tr class="{{ $borrowing->isOverdue() ? 'table-danger' : '' }}">
                        <td>{{ $borrowings->firstItem() + $index }}</td>
                        <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $borrowing->borrower_name }}</strong><br>
                            <small class="text-muted">{{ $borrowing->borrower_phone ?? '-' }}</small>
                        </td>
                        <td>{{ $borrowing->item->name }}</td>
                        <td>{{ $borrowing->qty }} {{ $borrowing->item->unit->name }}</td>
                        <td>
                            {{ $borrowing->return_date->format('d/m/Y') }}
                            @if($borrowing->isOverdue())
                            <span class="badge badge-danger">Terlambat {{ $borrowing->overdue_days }} hari</span>
                            @endif
                        </td>
                        <td>{!! $borrowing->getStatusBadgeAttribute() !!}</td>
                        <td>
                            <a href="{{ route('admin.borrowings.show', $borrowing->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if($borrowing->status === 'borrowed')
                            <button type="button" class="btn btn-sm btn-success" title="Pengembalian" onclick="showReturnModal({{ $borrowing->id }})">
                                <i class="fa fa-undo"></i>
                            </button>
                            @endif
                            @if(in_array($borrowing->status, ['pending', 'borrowed']))
                            <a href="{{ route('admin.borrowings.edit', $borrowing->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif
                            <form action="{{ route('admin.borrowings.destroy', $borrowing->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus? Stok akan dikembalikan jika sedang dipinjam.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $borrowings->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="returnForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menerima pengembalian barang ini?</p>
                    
                    <div class="form-group">
                        <label for="condition">Kondisi Barang</label>
                        <select name="condition" id="condition" class="form-control" required>
                            <option value="good">Baik</option>
                            <option value="damaged">Rusak</option>
                            <option value="lost">Hilang</option>
                        </select>
                        <small class="text-muted">Pilih "Hilang" jika barang tidak dikembalikan</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="return_note">Catatan Pengembalian</label>
                        <textarea name="return_note" id="return_note" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Konfirmasi Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showReturnModal(borrowingId) {
    $('#returnForm').attr('action', '/admin/borrowings/' + borrowingId + '/return');
    $('#returnModal').modal('show');
}
</script>
@endpush

