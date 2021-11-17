<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ set_active(['dashboard.index']) }}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    
    <!-- Nav Item - Data Pegawai -->
    @if(Auth::user()->level == "admin")
    <div class="sidebar-heading">
        Data Master
    </div>
    <li class="nav-item {{ set_active(['jabatan.index']) }}">
        <a class="nav-link" href="{{ route('jabatan.index') }}">
            <i class="fas fa-handshake"></i>
            <span>Data Jabatan</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->level == "admin")
    <li class="nav-item {{ set_active(['golongan.index']) }}">
        <a class="nav-link" href="{{ route('golongan.index') }}">
            <i class="fas fa-medal"></i>
            <span>Data Golongan</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->level == "admin")
    <li class="nav-item {{ set_active(['users.index', 'users.create']) }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>Data Pegawai</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->level == "admin")
    <li class="nav-item {{ set_active(['absens.read']) }}">
        <a class="nav-link" href="{{ route('absens.read') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Laporan Absen</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->level == "pegawai")
    <!-- Heading -->
    <div class="sidebar-heading">
        Data Absen
    </div>
    <li class="nav-item {{ set_active(['absens.index']) }}">
        <a class="nav-link" href="{{ route('absens.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Absen</span>
        </a>
    </li>
    @endif

    <li class="nav-item {{ set_active(['pengaturan.index']) }}">
        <a class="nav-link" href="{{ route('pengaturan.index') }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan Akun</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-3">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>