@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data User</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah User
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role_id" class="form-control">
                    <option value="">Semua Role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="is_active" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-{{ $user->role->name == 'owner' ? 'danger' : 'info' }}">
                                {{ $user->role->name }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if($user->id != auth()->id())
                            <a href="{{ route('admin.users.toggle-active', $user->id) }}" class="btn btn-sm btn-{{ $user->is_active ? 'secondary' : 'success' }}" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fa fa-{{ $user->is_active ? 'times' : 'check' }}"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
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
                        <td colspan="7" class="text-center">Tidak ada data user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

