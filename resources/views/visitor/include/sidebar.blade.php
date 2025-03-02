<ul class="menu-inner py-1">
    <!-- Dashboard -->

    <li class="menu-item @yield('dashboard')">
        <a href="{{ route('visitor.dashboard') }}" class="menu-link">
            <i class="menu-icon fa fa-home" aria-hidden="true"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>






    {{--
        <li class="menu-item @yield('student_manage_open')">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa fa-graduation-cap" aria-hidden="true"></i>
                <div data-i18n="Form Elements"> External Managment</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item ">
                    <a href="" class="menu-link">
                        <div data-i18n="Basic Inputs">Get External List</div>
                    </a>
                </li>
            </ul>
        </li> --}}


    <li class="menu-item @yield('meeting_request')">
            <a href="{{route('visitor.sending-meeting-request.form')}}" class="menu-link">
                <i class="menu-icon fa fa-calendar-minus-o" aria-hidden="true"></i>
                <div data-i18n="Analytics">Send Request</div>
            </a>
        </li>




    <li class="menu-item @yield('family_member')">
        <a href="{{route('visitor.family-member.list')}}" class="menu-link">
            <i class="menu-icon fa fa-users" aria-hidden="true"></i>
            <div data-i18n="Analytics">Family Members</div>
        </a>
    </li>


    @php
        $visitor_id = Auth::guard('visitor')->id();
        $visitorData = App\Models\Visitor::find($visitor_id);
        $notifications = App\Models\VisitorNotification::whereJsonContains('visitor_id', $visitor_id)
            ->where('mark_read', 0)
            ->count();
    @endphp


    <li class="menu-item @yield('notification')">
        <a href="{{route('visitor.notification')}}" class="menu-link">
            <i class="menu-icon fa fa-bell" aria-hidden="true"></i>
            <div data-i18n="Analytics">Notification <span class="badge badge-center rounded-pill bg-danger">{{$notifications}}</span></div>
        </a>
    </li>



    <li class="menu-item @yield('changepassword')">
        <a href="{{route('visitor.changePasswordForm')}}" class="menu-link">
            <i class="menu-icon fa fa-key" aria-hidden="true"></i>
            <div data-i18n="Analytics">Change Password</div>
        </a>
    </li>










    <li class="menu-item">
        <a href="{{ route('visitor.logout') }}" class="menu-link">
            <i class="menu-icon fa fa-power-off" aria-hidden="true"></i>
            <div data-i18n="Analytics">Logout</div>
        </a>
    </li>

</ul>
