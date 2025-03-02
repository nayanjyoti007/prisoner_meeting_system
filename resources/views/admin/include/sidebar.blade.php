<ul class="menu-inner py-1">
    <!-- Dashboard -->

    <li class="menu-item @yield('dashboard')">
        <a href="{{route('admin.dashboard')}}" class="menu-link">
            <i class="menu-icon fa fa-home" aria-hidden="true"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>


    {{-- <li class="menu-item @yield('admin_centetr_list')">
        <a href="" class="menu-link">
            <i class="menu-icon fa fa-university" aria-hidden="true"></i>
            <div data-i18n="Analytics">Center List</div>
        </a>
    </li>


    <li class="menu-item @yield('admin_external_list')">
        <a href="" class="menu-link">
            <i class="menu-icon fa fa-inbox" aria-hidden="true"></i>
            <div data-i18n="Analytics">Visitor KYC Verification</div>
        </a>
    </li> --}}



    <li class="menu-item @yield('changepassword')">
        <a href="" class="menu-link">
            <i class="menu-icon fa fa-key" aria-hidden="true"></i>
            <div data-i18n="Analytics">Change Password</div>
        </a>
    </li>


    <li class="menu-item">
        <a href="{{ route('admin.logout') }}" class="menu-link">
            <i class="menu-icon fa fa-power-off" aria-hidden="true"></i>
            <div data-i18n="Analytics">Logout</div>
        </a>
    </li>

</ul>
