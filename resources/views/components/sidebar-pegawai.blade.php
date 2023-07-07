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

            <li class="{{ request()->routeIs('history.index') ? 'active' : '' }}">
                <a href="{{ route('history.index') }}">
                    <i class="feather icon-layers"></i>
                    <span class="menu-title">History Honor</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('pencairan.index') ? 'active' : '' }}">
                <a href="{{ route('pencairan.index') }}">
                    <i class="feather icon-command"></i>
                    <span class="menu-title">Pencairan</span>
                </a>
            </li>


            <li class="{{ request()->routeIs('lainnya.index') ? 'active' : '' }}">
                <a href="{{ route('lainnya.index') }}">
                    <i class="feather icon-file"></i>
                    <span class="menu-title">Lainnya</span>
                </a>
            </li>


            <li class="{{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                <a href="{{ route('notifications.index') }}">
                    <i class="feather icon-bell"></i>
                    <span class="menu-title">Notifikasi</span>
                    <span class="badge badge badge-primary badge-pill float-right mr-2">{{ $notifications->count() }}</span>
                </a>
            </li>
        </ul>
    </div>

</div>
<!-- END: Main Menu-->
