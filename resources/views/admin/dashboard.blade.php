@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-3 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $totalItems }} <span class="float-right"><i class="fa fa-box"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:100%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Total Barang <span class="float-right"><i class="zmdi zmdi-long-arrow-up"></i></span></p>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $totalStock }} <span class="float-right"><i class="fa fa-cubes"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:100%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Total Stok <span class="float-right"><i class="zmdi zmdi-long-arrow-up"></i></span></p>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $lowStockItems }} <span class="float-right"><i class="fa fa-exclamation-triangle text-warning"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar bg-warning" style="width:{{ $totalItems > 0 ? ($lowStockItems/$totalItems)*100 : 0 }}%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Stok Menipis <span class="float-right"><i class="zmdi zmdi-long-arrow-down text-warning"></i></span></p>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $outOfStockItems }} <span class="float-right"><i class="fa fa-times-circle text-danger"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar bg-danger" style="width:{{ $totalItems > 0 ? ($outOfStockItems/$totalItems)*100 : 0 }}%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Stok Habis <span class="float-right"><i class="zmdi zmdi-long-arrow-down text-danger"></i></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ringkasan Data Master --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-database"></i> Ringkasan Data Master
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-lg-2">
                        <div class="card bg-success text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $totalItems }}</h3>
                                <p class="mb-0 small">Barang</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card bg-info text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $totalCategories }}</h3>
                                <p class="mb-0 small">Kategori</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card bg-warning text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $totalUnits }}</h3>
                                <p class="mb-0 small">Satuan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card bg-secondary text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $totalLocations }}</h3>
                                <p class="mb-0 small">Lokasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card bg-danger text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $totalSuppliers }}</h3>
                                <p class="mb-0 small">Supplier</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card bg-dark text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $notifications->count() }}</h3>
                                <p class="mb-0 small">Notifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ringkasan Peminjaman --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fa fa-book"></i> Ringkasan Peminjaman
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $totalBorrowings }}</h3>
                                <p class="mb-0 small">Total Peminjaman</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card bg-warning text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $activeBorrowings }}</h3>
                                <p class="mb-0 small">Sedang Dipinjam</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card bg-danger text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $overdueBorrowings }}</h3>
                                <p class="mb-0 small">Terlambat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card bg-success text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-0">{{ $returnedBorrowings }}</h3>
                                <p class="mb-0 small">Dikembalikan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">Detail Ringkasan
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Supplier
                        <span class="badge badge-primary badge-pill">{{ $totalSuppliers }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Kategori
                        <span class="badge badge-info badge-pill">{{ $totalCategories }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Satuan
                        <span class="badge badge-success badge-pill">{{ $totalUnits }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Lokasi
                        <span class="badge badge-secondary badge-pill">{{ $totalLocations }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Notifikasi Belum Dibaca
                        <span class="badge badge-warning badge-pill">{{ $notifications->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">Barang Terbaru
                <div class="card-action">
                    <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentItems as $item)
                        <tr>
                            <td><strong>{{ $item->code }}</strong></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->stock }} {{ $item->unit->name }}</td>
                            <td>{!! $item->getStatusBadgeAttribute() !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada barang</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($notifications->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <i class="fa fa-exclamation-triangle"></i> Peringatan Stok
                <a href="{{ route('admin.notifications.index') }}" class="text-white float-right small">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-borderless">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Pesan</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $notif)
                            <tr>
                                <td>{{ $notif->item->name ?? '-' }}</td>
                                <td>{{ $notif->message }}</td>
                                <td>{{ $notif->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.stock-in.create') }}?item_id={{ $notif->item_id }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i> Tambah Stok
                                    </a>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row mt-4">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">Barang Masuk Terakhir
                <div class="card-action">
                    <a href="{{ route('admin.stock-in.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStockIns as $stockIn)
                        <tr>
                            <td>{{ $stockIn->date->format('d/m/Y') }}</td>
                            <td>{{ $stockIn->item->name }}</td>
                            <td class="text-success">+{{ $stockIn->qty }}</td>
                            <td>{{ $stockIn->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">Barang Keluar Terakhir
                <div class="card-action">
                    <a href="{{ route('admin.stock-out.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStockOuts as $stockOut)
                        <tr>
                            <td>{{ $stockOut->date->format('d/m/Y') }}</td>
                            <td>{{ $stockOut->item->name }}</td>
                            <td class="text-danger">-{{ $stockOut->qty }}</td>
                            <td>{{ $stockOut->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fa fa-book"></i> Peminjaman Terakhir
                <div class="card-action">
                    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBorrowings as $borrowing)
                        <tr class="{{ $borrowing->isOverdue() ? 'table-danger' : '' }}">
                            <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td>{{ $borrowing->borrower_name }}</td>
                            <td>{{ $borrowing->item->name }}</td>
                            <td>{{ $borrowing->qty }}</td>
                            <td>{{ $borrowing->return_date->format('d/m/Y') }}</td>
                            <td>{!! $borrowing->getStatusBadgeAttribute() !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data peminjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

