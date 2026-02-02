@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-4 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $items->count() }} <span class="float-right"><i class="fa fa-box"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:100%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Total Barang</p>
                </div>
            </div>
            <div class="col-12 col-lg-4 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $items->where('stock', '>', 0)->count() }} <span class="float-right"><i class="fa fa-check-circle text-success"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar bg-success" style="width:100%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Barang Tersedia</p>
                </div>
            </div>
            <div class="col-12 col-lg-4 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0">{{ $lowStockCount }} <span class="float-right"><i class="fa fa-exclamation-triangle text-warning"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar bg-warning" style="width:100%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Stok Menipis</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Barang</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="row mb-4">
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request('search') }}">
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
    </div>
</div>

@if($notifications->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <i class="fa fa-exclamation-triangle"></i> Peringatan Stok
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-borderless">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $notif)
                            <tr>
                                <td>{{ $notif->item->name ?? '-' }}</td>
                                <td>{{ $notif->message }}</td>
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
@endsection

