<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fa fa-bus"></i>
            </div>
            <span class="sidebar-brand-text">InayaFleet360</span>
        </a>
    </div>
    
    <div class="sidebar-content">
        <nav class="nav-main">
            <ul class="nav-main">
                {{-- 1. Dashboard --}}
                <li class="{{ request()->is('/') || request()->is('home') || request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- 2. Settings --}}
                @if(auth()->user()->can('settings-manage') || $isSuperAdmin || $isAdmin)
                <li class="{{ request()->is('settings') || request()->is('settings/*') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Settings</span>
                    </a>
                </li>
                @endif

                {{-- 3. Roles & Permissions --}}
                @if(auth()->user()->can('role-manage') || $isSuperAdmin || $isAdmin)
                <li class="{{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}">
                        <i class="fas fa-shield"></i>
                        <span>Roles & Permissions</span>
                    </a>
                </li>
                @endif

                {{-- 4. User Manage --}}
                @if(auth()->user()->can('user-manage') || $isSuperAdmin || $isAdmin)
                <li class="nav-parent {{ request()->is('users*') ? 'expanded' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-users"></i>
                        <span>User Manage</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('users*') ? 'show' : '' }}">
                        @if(auth()->user()->can('user-create') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('users/create') ? 'active' : '' }}">
                            <a href="{{ route('users.create') }}">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add User</span>
                            </a>
                        </li>
                        @endif
                        <li class="{{ request()->is('users') && !request()->is('users/create') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-list"></i>
                                <span>User List</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 5. Menu Manage --}}
                @if(auth()->user()->can('menu-manage') || $isSuperAdmin || $isAdmin)
                <li class="nav-parent {{ request()->is('menus*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-sitemap"></i>
                        <span>Menu Manage</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('menus*') ? 'show' : '' }}">
                        <li class="{{ request()->is('menus/create') ? 'active' : '' }}">
                            <a href="{{ route('menus.create') }}">
                                <i class="fas fa-plus-square-o"></i>
                                <span>Add Menu</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('menus') && !request()->is('menus/create') ? 'active' : '' }}">
                            <a href="{{ route('menus.index') }}">
                                <i class="fas fa-list-ul"></i>
                                <span>Menu List</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 6. Employee Manage --}}
                @if(auth()->user()->can('employee-manage') || $isSuperAdmin || $isAdmin || $isManager)
                <li class="nav-parent {{ request()->is('admin/employees*') || request()->is('admin/units*') || request()->is('admin/company*') || request()->is('admin/locations*') || request()->is('admin/departments*') || request()->is('admin/department-heads*') || request()->is('license-types*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-users"></i>
                        <span>Employee Manage</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('admin/employees*') || request()->is('admin/units*') || request()->is('admin/company*') || request()->is('admin/locations*') || request()->is('admin/departments*') || request()->is('admin/department-heads*') || request()->is('license-types*') ? 'show' : '' }}">
                        <li class="{{ request()->is('admin/employees') || request()->is('admin/employees/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.employees.index') }}">
                                <i class="fas fa-list-alt"></i>
                                <span>Manage Employees</span>
                            </a>
                        </li>
                        @if(auth()->user()->can('unit-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('admin/units') || request()->is('admin/units/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.units.index') }}">
                                <i class="fas fa-building-o"></i>
                                <span>Unit Manage</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('company-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('admin/company') || request()->is('admin/company/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.company.index') }}">
                                <i class="fas fa-building"></i>
                                <span>Company List</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('location-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('admin/locations') || request()->is('admin/locations/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.locations.index') }}">
                                <i class="fas fa-map-marker"></i>
                                <span>Location Manage</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('department-manage') || $isSuperAdmin || $isAdmin || $isManager)
                        <li class="{{ request()->is('admin/departments') || request()->is('admin/departments/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.departments.index') }}">
                                <i class="fas fa-briefcase"></i>
                                <span>Departments</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('department-head-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('admin/department-heads') || request()->is('admin/department-heads/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.department-heads.index') }}">
                                <i class="fas fa-user-tie"></i>
                                <span>Department Heads</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('license-type-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('license-types') || request()->is('license-types/*') ? 'active' : '' }}">
                            <a href="{{ route('license-types.index') }}">
                                <i class="fas fa-certificate"></i>
                                <span>License Type Manage</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 7. Driver Manage --}}
                @if(auth()->user()->can('driver-manage') || $isSuperAdmin || $isAdmin || $isTransport)
                <li class="{{ request()->is('drivers') || request()->is('drivers/*') ? 'active' : '' }}">
                    <a href="{{ route('drivers.index') }}">
                        <i class="fas fa-id-card"></i>
                        <span>Driver Manage</span>
                    </a>
                </li>
                @endif

                {{-- 8. Vehicle Management --}}
                @if(auth()->user()->can('vehicle-manage') || $isSuperAdmin || $isAdmin || $isTransport)
                <li class="nav-parent {{ request()->is('vehicles*') || request()->is('vehicle-type*') || request()->is('vendors*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-truck"></i>
                        <span>Vehicle Management</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('vehicles*') || request()->is('vehicle-type*') || request()->is('vendors*') ? 'show' : '' }}">
                        <li class="{{ request()->is('vehicles') && !request()->is('vehicles/create') ? 'active' : '' }}">
                            <a href="{{ route('vehicles.index') }}">
                                <i class="fas fa-list"></i>
                                <span>Vehicle List</span>
                            </a>
                        </li>
                        @if(auth()->user()->can('vehicle-create') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('vehicles/create') ? 'active' : '' }}">
                            <a href="{{ route('vehicles.create') }}">
                                <i class="fas fa-plus"></i>
                                <span>Add Vehicle</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('maintenance-vendor-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('vendors') || request()->is('vendors/*') ? 'active' : '' }}">
                            <a href="{{ route('vendors.index') }}">
                                <i class="fas fa-store"></i>
                                <span>Vendor List</span>
                            </a>
                        </li>
                        @endif
                        <li class="{{ request()->is('vehicle-type') || request()->is('vehicle-type/*') ? 'active' : '' }}">
                            <a href="{{ route('vehicle-type.index') }}">
                                <i class="fas fa-list"></i>
                                <span>Vehicle Type List</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 9. Vehicle Maintenance --}}
                @if(auth()->user()->can('maintenance-manage') || $isSuperAdmin || $isAdmin || $isTransport)
                <li class="nav-parent {{ request()->is('maintenance*') || request()->is('maintenance-types*') || request()->is('maintenance-vendors*') || request()->is('maintenance-categories*') || request()->is('admin/maintenance*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-wrench"></i>
                        <span>Vehicle Maintenance</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('maintenance*') || request()->is('maintenance-types*') || request()->is('maintenance-vendors*') || request()->is('maintenance-categories*') || request()->is('admin/maintenance*') ? 'show' : '' }}">
                        <li class="{{ request()->is('maintenance') && !request()->is('maintenance/*') ? 'active' : '' }}">
                            <a href="{{ route('maintenance.index') }}">
                                <i class="fas fa-inbox"></i>
                                <span>Maintenance Requests</span>
                            </a>
                        </li>
                        @if(auth()->user()->can('maintenance-type-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('maintenance-types') || request()->is('maintenance-types/*') ? 'active' : '' }}">
                            <a href="{{ route('maintenance-types.index') }}">
                                <i class="fas fa-tag"></i>
                                <span>Maintenance Type</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('maintenance-vendor-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('maintenance-vendors') || request()->is('maintenance-vendors/*') ? 'active' : '' }}">
                            <a href="{{ route('maintenance-vendors.index') }}">
                                <i class="fas fa-building"></i>
                                <span>Maintenance Vendor</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('maintenance-category-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('maintenance-categories') || request()->is('maintenance-categories/*') ? 'active' : '' }}">
                            <a href="{{ route('maintenance-categories.index') }}">
                                <i class="fas fa-tags"></i>
                                <span>Maintenance Category</span>
                            </a>
                        </li>
                        @endif
                        <li class="{{ request()->is('admin/maintenance/history') ? 'active' : '' }}">
                            <a href="{{ route('admin-maintenance.history') }}">
                                <i class="fas fa-history"></i>
                                <span>Maintenance History</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 10. Vehicle Requisition --}}
                @if(auth()->user()->can('requisition-view') || $isSuperAdmin || $isAdmin || $isManager || $isTransport || $isEmployee)
                <li class="nav-parent {{ request()->is('requisitions*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-file-text-o"></i>
                        <span>Vehicle Requisition</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('requisitions*') ? 'show' : '' }}">
                        @if(auth()->user()->can('requisition-create') || $isSuperAdmin || $isAdmin || $isEmployee)
                        <li class="{{ request()->is('requisitions/create') ? 'active' : '' }}">
                            <a href="{{ route('requisitions.create') }}">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add Requisition</span>
                            </a>
                        </li>
                        @endif
                        <li class="{{ request()->is('requisitions') && !request()->is('requisitions/create') ? 'active' : '' }}">
                            <a href="{{ route('requisitions.index') }}">
                                <i class="fas fa-list"></i>
                                <span>My Requisitions</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 11. Department Approval --}}
                @if(auth()->user()->can('department-approval-view') || $isSuperAdmin || $isAdmin || $isManager)
                <li class="nav-parent {{ request()->is('department/approvals*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-building"></i>
                        <span>Department Approval</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('department/approvals*') ? 'show' : '' }}">
                        <li class="{{ request()->is('department/approvals') ? 'active' : '' }}">
                            <a href="{{ route('department.approvals.index') }}">
                                <i class="fas fa-list"></i>
                                <span>Pending Approvals</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 12. Transport Approval --}}
                @if(auth()->user()->can('transport-approval-view') || $isSuperAdmin || $isAdmin || $isTransport)
                <li class="nav-parent {{ request()->is('transport/approvals*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-truck"></i>
                        <span>Transport Approval</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('transport/approvals*') ? 'show' : '' }}">
                        <li class="{{ request()->is('transport/approvals') ? 'active' : '' }}">
                            <a href="{{ route('transport.approvals.index') }}">
                                <i class="fas fa-list"></i>
                                <span>Pending Approvals</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 13. Trip Sheets --}}
                @if(auth()->user()->can('trip-manage') || $isSuperAdmin || $isAdmin || $isTransport)
                <li class="nav-parent {{ request()->is('transport/trip-sheets*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-road"></i>
                        <span>Trip Sheets</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('transport/trip-sheets*') ? 'show' : '' }}">
                        <li class="{{ request()->is('transport/trip-sheets') || request()->is('transport/trip-sheets/*') ? 'active' : '' }}">
                            <a href="{{ route('trip-sheets.index') }}">
                                <i class="fas fa-list"></i>
                                <span>All Trips</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- 14. Subscription Plan --}}
                @if(auth()->user()->can('subscription-plan-manage') || $isSuperAdmin || $isAdmin)
                <li class="{{ request()->is('admin/plans*') ? 'active' : '' }}">
                    <a href="{{ route('admin.plans.index') }}">
                        <i class="fas fa-usd"></i>
                        <span>Subscription Plan</span>
                    </a>
                </li>
                @endif

                {{-- 15. SaaS Management --}}
                @if(auth()->user()->can('subscription-approve') || $isSuperAdmin || $isAdmin)
                <li class="nav-parent {{ request()->is('admin/payments*') || request()->is('admin/subscriptions*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-cloud"></i>
                        <span>SaaS Management</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('admin/payments*') || request()->is('admin/subscriptions*') ? 'show' : '' }}">
                        <li class="{{ request()->is('admin/plans') ? 'active' : '' }}">
                            <a href="{{ route('admin.plans.index') }}">
                                <i class="fas fa-credit-card"></i>
                                <span>Subscription Plans</span>
                            </a>
                        </li>
                        @if(auth()->user()->can('payment-view') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('admin/payments/pending') ? 'active' : '' }}">
                            <a href="{{ route('admin.payments.pending') }}">
                                <i class="fas fa-clock"></i>
                                <span>Pending Payments</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/payments/paid') ? 'active' : '' }}">
                            <a href="{{ route('admin.payments.paid') }}">
                                <i class="fas fa-check-circle"></i>
                                <span>Approved Payments</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 16. Reports --}}
                @if(auth()->user()->can('report-requisition') || auth()->user()->can('report-vehicle-utilization') || auth()->user()->can('report-driver-performance') || auth()->user()->can('report-trip-fuel') || auth()->user()->can('report-maintenance') || $isSuperAdmin || $isAdmin || $isManager || $isTransport)
                <li class="nav-parent {{ request()->is('admin/reports*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-list"></i>
                        <span>Reports</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('admin/reports*') ? 'show' : '' }}">
                        @if(auth()->user()->can('report-requisition') || $isSuperAdmin || $isAdmin || $isManager)
                        <li class="{{ request()->is('admin/reports/requisitions') ? 'active' : '' }}">
                            <a href="{{ route('reports.requisitions') }}">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Requisitions</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('report-vehicle-utilization') || $isSuperAdmin || $isAdmin || $isTransport)
                        <li class="{{ request()->is('admin/reports/vehicle-utilization') ? 'active' : '' }}">
                            <a href="{{ route('reports.vehicle_utilization') }}">
                                <i class="fas fa-car"></i>
                                <span>Vehicle Utilization</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('report-trip-fuel') || $isSuperAdmin || $isAdmin || $isTransport)
                        <li class="{{ request()->is('admin/reports/trips-fuel') ? 'active' : '' }}">
                            <a href="{{ route('reports.trips_fuel') }}">
                                <i class="fas fa-gas-pump"></i>
                                <span>Trips & Fuel</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('report-maintenance') || $isSuperAdmin || $isAdmin || $isTransport)
                        <li class="{{ request()->is('admin/reports/maintenance') ? 'active' : '' }}">
                            <a href="{{ route('reports.maintenance') }}">
                                <i class="fas fa-wrench"></i>
                                <span>Maintenance</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('report-driver-performance') || $isSuperAdmin || $isAdmin || $isTransport)
                        <li class="{{ request()->is('admin/reports/driver-performance') ? 'active' : '' }}">
                            <a href="{{ route('reports.driver_performance') }}">
                                <i class="fas fa-id-card"></i>
                                <span>Driver Performance</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 17. Email & Notification Settings --}}
                @if(auth()->user()->can('settings-notification') || auth()->user()->can('email-template-manage') || $isSuperAdmin || $isAdmin)
                <li class="nav-parent {{ request()->is('email-templates*') || request()->is('admin/notifications*') || request()->is('settings/notifications*') ? 'expanded active' : '' }}">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
                        <i class="fas fa-bell"></i>
                        <span>Email & Notifications</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>
                    <ul class="nav-children {{ request()->is('email-templates*') || request()->is('admin/notifications*') || request()->is('settings/notifications*') ? 'show' : '' }}">
                        @if(auth()->user()->can('email-template-manage') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('email-templates') || request()->is('email-templates/*') ? 'active' : '' }}">
                            <a href="{{ route('email-templates.index') }}">
                                <i class="fas fa-envelope"></i>
                                <span>Email Templates</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('settings-notification') || $isSuperAdmin || $isAdmin)
                        <li class="{{ request()->is('settings/notifications') || request()->is('admin/notifications*') ? 'active' : '' }}">
                            <a href="{{ route('settings.notifications') }}">
                                <i class="fas fa-cog"></i>
                                <span>Notification Settings</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>

<script>
    // Submenu Toggle
    function toggleSubmenu(element) {
        var parent = element.parentElement;
        parent.classList.toggle('expanded');
        var children = parent.querySelector('.nav-children');
        if (children) {
            children.classList.toggle('show');
        }
    }
    
    // Initialize sidebar states on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add expanded class to parents with visible children
        document.querySelectorAll('.nav-children.show').forEach(function(children) {
            children.parentElement.classList.add('expanded');
        });
    });
</script>
