<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content="Inventaris Barang Satmul - Admin"/>
  <meta name="author" content="Satmul"/>
  <title>@yield('title', 'Dashboard') - Inventaris Admin</title>
  
  <!--favicon-->
  <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
  <!-- Vector CSS -->
  <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
  <!-- simplebar CSS-->
  <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Bootstrap Icons CSS-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Sidebar CSS-->
  <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet"/>
  
  @stack('styles')
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
        <li class="nav-item">
          <form class="search-bar">
            <input type="text" class="form-control" placeholder="Enter keywords">
             <a href="javascript:void();"><i class="icon-magnifier"></i></a>
          </form>
        </li>
      </ul>
      
@php
        // Only query if authenticated and table exists
        $unreadNotifications = 0;
        if (auth()->check()) {
            try {
                $unreadNotifications = \App\Models\Notification::where('is_read', false)->count();
            } catch (\Exception $e) {
                // Table might not exist yet
            }
        }
      @endphp
      
      <ul class="navbar-nav align-items-center right-nav-link">
        <li class="nav-item dropdown-lg">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
          <i class="fa fa-envelope-open-o"></i></a>
        </li>
        <li class="nav-item dropdown-lg">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
          <i class="fa fa-bell-o"></i>
          @if($unreadNotifications > 0)
          <span class="badge badge-danger badge-pill">{{ $unreadNotifications }}</span>
          @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="p-3">
                <span class="font-weight-bold">Notifikasi</span>
                @if($unreadNotifications > 0)
                <a href="{{ route('admin.notifications.mark-all-read') }}" class="text-primary small">Tandai semua dibaca</a>
                @endif
            </div>
            <div class="dropdown-divider"></div>
            @php
              $recentNotifications = collect();
              try {
                if (auth()->check()) {
                  $recentNotifications = \App\Models\Notification::with('item')
                    ->where('is_read', false)
                    ->latest()
                    ->take(5)
                    ->get();
                }
              } catch (\Exception $e) {
                // Table might not exist yet
              }
            @endphp
            @forelse($recentNotifications as $notif)
            <a href="{{ route('admin.notifications.index') }}" class="dropdown-item">
                <div class="media">
                    <div class="avatar"><i class="fa fa-exclamation-triangle text-warning"></i></div>
                    <div class="media-body">
                        <h6 class="mt-0 user-title">{{ $notif->item->name ?? 'Barang' }}</h6>
                        <p class="mb-0 small-font">{{ \Illuminate\Support\Str::limit($notif->message, 50) }}</p>
                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-3 text-center text-muted">Tidak ada notifikasi</div>
            @endforelse
            <div class="dropdown-divider"></div>
            <a href="{{ route('admin.notifications.index') }}" class="dropdown-item text-center">Lihat Semua</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
            <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
           <li class="dropdown-item user-details">
            <a href="javascript:void();">
               <div class="media">
                 <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                <div class="media-body">
                <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
                <p class="user-subtitle">{{ Auth::user()->email }}</p>
                <small class="text-muted">{{ Auth::user()->role->name ?? 'Owner' }}</small>
                </div>
               </div>
              </a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><i class="icon-user mr-2"></i> Profil</li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Pengaturan</li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <i class="icon-power mr-2"></i>
                    <button type="submit" style="background:none; border:none; padding:0; cursor:pointer; color:inherit;">Logout</button>
                </form>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
  
  <div class="clearfix"></div>
  
  <div class="content-wrapper">
    <div class="container-fluid">
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

      @yield('content')
    </div>
    
    <!-- Footer Vertikal -->
    <footer class="bg-slate-900 text-gray-300 mt-10">
      <div class="container-fluid px-4 py-4">
        
        <!-- Baris 1: Logo & Sistem (Full Width) -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="d-flex align-items-center gap-3">
              <img src="{{ asset('assets/images/logo-icon.png') }}" alt="Logo Sekolah" class="rounded-circle" style="width: 48px; height: 48px;">
              <div>
                <h4 class="text-white font-weight-bold">Inventaris Admin</h4>
                <p class="text-muted small mb-0">Sistem Sekolah</p>
              </div>
            </div>
            <p class="mt-3 mb-0" style="max-width: 600px;">
              Platform digital untuk pengelolaan inventaris barang secara aman,
              modern, dan terintegrasi.
            </p>
          </div>
        </div>
        
        
        
        <!-- Baris 2: 4 Kolom (Navigasi, Info Sekolah, Support) -->
        <div class="row">
          
          <!-- Navigasi Cepat -->
          <div class="col-md-4 mb-3 mb-md-0">
            <h5 class="text-white font-weight-bold mb-3">Navigasi Cepat</h5>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">Dashboard</a></li>
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">Data Barang</a></li>
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">Laporan</a></li>
              <li class="mb-0"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">Pengajuan</a></li>
            </ul>
          </div>
          
          <!-- Informasi Sekolah -->
          <div class="col-md-4 mb-3 mb-md-0">
            <h5 class="text-white font-weight-bold mb-3">Informasi Sekolah</h5>
            <ul class="list-unstyled mb-0">
              <li class="mb-2">SMK Contoh Nusantara</li>
              <li class="mb-2">Jl. Pendidikan No. 123</li>
              <li class="mb-2">Email: admin@sekolah.sch.id</li>
              <li class="mb-0">Telp: 021-123456</li>
            </ul>
          </div>
          
          <!-- Support Sistem -->
          <div class="col-md-4 mb-3 mb-md-0">
            <h5 class="text-white font-weight-bold mb-3">Support Sistem</h5>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">Panduan</a></li>
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">FAQ</a></li>
              <li class="mb-2"><a href="#" class="text-gray-400 hover:text-white text-decoration-none">Kontak Admin</a></li>
              <li class="mb-0">Versi 2.1.0</li>
            </ul>
          </div>
          
        </div>
        
       
       <hr class="border-secondary"> 
        <!-- Baris 3: Copyright -->
        <div class="row">
          <div class="col-12 text-center">
            <p class="text-white font-weight-bold mb-3">© {{ date('Y') }} Sistem Inventaris Barang Sekolah — All Rights Reserved</p>
          </div>
        </div>
        
      </div>
    </footer>
    
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
  </div>
  
  <div class="right-sidebar">
    <div class="switcher-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">
      <p class="mb-0">Gaussion Texture</p>
      <hr/>
      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>
      <p class="mb-0">Gradient Background</p>
      <hr/>
      <ul class="switcher">
        <li id="theme7"></li>
        <li id="theme8"></li>
        <li id="theme9"></li>
        <li id="theme10"></li>
        <li id="theme11"></li>
        <li id="theme12"></li>
        <li id="theme13"></li>
        <li id="theme14"></li>
        <li id="theme15"></li>
      </ul>
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/app-script.js') }}"></script>
<script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/index.js') }}"></script>

@stack('scripts')
</body>
</html>

