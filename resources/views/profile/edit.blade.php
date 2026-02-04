<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="Edit Profil - Inventaris Admin"/>
    <meta name="author" content="Satmul"/>
    <title>Edit Profil - Inventaris Admin</title>
    
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap Icons CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Style-->
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet"/>
    
    <style>
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4290 100%);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .badge-success {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .badge-secondary {
            background: #6c757d;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-theme bg-theme1">
<div id="wrapper">
  @include('layouts.partials.sidebar-admin')
  
  <header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top">
      <ul class="navbar-nav mr-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link toggle-menu" href="javascript:void();">
           <i class="icon-menu menu-icon"></i>
         </a>
        </li>
      </ul>
      <ul class="navbar-nav align-items-center right-nav-link">
        <li class="nav-item">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
            @php
                $currentUser = Auth::user();
                $hasPhoto = $currentUser && $currentUser->photo;
                $photoUrl = $hasPhoto ? asset('storage/' . $currentUser->photo) : null;
                // Get admin icon
                $adminIcon = 'fa-user';
                if ($currentUser && $currentUser->role) {
                    if ($currentUser->role->name == 'owner') {
                        $adminIcon = 'fa-user-shield';
                    } elseif ($currentUser->role->name == 'admin') {
                        $adminIcon = 'fa-user-cog';
                    } elseif ($currentUser->role->name == 'staff') {
                        $adminIcon = 'fa-user-edit';
                    }
                }
            @endphp
            <span class="user-profile">
                @if($hasPhoto)
                    <img src="{{ $photoUrl }}" class="img-circle" alt="user avatar" style="width: 38px; height: 38px; object-fit: cover;">
                @else
                    <div class="user-profile-no-photo img-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="{{ $adminIcon }} text-white" style="font-size: 18px;"></i>
                    </div>
                @endif
            </span>
          </a>
        </li>
      </ul>
    </nav>
  </header>
  
  <div class="clearfix"></div>
  
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row mt-5">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="mb-0"><i class="fa fa-user mr-2"></i>Edit Profil</h4>
            </div>
            <div class="card-body">
              @if(session('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <div class="alert-icon"><i class="fa fa-check-circle"></i></div>
                <div class="alert-message">{{ session('success') }}</div>
              </div>
              @endif

              @if(session('error'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <div class="alert-icon"><i class="fa fa-times-circle"></i></div>
                <div class="alert-message">{{ session('error') }}</div>
              </div>
              @endif

              <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <!-- Foto Profil -->
                <div class="mb-4">
                    <label class="font-medium text-gray-700 mb-2 d-block">Foto Profil</label>
                    <div class="d-flex align-items-center gap-4">
                        @php
                            $hasPhoto = $user->photo;
                            $photoUrl = $hasPhoto ? asset('storage/' . $user->photo) : null;
                            // Get admin icon
                            $adminIcon = 'fa-user';
                            if ($user && $user->role) {
                                if ($user->role->name == 'owner') {
                                    $adminIcon = 'fa-user-shield';
                                } elseif ($user->role->name == 'admin') {
                                    $adminIcon = 'fa-user-cog';
                                } elseif ($user->role->name == 'staff') {
                                    $adminIcon = 'fa-user-edit';
                                }
                            }
                        @endphp
                        
                        @if($hasPhoto)
                            <img src="{{ $photoUrl }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #667eea;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="{{ $adminIcon }}" style="font-size: 48px;"></i>
                            </div>
                        @endif
                        
                        <div>
                            <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewPhoto(event)" />
                            @error('photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div id="photo-preview-container" class="mt-3" style="display: none;">
                        <small class="text-muted">Preview foto baru:</small><br>
                        <img id="photo-preview" src="" alt="Preview" class="rounded-circle mt-1" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #667eea;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Tambahan (Read-only) -->
                <div class="p-4 bg-gray-50 rounded-lg mt-4">
                    <h5 class="font-medium text-gray-700 mb-3"><i class="fa fa-info-circle mr-2"></i>Informasi Akun</h5>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="text-sm text-gray-600">Role:</label>
                            <p class="font-medium text-gray-900">{{ $user->role->name ?? 'Owner' }}</p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="text-sm text-gray-600">Status:</label>
                            <p class="font-medium text-gray-900">
                                @if($user->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="text-sm text-gray-600">Terakhir Login:</label>
                            <p class="font-medium text-gray-900">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="fa fa-save mr-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ml-2">
                        <i class="fa fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <footer class="bg-slate-900 text-gray-300 mt-5 py-4">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 text-center">
              <p class="text-white font-weight-bold mb-0">© {{ date('Y') }} Sistem Inventaris Barang Sekolah — All Rights Reserved</p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  
  <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/app-script.js') }}"></script>

<script>
    function previewPhoto(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('photo-preview-container');
        const previewImage = document.getElementById('photo-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
</body>
</html>
