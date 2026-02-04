@extends('layouts.admin')

@section('title', 'Buat Notifikasi Manual')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="fa fa-bell"></i> Buat Notifikasi Manual
        </h4>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Judul Notifikasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" placeholder="Contoh: Stok barang menipis" 
                               value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="normal">Normal</option>
                            <option value="high">Penting</option>
                            <option value="low">Rendah</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="message">Pesan Notifikasi <span class="text-danger">*</span></label>
                <textarea class="form-control @error('message') is-invalid @enderror" 
                          id="message" name="message" rows="5" 
                          placeholder="Tulis pesan notifikasi yang jelas dan informatif..." required>{{ old('message') }}</textarea>
                @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="user_id">Kirim Kepada (Opsional)</label>
                <select class="form-control" id="user_id" name="user_id">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role->name }})</option>
                    @endforeach
                </select>
                <small class="text-muted">Kosongkan jika notifikasi untuk semua user</small>
            </div>

            <div class="form-group">
                <label for="type">Tipe Notifikasi</label>
                <select class="form-control" id="type" name="type">
                    <option value="manual">Manual</option>
                    <option value="stock">Stok Barang</option>
                    <option value="borrowing">Peminjaman</option>
                    <option value="system">Sistem</option>
                    <option value="announcement">Pengumuman</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <button type="reset" class="btn btn-outline-secondary mr-2">
                        <i class="fa fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane"></i> Kirim Notifikasi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
