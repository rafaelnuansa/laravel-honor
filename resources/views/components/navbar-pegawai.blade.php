<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <x-notification-pegawai></x-notification-pegawai>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600">
                                   {{ $navpegawai->nama_pegawai }}
                                </span>
                                <span class="user-status">
                                    {{ $navpegawai->jabatan->nama_jabatan }}
                                </span>
                            </div>
                            <div class="avatar bg-primary">
                                <span class="avatar-content">
                                    {{ substr($navpegawai->nama_pegawai, 0, 1) }}
                                </span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="{{ route('dashboard.logout') }}"><i
                                    class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->
