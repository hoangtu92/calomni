<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>--}}

{{--If administrator--}}
@if(backpack_user()->canAdministrate())

    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-server"></i> Hosts</a>
        <ul class="nav-dropdown-items">
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('host') }}'><i
                        class='nav-icon la la-server'></i>All Hosts</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('host-software') }}'><i
                        class='nav-icon la la-check'></i> Verified Hosts</a></li>

        </ul>
    </li>

    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('task') }}'><i class='nav-icon la la-tasks'></i>
            Tasks</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-users'></i> Users</a>
    </li>

    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('software') }}'><i
                class='nav-icon la la-tag'></i> Software</a></li>



    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('affiliate') }}'><i
                class='nav-icon la la-chart-bar'></i> Affiliates</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('announcement') }}'><i
                class='nav-icon la la-newspaper'></i> Announcements</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i
                class='nav-icon la la-notes-medical'></i> Logs Records</a></li>
@endif


{{--If Admin or SH--}}
@if(backpack_user()->canSH())
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('host') }}'><i
                class='nav-icon la la-server'></i> Hosts</a></li>
@endif

{{--If Admin or RH--}}
@if(backpack_user()->canRH())
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job') }}'><i class='nav-icon la la-list-alt'></i>
            Jobs</a></li>

    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('billing') }}'><i class='nav-icon la la-bank'></i>
            Billing Records</a></li>
@endif

{{--Everyone can access--}}

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('/edit-account-info') }}'><i
            class='nav-icon la la-user'></i> My Account</a></li>


{{--<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>--}}

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('ticket') }}'><i class='nav-icon la la-question-circle'></i>
        Tickets</a></li>


{{--
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('software-test') }}'><i class='nav-icon la la-question'></i> SoftwareTests</a></li>
--}}

{{--
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>--}}
