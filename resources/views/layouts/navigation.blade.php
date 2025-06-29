<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ request()->is('home*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Beranda') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('absenmanual.index') }}" class="nav-link {{ request()->is('absenmanual*') ? 'active' : '' }}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>
                        {{ __('Absen Manual') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        {{ __('Report Absen') }}
                    </p>
                </a>
            </li>



            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-briefcase nav-icon"></i>
                    <p>
                        Master Data
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{route('siswa.index')}}" class="nav-link {{ request()->is('siswa*') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('kelas.index')}}" class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                            <i class="fas fa-school nav-icon"></i>
                            <p>Data Kelas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog nav-icon"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('appconfig.index')}}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                            <i class="fas fa-cog nav-icon"></i>
                            <p>Setting Aplikasi</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
