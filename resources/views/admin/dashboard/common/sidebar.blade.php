<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fa fa-bus"></i>
            </div>
            <span class="sidebar-brand-text">InayaFleet360</span>
        </a>
        <div class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fa fa-bars"></i>
        </div>
    </div>
    
    <div class="sidebar-content">
        <nav class="nav-main">
            <ul class="nav nav-main">
                {{-- Dashboard --}}
                <li class="{{ request()->routeIs('home') ? 'nav-active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                {{-- Requisitions (All Roles) --}}
                @if($isAdmin || $isManager || $isEmployee)
                <li class="nav-parent {{ request()->routeIs('requisitions.*') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Requisitions</span>
                    </a>
                    <ul class="nav nav-children" {{ request()->routeIs('requisitions.*') ? 'style=display:block' : '' }}>
                        <li class="{{ request()->routeIs('requisitions.index') ? 'nav-active' : '' }}">
                            <a href="{{ route('requisitions.index') }}">
                                <i class="fas fa-list"></i>
                                All Requisitions
                            </a>
                        </li>
                        @if($isEmployee)
                        <li class="{{ request()->routeIs('requisitions.create') ? 'nav-active' : '' }}">
                            <a href="{{ route('requisitions.create') }}">
                                <i class="fas fa-plus-circle"></i>
                                New Request
                            </a>
                        </li>
                        @endif
                        @if($isManager)
                        <li class="">
                            <a href="{{ route('requisitions.index') }}?status=pending">
                                <i class="fas fa-clock"></i>
                                Pending Approvals
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                
                {{-- Approvals (Admin, Manager, Transport) --}}
                @if($isAdmin || $isManager || $isTransport)
                <li class="nav-parent {{ request()->routeIs('department.approvals.*') || request()->routeIs('transport.approvals.*') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-check-double"></i>
                        <span>Approvals</span>
                    </a>
                    <ul class="nav nav-children" {{ (request()->routeIs('department.approvals.*') || request()->routeIs('transport.approvals.*')) ? 'style=display:block' : '' }}>
                        @if($isAdmin || $isManager)
                        <li class="{{ request()->routeIs('department.approvals.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('department.approvals.index') }}">
                                <i class="fas fa-building"></i>
                                Department
                            </a>
                        </li>
                        @endif
                        @if($isAdmin || $isTransport)
                        <li class="{{ request()->routeIs('transport.approvals.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('transport.approvals.index') }}">
                                <i class="fas fa-truck"></i>
                                Transport
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                
                {{-- Vehicles (Admin, Transport) --}}
                @if($isAdmin || $isTransport)
                <li class="nav-parent {{ request()->routeIs('vehicles.*') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-car"></i>
                        <span>Fleet</span>
                    </a>
                    <ul class="nav nav-children" {{ request()->routeIs('vehicles.*') ? 'style=display:block' : '' }}>
                        <li class="{{ request()->routeIs('vehicles.index') ? 'nav-active' : '' }}">
                            <a href="{{ route('vehicles.index') }}">
                                <i class="fas fa-car-side"></i>
                                Vehicles
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('vehicle-type.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('vehicle-type.index') }}">
                                <i class="fas fa-tags"></i>
                                Vehicle Types
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('maintenance.index') }}">
                                <i class="fas fa-tools"></i>
                                Maintenance
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                {{-- Drivers (Admin, Transport) --}}
                @if($isAdmin || $isTransport)
                <li class="{{ request()->routeIs('drivers.*') ? 'nav-active' : '' }}">
                    <a href="{{ route('drivers.index') }}">
                        <i class="fas fa-id-card"></i>
                        <span>Drivers</span>
                    </a>
                </li>
                @endif
                
                {{-- Employees (Admin, Manager) --}}
                @if($isAdmin || $isManager)
                <li class="nav-parent {{ request()->routeIs('employees.*') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-users"></i>
                        <span>HR Management</span>
                    </a>
                    <ul class="nav nav-children" {{ request()->routeIs('employees.*') ? 'style=display:block' : '' }}>
                        <li class="{{ request()->routeIs('employees.index') ? 'nav-active' : '' }}">
                            <a href="{{ route('employees.index') }}">
                                <i class="fas fa-user-plus"></i>
                                Employees
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('departments.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('departments.index') }}">
                                <i class="fas fa-sitemap"></i>
                                Departments
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('department-heads.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('department-heads.index') }}">
                                <i class="fas fa-user-tie"></i>
                                Department Heads
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                {{-- Maintenance (Admin, Transport) --}}
                @if($isAdmin || $isTransport)
                <li class="nav-parent {{ request()->routeIs('maintenance.*') || request()->routeIs('maintenance-types.*') || request()->routeIs('maintenance-vendors.*') || request()->routeIs('maintenance-categories.*') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-wrench"></i>
                        <span>Maintenance</span>
                    </a>
                    <ul class="nav nav-children" {{ (request()->routeIs('maintenance.*') || request()->routeIs('maintenance-types.*') || request()->routeIs('maintenance-vendors.*') || request()->routeIs('maintenance-categories.*')) ? 'style=display:block' : '' }}>
                        <li class="{{ request()->routeIs('maintenance.index') ? 'nav-active' : '' }}">
                            <a href="{{ route('maintenance.index') }}">
                                <i class="fas fa-clipboard-check"></i>
                                Records
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('maintenance-types.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('maintenance-types.index') }}">
                                <i class="fas fa-list"></i>
                                Types
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('maintenance-vendors.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('maintenance-vendors.index') }}">
                                <i class="fas fa-store"></i>
                                Vendors
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('maintenance-categories.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('maintenance-categories.index') }}">
                                <i class="fas fa-tags"></i>
                                Categories
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                {{-- Reports (Admin, Manager, Transport) --}}
                @if($isAdmin || $isManager || $isTransport)
                <li class="nav-parent {{ request()->routeIs('reports.requisitions') || request()->routeIs('reports.trips_fuel') || request()->routeIs('reports.vehicle_utilization') || request()->routeIs('reports.maintenance') || request()->routeIs('reports.driver_performance') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="nav nav-children" {{ (request()->routeIs('reports.requisitions') || request()->routeIs('reports.trips_fuel') || request()->routeIs('reports.vehicle_utilization') || request()->routeIs('reports.maintenance') || request()->routeIs('reports.driver_performance')) ? 'style=display:block' : '' }}>
                        <li class="{{ request()->routeIs('reports.requisitions') ? 'nav-active' : '' }}">
                            <a href="{{ route('reports.requisitions') }}">
                                <i class="fas fa-clipboard-list"></i>
                                Requisitions
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.vehicle_utilization') ? 'nav-active' : '' }}">
                            <a href="{{ route('reports.vehicle_utilization') }}">
                                <i class="fas fa-car"></i>
                                Vehicle Utilization
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.trips_fuel') ? 'nav-active' : '' }}">
                            <a href="{{ route('reports.trips_fuel') }}">
                                <i class="fas fa-gas-pump"></i>
                                Trips & Fuel
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.maintenance') ? 'nav-active' : '' }}">
                            <a href="{{ route('reports.maintenance') }}">
                                <i class="fas fa-tools"></i>
                                Maintenance
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.driver_performance') ? 'nav-active' : '' }}">
                            <a href="{{ route('reports.driver_performance') }}">
                                <i class="fas fa-id-card"></i>
                                Driver Performance
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                {{-- Settings (Admin Only) --}}
                @if($isAdmin)
                <li class="nav-parent {{ request()->routeIs('settings.*') || request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('menus.*') || request()->routeIs('admin.notifications.*') ? 'nav-expanded nav-active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="nav nav-children" {{ (request()->routeIs('settings.*') || request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('menus.*') || request()->routeIs('admin.notifications.*')) ? 'style=display:block' : '' }}>
                        <li class="{{ request()->routeIs('settings.index') ? 'nav-active' : '' }}">
                            <a href="{{ route('settings.index') }}">
                                <i class="fas fa-sliders-h"></i>
                                General
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('users.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-users-cog"></i>
                                Users
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('roles.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('roles.index') }}">
                                <i class="fas fa-shield-alt"></i>
                                Roles & Permissions
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('menus.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('menus.index') }}">
                                <i class="fas fa-bars"></i>
                                Menu Management
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.notifications.*') ? 'nav-active' : '' }}">
                            <a href="{{ route('admin.notifications.all') }}">
                                <i class="fas fa-bell"></i>
                                Notifications
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    
</aside>

<style>
    .sidebar-left {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }
    
    .sidebar-left .sidebar-header {
        flex-shrink: 0;
    }
    
    .sidebar-left .sidebar-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .sidebar-left .sidebar-footer {
        flex-shrink: 0;
    }
    
    .nav-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 10px 20px;
    }
    
    .nav-header {
        font-size: 11px;
        letter-spacing: 1px;
    }
    
    .nav-main .nav > li > a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.2s ease;
        gap: 12px;
    }
    
    .nav-main .nav > li > a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    
    .nav-main .nav > li.active > a {
        background: rgba(79, 70, 229, 0.2);
        color: #fff;
    }
    
    .nav-main .nav > li > a i {
        width: 20px;
        text-align: center;
        font-size: 16px;
    }
    
    .nav-children {
        display: none;
        background: rgba(0, 0, 0, 0.15);
        padding: 5px 0;
        list-style: none;
    }
    
    .nav-children.show {
        display: block;
    }
    
    .nav-children li a {
        display: flex;
        align-items: center;
        padding: 10px 20px 10px 52px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: all 0.2s ease;
        gap: 10px;
        font-size: 14px;
    }
    
    .nav-children li a:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }
    
    .nav-children li.active a {
        background: rgba(79, 70, 229, 0.15);
        color: #fff;
    }
    
    .nav-children li a i {
        width: 16px;
        text-align: center;
        font-size: 14px;
    }
    
    .nav-parent > a::after {
        content: '\f054';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: auto;
        font-size: 12px;
        transition: transform 0.2s ease;
    }
    
    .nav-parent.nav-expanded > a::after {
        transform: rotate(90deg);
    }
    
    .sidebar-footer .user-avatar {
        background: linear-gradient(135deg, #4f46e5, #0ea5e9);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    
    /* Scrollbar styling */
    .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-content::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .sidebar-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Collapsed sidebar styles */
    .sidebar-left.collapsed .sidebar-brand-text,
    .sidebar-left.collapsed .nav-main .nav > li > a span,
    .sidebar-left.collapsed .nav-children,
    .sidebar-left.collapsed .nav-divider,
    .sidebar-left.collapsed .nav-header,
    .sidebar-left.collapsed .user-info {
        display: none !important;
    }
    
    .sidebar-left.collapsed .nav-main .nav > li > a {
        padding: 12px 15px;
        justify-content: center;
    }
    
    .sidebar-left.collapsed .nav-main .nav > li > a::after {
        display: none;
    }
    
    .sidebar-left.collapsed .nav-children li a {
        padding-left: 15px;
    }
    
    .sidebar-left.collapsed .sidebar-toggle {
        margin-left: auto;
        margin-right: auto;
    }
    
    .sidebar-left.collapsed .sidebar-footer .d-flex {
        justify-content: center;
        padding: 10px 15px;
    }
    
    .sidebar-left.collapsed .sidebar-footer .user-avatar {
        margin-right: 0 !important;
    }
</style>

<script>
    function toggleSubmenu(element) {
        var parent = element.parentElement;
        parent.classList.toggle('nav-expanded');
        var children = parent.querySelector('.nav-children');
        if (children) {
            children.classList.toggle('show');
        }
    }
</script>
