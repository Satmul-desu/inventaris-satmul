@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Edit User: {{ $user->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="8">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role_id">Role <span class="text-danger">*</span></label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status Saat Ini</label>
                        <div>
                            @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">User aktif</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

