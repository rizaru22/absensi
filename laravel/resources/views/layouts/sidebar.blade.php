<aside class="main-sidebar elevation-4 sidebar-light-olive">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('img/favicon-32x32.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8"><span class="brand-text ">Hadir<span class="text-logo">In</span></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- SidebarSearch Form -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin') }}" class="nav-link {{ ($title==='Dashboard')?'active':'' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pengaturan.index')}}" class="nav-link {{ ($title==='Pengaturan')?'active':'' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Pengaturan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengguna.index')}}" class="nav-link {{ ($title==='Pegawai')?'active':'' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pegawai
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('liburnasional.index')}}"
                        class="nav-link {{ ($title==='Libur Nasional')?'active':'' }}">
                        <i class="nav-icon fas fa-thumbs-up"></i>
                        <p>
                            Libur Nasional
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pilihtanggallh')}}"
                        class="nav-link {{ ($title==='Laporan Harian')?'active':'' }}">
                        <i class="nav-icon far fa-flag"></i>
                        <p>
                            Laporan Harian
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pilihtanggallm') }}"
                        class="nav-link {{ ($title==='Laporan Mingguan')?'active':'' }}">
                        <i class="nav-icon fas fa-flag"></i>
                        <p>
                            Laporan Mingguan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pilihbulantahun') }}"
                        class="nav-link {{ ($title==='Laporan Bulanan')?'active':'' }}">
                        <i class="nav-icon fas fa-flag-checkered"></i>
                        <p>
                            Laporan Bulanan
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>