<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div class="logo-wrapper">
        <a href="/dashboard">
            <img class="img-fluid" style="width: 85px; margin-top: -10px"
                src="{{ asset('dashboard_assets/assets/images/logo/logo.png') }}" alt="">
        </a>
        <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
        <div class="toggle-sidebar">
            <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
        </div>
    </div>

    <div class="logo-icon-wrapper">
        <a href="/dashboard">
            <img class="img-fluid" width="10px" src="{{ asset('dashboard_assets/assets/images/logo/logo-icon.png') }}"
                alt="">
        </a>
    </div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="/dashboard"><img class="img-fluid"
                            src="{{ asset('dashboard_assets/assets/images/logo/logo-icon.png') }}" alt=""></a>
                    <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                    <div>
                        <h6>Pinned</h6>
                    </div>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6 class="lan-1">General</h6>
                    </div>
                </li>

                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title link-nav" href="/dashboard">
                        <i class="fa fa-home text-white" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                @if (in_array(auth()->user()->role, ['admin', 'teacher']))
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Data Master</h6>
                        </div>
                    </li>
                @endif

                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title link-nav" href="/users">
                        <i class="fa fa-users text-white" aria-hidden="true"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title link-nav" href="/meja">
                        <i class="fa fa-square text-white" aria-hidden="true"></i>
                        <span>Manajemen Meja</span>
                    </a>
                </li>

                {{-- @if (in_array(auth()->user()->role, ['admin', 'teacher']))
                    <li class="sidebar-list" style="cursor: pointer">
                        <a class="sidebar-link sidebar-title">
                            <i class="fa fa-user-graduate text-white"></i>
                            <span class="">Students</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="/students"><i class="fa fa-list me-2"></i> All Students</a></li>
                            <li><a href="/students-verification"><i class="fa fa-check-circle me-2"></i> Verification</a>
                            </li>
                        </ul>
                    </li>
                @endif --}}

            </ul>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</div>
