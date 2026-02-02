<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
      <a href="{{ route('user.dashboard') }}">
       <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
       <h5 class="logo-text">Inventaris User</h5>
     </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header">MENU</li>
      <li>
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
          <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{ route('user.items.index') }}" class="{{ request()->routeIs('user.items.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-box"></i> <span>Daftar Barang</span>
        </a>
      </li>
      <li>
        <a href="#" class="{{ request()->routeIs('user.notifications') ? 'active' : '' }}">
          <i class="zmdi zmdi-notifications"></i> <span>Notifikasi</span>
          @php $unread = \App\Models\Notification::where('is_read', false)->count(); @endphp
          @if($unread > 0)
          <span class="badge badge-danger float-right">{{ $unread }}</span>
          @endif
        </a>
      </li>
    </ul>
</div>

