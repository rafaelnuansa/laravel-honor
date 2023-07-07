<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <i class="feather icon-award"></i>
                    <h2 class="brand-text mb-0">Sihonor</h2>
                </a>
            </li>

            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                        data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->level === 'Operator' || Auth::user()->level === 'Administrator')
                <li class="nav-item">
                    <a href="#"><i class="feather icon-database"></i><span class="menu-title">Master
                            Data</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'jabatan.')? 'active': '' }}">
                            <a href="{{ route('jabatan.index') }}">
                                <i class="feather icon-briefcase"></i>
                                <span class="menu-title">Jabatan</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'mapel.')? 'active': '' }}">
                            <a href="{{ route('mapel.index') }}">
                                <i class="feather icon-book"></i>
                                <span class="menu-title">Mata Pelajaran</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'kelas.')? 'active': '' }}">
                            <a href="{{ route('kelas.index') }}">
                                <i class="feather icon-layers"></i>
                                <span class="menu-title">Kelas</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'kegiatan.')? 'active': '' }}">
                            <a href="{{ route('kegiatan.index') }}">
                                <i class="feather icon-activity"></i>
                                <span class="menu-title">Kegiatan</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'tugas.')? 'active': '' }}">
                            <a href="{{ route('tugas.index') }}">
                                <i class="feather icon-activity"></i>
                                <span class="menu-title">Tugas Tambahan</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'pegawai.')? 'active': '' }}">
                            <a href="{{ route('pegawai.index') }}">
                                <i class="feather icon-users"></i>
                                <span class="menu-title">Pegawai</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ Str::startsWith(request()->route()->getName(),'channels.')? 'active': '' }}">
                            <a href="{{ route('channels.index') }}">
                                <i class="feather icon-cast"></i>
                                <span class="menu-title">Channels</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ Str::startsWith(request()->route()->getName(),'status_mengajar.')? 'active': '' }}">
                            <a href="{{ route('status_mengajar.index') }}">
                                <i class="feather icon-slack"></i>
                                <span class="menu-title">Status KBM</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'honor.')? 'active': '' }}">
                    <a href="{{ route('honor.index') }}">
                        <i class="feather icon-award"></i>
                        <span class="menu-title">Honor Harian</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->level === 'Bendahara' || Auth::user()->level === 'Administrator')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'payment.')? 'active': '' }}">
                <a href="{{ route('payment.index') }}">
                    <i class="feather icon-book"></i>
                    <span class="menu-title">Pembayaran Honor</span>
                </a>
            </li>

            <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'otherpayment.')? 'active': '' }}">
                <a href="{{ route('otherpayment.index') }}">
                    <i class="feather icon-book"></i>
                    <span class="menu-title">Pembayaran Lainnya</span>
                </a>
            </li>
        @endif


            <li class="navigation-header"><span>Laporan</span></li>

            <li class="nav-item">
                <a href="#"><i class="feather icon-book"></i><span class="menu-title">Laporan</span></a>
                <ul class="menu-content">
                    <li
                        class="nav-item {{ Str::startsWith(request()->route()->getName(),'laporan.honor.')? 'active': '' }}">
                        <a href="{{ route('laporan.honor.index') }}">
                            <i class="feather icon-book"></i>
                            <span class="menu-title">Honor Harian</span>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ Str::startsWith(request()->route()->getName(),'laporan.honorMonth.')? 'active': '' }}">
                        <a href="{{ route('laporan.honorMonth.index') }}">
                            <i class="feather icon-book"></i>
                            <span class="menu-title">Akumulasi Bulanan</span>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('laporan.payment.index') ? 'active' : '' }}">
                        <a href="{{ route('laporan.payment.index') }}">
                            <i class="feather icon-book"></i>
                            <span class="menu-title">Transaksi Honor</span>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('laporan.payment.other') ? 'active' : '' }}">
                        <a href="{{ route('laporan.payment.other') }}">
                            <i class="feather icon-book"></i>
                            <span class="menu-title">Lainnya</span>
                        </a>
                    </li>
                </ul>
            </li>

            @if (Auth::user()->level === 'Administrator')
            <li class="navigation-header"><span>Pengaturan</span></li>
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'users.')? 'active': '' }}">
                <a href="{{ route('users.index') }}">
                    <i class="feather icon-book"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>

            <li class="nav-item {{ Str::startsWith(request()->route()->getName(),'settings.')? 'active': '' }}">
                <a href="{{ route('settings.index') }}">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>
            @endif

        </ul>
    </div>

</div>
<!-- END: Main Menu-->
