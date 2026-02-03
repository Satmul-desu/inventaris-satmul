@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Peminjaman</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.borrowings.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_id">Barang <span class="text-danger">*</span></label>
                        <select name="item_id" id="item_id" class="form-control" required onchange="updateItemInfo()">
                            <option value="">Pilih Barang</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                data-stock="{{ $item->stock }}" 
                                data-unit="{{ $item->unit->name }}"
                                {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->code }}) - Stok: {{ $item->stock }} {{ $item->unit->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('item_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="qty">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="qty" id="qty" class="form-control" value="{{ old('qty', 1) }}" required min="1" onchange="checkStock()">
                        <small class="text-muted" id="stock-info"></small>
                        @error('qty')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="borrower_name">Nama Peminjam <span class="text-danger">*</span></label>
                        <input type="text" name="borrower_name" id="borrower_name" class="form-control" value="{{ old('borrower_name') }}" required placeholder="Nama lengkap peminjam">
                        @error('borrower_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="borrower_phone">No HP Peminjam</label>
                        <input type="text" name="borrower_phone" id="borrower_phone" class="form-control" value="{{ old('borrower_phone') }}" placeholder="Nomor telepon">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="borrow_date">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" name="borrow_date" id="borrow_date" class="form-control" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                        @error('borrow_date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="return_date">Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" name="return_date" id="return_date" class="form-control" value="{{ old('return_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                        <small class="text-muted">Batas waktu pengembalian</small>
                        @error('return_date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="note">Catatan</label>
                <textarea name="note" id="note" class="form-control" rows="3" placeholder="Catatan tambahan untuk peminjaman ini...">{{ old('note') }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.borrowings.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateItemInfo() {
    const select = document.getElementById('item_id');
    const stockInfo = document.getElementById('stock-info');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        const stock = selectedOption.dataset.stock;
        const unit = selectedOption.dataset.unit;
        stockInfo.textContent = `Stok tersedia: ${stock} ${unit}`;
    } else {
        stockInfo.textContent = '';
    }
    checkStock();
}

function checkStock() {
    const select = document.getElementById('item_id');
    const qtyInput = document.getElementById('qty');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value && qtyInput.value) {
        const stock = parseInt(selectedOption.dataset.stock);
        const qty = parseInt(qtyInput.value);
        
        if (qty > stock) {
            qtyInput.setCustomValidity(`Stok tidak mencukupi. Maksimal: ${stock}`);
        } else {
            qtyInput.setCustomValidity('');
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateItemInfo();
});
</script>
@endpush

