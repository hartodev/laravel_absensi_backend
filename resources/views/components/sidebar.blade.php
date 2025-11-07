<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Absen Pintar</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">AP</a>
        </div>
        <ul class="sidebar-menu">
               {{-- DASHBOARD --}}
    <li class="menu-header">Dashboard</li>
    @if(Auth::user()->role == 'admin')
        <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="fas fa-fire"></i><span>Dashboard Admin</span>
            </a>
        </li>
    @elseif(Auth::user()->role == 'company')
        <li class="{{ request()->is('company/dashboard') ? 'active' : '' }}">
            <a href="{{ route('company.dashboard') }}" class="nav-link">
                <i class="fas fa-building"></i><span>Dashboard Company</span>
            </a>
        </li>
    @else
        <li class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="nav-link">
                <i class="fas fa-user"></i><span>Dashboard User</span>
            </a>
        </li>
    @endif


    {{-- ADMIN MENU --}}
    @if(Auth::user()->role == 'admin')
        <li class="menu-header">Management</li>
        <li>
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-users"></i><span>Users</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-building"></i><span>Companies</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-clock"></i><span>Attendances</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-user-check"></i><span>Permissions</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i><span>Payroll Templates</span>
            </a>
        </li>
    @endif


    {{-- COMPANY MENU --}}
    @if(Auth::user()->role == 'company')
        <li class="menu-header">Company Management</li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-clock"></i><span>Attendances</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-users"></i><span>Employees</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-user-check"></i><span>Permissions</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-calendar-alt"></i><span>Shift Schedule</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-money-check-alt"></i><span>Payroll</span>
            </a>
        </li>
    @endif


    {{-- USER MENU --}}
    @if(Auth::user()->role == 'user')
        <li class="menu-header">My Menu</li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-clock"></i><span>Absensi Saya</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-plane"></i><span>Izin & Dinas</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-calendar-alt"></i><span>Jadwal & Reminder</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i><span>Slip Gaji</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-comments"></i><span>Chat Admin</span>
            </a>
        </li>
    @endif

            </ul>
    </aside>
</div>
