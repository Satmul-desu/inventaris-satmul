@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Peminjaman</h4>
            <div>
                @if($borrowing->status === 'borrowed')
                <button type="button" class="btn btn-success" onclick="showReturnModal()">
                    <i class="fa fa-undo"></i> Proses Pengembalian
                </button>
                @endif
                <a href="{{ route('admin.borrowings.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%"><strong>Kode Peminjaman</strong></td>
                                <td>: #{{ str_pad($borrowing->id, 6, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: {!! $borrowing->getStatusBadgeAttribute() !!}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Pinjam</strong></td>
                                <td>: {{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Batas Kembali</strong></td>
                                <td>: {{ $borrowing->return_date->format('d/m/Y') }}
                                    @if($borrowing->isOverdue())
                                    <span class="badge badge-danger">Terlambat {{ $borrowing->overdue_days }} hari</span>
                                    @endif
                                </td>
                            </tr>
                            @if($borrowing->actual_return_date)
                            <tr>
                                <td><strong>Tanggal Kembali</strong></td>
                                <td>: {{ $borrowing->actual_return_date->format('d/m/Y') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Petugas</strong></td>
                                <td>: {{ $borrowing->user->name }}</td>
                            </tr>
                            @if($borrowing->note)
                            <tr>
                                <td><strong>Catatan</strong></td>
                                <td>: {{ $borrowing->note }}</td>
                            </tr>
                            @endif
                            @if($borrowing->return_note)
                            <tr>
                                <td><strong>Catatan Pengembalian</strong></td>
                                <td>: {{ $borrowing->return_note }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Informasi Peminjam</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%"><strong>Nama Peminjam</strong></td>
                                <td>: {{ $borrowing->borrower_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>No HP</strong></td>
                                <td>: {{ $borrowing->borrower_phone ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Barang Dipinjam</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Status Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $borrowing->item->code }}</td>
                                    <td>{{ $borrowing->item->name }}</td>
                                    <td>{{ $borrowing->qty }}</td>
                                    <td>{{ $borrowing->item->unit->name }}</td>
                                    <td>{!! $borrowing->item->getStatusBadgeAttribute() !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
function showReturnModal() {
    $('#returnModal').modal('show');
}
</script>
@endpush

