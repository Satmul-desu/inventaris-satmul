<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
      <a href="{{ route('admin.dashboard') }}">
       <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
       <h5 class="logo-text">Inventaris Admin</h5>
     </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header">MENU UTAMA</li>
      <li>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      
      <li class="sidebar-header">DATA MASTER</li>
      <li>
        <a href="{{ route('admin.items.index') }}" class="{{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
          <i class="bi bi-box2-fill"></i> <span>Barang</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-view-list"></i> <span>Kategori</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.units.index') }}" class="{{ request()->routeIs('admin.units.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-pin"></i> <span>Satuan</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.locations.index') }}" class="{{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-pin-drop"></i> <span>Lokasi</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.suppliers.index') }}" class="{{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-truck"></i> <span>Supplier</span>
        </a>
      </li>
      
      <li class="sidebar-header">TRANSAKSI</li>
      <li>
        <a href="{{ route('admin.stock-in.index') }}" class="{{ request()->routeIs('admin.stock-in.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-plus-circle"></i> <span>Barang Masuk</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.stock-out.index') }}" class="{{ request()->routeIs('admin.stock-out.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-minus-circle"></i> <span>Barang Keluar</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.borrowings.index') }}" class="{{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-book"></i> <span>Peminjaman</span>
        </a>
      </li>
      
      <li class="sidebar-header">PENGELOLAAN</li>
      <li>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-accounts"></i> <span>Manajemen User</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
          <i class="zmdi zmdi-notifications"></i> <span>Notifikasi</span>
          @php $unread = \App\Models\Notification::where('is_read', false)->count(); @endphp
          @if($unread > 0)
          <span class="badge badge-danger float-right">{{ $unread }}</span>
          @endif
        </a>
      </li>
    </ul>
</div>

