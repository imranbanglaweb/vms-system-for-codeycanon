<?php

/**
 * ===============================================================================
 * VMS - Vehicle Management System Routes
 * ===============================================================================
 * 
 * This file defines all application routes organized by functional area.
 * Each section is clearly commented for easy navigation and maintenance.
 * 
 * Route Structure:
 * 1. Authentication Routes (Laravel Auth scaffolding)
 * 2. Dashboard & Home
 * 3. Vehicle Management
 * 4. Driver Management
 * 5. Vendor Management
 * 6. Requisitions & Approvals
 * 7. Transport Approval Workflow
 * 8. Trip Sheet Operations
 * 9. Maintenance Management
 * 10. Maintenance Schedule
 * 11. Maintenance Types & Vendors
 * 12. Reports (Requisitions, Trips, Vehicles, Drivers, Maintenance)
 * 13. Subscriptions & Plans
 * 14. Payments (Manual & Stripe)
 * 15. Admin Controls & Settings
 * 16. Organization Setup (Units, Companies, Departments, Locations)
 * 17. Employee & User Management
 * 18. Permissions & Roles
 * 19. Push Notifications
 * 20. Documents Management
 * 21. Languages & Localization
 * 22. Miscellaneous Routes
 * ===============================================================================
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// ============================================================================
// CONTROLLER IMPORTS
// ============================================================================

// Core Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;

// Vehicle & Transport
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\TripSheetController;

// Requisitions & Approvals
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\RequisitionApprovalController;
use App\Http\Controllers\DepartmentApprovalController;
use App\Http\Controllers\TransportApprovalController;

// Maintenance
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceTypeController;
use App\Http\Controllers\MaintenanceVendorController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\MaintenanceRequisitionController;
use App\Http\Controllers\MaintenanceCategoryController;

// Reports
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Reports\RequisitionReportController;
use App\Http\Controllers\Reports\MaintenanceReportController;
use App\Http\Controllers\Reports\TripFuelReportController;
use App\Http\Controllers\Reports\VehicleUtilizationReportController;
use App\Http\Controllers\Reports\DriverPerformanceReportController;

// Admin & Settings
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushSubscriptionController;

// Subscriptions & Payments
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionApprovalController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\ManualPaymentController;
use App\Http\Controllers\Admin\PushTestController;

// Organization Structure
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

// Admin Features
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\LandController;
use App\Http\Controllers\Admin\DocumentTypeController;
use App\Http\Controllers\Admin\DocumentHistoryController;

// Other Controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LicneseTypeController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\EmailLogController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\TestEmailController;

use App\Notifications\TestPushNotification;
Route::resource('emaillogs', EmailLogController::class);

// ============================================================================
// EMAIL TEMPLATES ROUTES
// ============================================================================
Route::middleware(['auth'])->group(function () {
    Route::resource('email-templates', EmailTemplateController::class);
    Route::post('email-templates/toggle-status', [EmailTemplateController::class, 'toggleStatus'])->name('email-templates.toggle-status');
    Route::post('email-templates/{id}/restore', [EmailTemplateController::class, 'restore'])->name('email-templates.restore');
    
    // Test Email Routes
    Route::get('email/test', [TestEmailController::class, 'index'])->name('admin.email.test');
    Route::post('email/test/send', [TestEmailController::class, 'send'])->name('admin.email.test.send');
});

// ============================================================================
// 1. AUTHENTICATION ROUTES
// ============================================================================

Auth::routes();

// ============================================================================
// 2. DASHBOARD & HOME
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::redirect('/', 'login');
    
    // Home & Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // AJAX endpoints for dashboard
    Route::get('/admin/dashboard/data', [HomeController::class, 'data'])->name('admin.dashboard.data');
    Route::get('/dashboard/recent-documents', [HomeController::class, 'getRecentDocuments'])->name('dashboard.recent-documents');
    Route::get('/dashboard/pending-approvals', [HomeController::class, 'getPendingApprovals'])->name('dashboard.pending-approvals');
});

// ============================================================================
// 3. VEHICLE MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::resource('vehicle-type', VehicleTypeController::class);
    Route::resource('vehicles', VehicleController::class);

});

// ============================================================================
// 4. DRIVER MANAGEMENT
// ============================================================================

Route::middleware(['prevent-back-history'])->group(function () {
    // DataTable AJAX endpoint
    Route::get('drivers/data', [DriverController::class, 'data'])->name('drivers.data');
    Route::get('drivers/list', [DriverController::class, 'list'])->name('drivers.list');
    
    // CRUD operations
    Route::resource('drivers', DriverController::class);
    
    // AJAX helpers
    Route::get('/get-departments-by-unit', [DriverController::class, 'getDepartmentsByUnit'])->name('getDepartmentsByUnit');
    Route::get('/get-employee-info', [DriverController::class, 'getEmployeeInfo'])->name('getEmployeeInfo');
});

// ============================================================================
// 5. VENDOR MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::resource('vendors', VendorController::class);
});

// ============================================================================
// 6. REQUISITIONS & APPROVALS
// ============================================================================

Route::middleware(['prevent-back-history'])->group(function () {
    
    
    // AJAX endpoints
    Route::get('/requisitions-search', [RequisitionController::class, 'index'])->name('requisitions.search');
    Route::post('/requisitions/validate', [RequisitionController::class, 'validateAjax'])->name('requisitions.validate');
    Route::get('/get-employee-details/{id}', [EmployeeController::class, 'getEmployeeDetails'])->name('employee.details');
    
    // Export options
    Route::get('/requisitions/{id}/download', [RequisitionController::class, 'downloadPDF'])->name('requisitions.download');
    Route::get('/requisitions/export-excel', [RequisitionController::class, 'exportExcel'])->name('requisitions.export.excel');
    Route::get('/requisitions/export-pdf', [RequisitionController::class, 'exportPDF'])->name('requisitions.export.pdf');
    Route::get('/get-drivers-by-vehicle/{vehicleId}', [RequisitionController::class, 'getDriversByVehicle']);
Route::get('/requisitions/vehicles/by-capacity', [RequisitionController::class, 'getVehiclesByCapacity'])->name('vehicles.by.capacity');


Route::get('/employee/details/{id}', [EmployeeController::class, 'details'])->name('employee.details');

Route::get('/vehicles/by-capacity', [VehicleController::class, 'byCapacity'])->name('vehicles.by.capacity');

Route::get('/vehicles/{id}/details', [VehicleController::class, 'getVehicleDetails'])->name('vehicles.details');

Route::get('/drivers/by-vehicle/{vehicle}', [DriverController::class, 'getByVehicle'])
    ->name('drivers.by.vehicle');
   
Route::resource('requisitions', RequisitionController::class);
    
    // Status & Workflow
    Route::post('/requisitions/update-status/{id}', [RequisitionController::class, 'updateStatus'])->name('requisitions.updateStatus');
    Route::post('{id}/workflow/update', [RequisitionController::class, 'updateWorkflow'])->name('requisitions.workflow.update');
    Route::post('requisitions/{id}/workflow/update', [RequisitionController::class, 'updateWorkflow'])
        ->middleware('auth', 'role:transport,admin')->name('requisitions.workflow.update');
    
    // Transport Approval
    Route::post('/requisitions/transport-approve/{id}', [RequisitionApprovalController::class, 'transportApprove'])->name('requisitions.transport.approve');
    Route::post('/requisitions/transport-reject/{id}', [RequisitionApprovalController::class, 'transportReject'])->name('requisitions.transport.reject');
    
    // Admin Final Approval
    Route::post('/requisitions/admin-approve/{id}', [RequisitionApprovalController::class, 'adminApprove'])->name('requisitions.admin.approve');
    Route::post('/requisitions/admin-reject/{id}', [RequisitionApprovalController::class, 'adminReject'])->name('requisitions.admin.reject');
    
    // Role-based requisition access
    Route::group(['middleware' => 'role:employee,transport,admin'], function() {
        Route::resource('requisitions', RequisitionController::class);
    });
});

// ============================================================================
// 7. DEPARTMENT APPROVAL WORKFLOW
// ============================================================================

Route::prefix('department')->group(function () {
    // AJAX endpoint
    Route::get('/approvals/ajax', [DepartmentApprovalController::class, 'ajax'])->name('department.approvals.ajax');
    
    // Department Head Approvals
    Route::get('/approvals', [DepartmentApprovalController::class, 'index'])->name('department.approvals.index');
    Route::get('/approvals/{id}', [DepartmentApprovalController::class, 'show'])->name('department.approvals.show');
    Route::post('/approvals/{id}/approve', [DepartmentApprovalController::class, 'approve'])->name('department.approvals.approve');
    Route::post('/approvals/{id}/reject', [DepartmentApprovalController::class, 'reject'])->name('department.approvals.reject');
});

// ============================================================================
// 8. TRANSPORT APPROVAL WORKFLOW & TRIP SHEETS
// ============================================================================

Route::prefix('transport')->group(function () {
    // Transport Approvals
    Route::get('/approvals', [TransportApprovalController::class, 'index'])->name('transport.approvals.index');
    Route::get('/approvals/ajax', [TransportApprovalController::class, 'ajax'])->name('transport.approvals.ajax');
    Route::get('/approvals/{id}', [TransportApprovalController::class, 'show'])->name('transport.approvals.show');
    Route::post('/approvals/{id}/assign', [TransportApprovalController::class, 'assignVehicleDriver'])->name('transport.approvals.assign');
    Route::post('/approvals/{id}/approve', [TransportApprovalController::class, 'approve'])->name('transport.approvals.approve');
    Route::post('/approvals/{id}/reject', [TransportApprovalController::class, 'reject'])->name('transport.approvals.reject');
    Route::get('/approvals/{id}/availability', [TransportApprovalController::class, 'availability'])->name('transport.approvals.availability');
    Route::get('/approvals/{id}/vehicle/{vehicleId}/drivers', [TransportApprovalController::class, 'getDriversForVehicle'])->name('transport.approvals.drivers-for-vehicle');
    
    // Trip Sheets
    Route::get('/trip-sheets', [TripSheetController::class, 'index'])->name('trip-sheets.index');
    Route::get('/trip-sheets/data', [TripSheetController::class, 'getData'])->name('trip-sheets.data');
    Route::get('/trip-sheet/{id}', [TripSheetController::class, 'show'])->name('trip-sheets.show');
    Route::post('/trip-sheet/start/{id}', [TripSheetController::class, 'startTrip'])->name('trip-sheets.start');
    Route::post('/trip-sheet/finish/{id}', [TripSheetController::class, 'finishTrip'])->name('trip-sheets.finish');
    Route::get('/trip-sheet/end/{id}', [TripSheetController::class, 'endTripForm'])->name('trip.end.form');
    Route::post('/trip-sheet/end/{id}', [TripSheetController::class, 'endTripSave'])->name('trip.end.save');
});

// ============================================================================
// 9. MAINTENANCE MANAGEMENT
// ============================================================================

Route::get('admin/maintenance/history', [MaintenanceRequisitionController::class, 'history'])->name('admin-maintenance.history');
Route::resource('maintenance', MaintenanceRequisitionController::class);

// ============================================================================
// 10. MAINTENANCE SCHEDULE
// ============================================================================

Route::prefix('maintenance-schedule')->middleware('auth')->group(function () {
    Route::get('/', [MaintenanceController::class, 'index'])->name('maintenance-schedules.index');
    Route::get('/create', [MaintenanceController::class, 'create'])->name('maintenance-schedule.create');
    Route::post('/store', [MaintenanceController::class, 'storeSchedule'])->name('maintenance-schedule.store');
    Route::get('/record/{id}', [MaintenanceController::class, 'recordForm'])->name('maintenance.record.form');
    Route::post('/record/{id}', [MaintenanceController::class, 'recordMaintenance'])->name('maintenance.record');
    Route::post('/schedule/{id}/deactivate', [MaintenanceController::class, 'markScheduleInactive'])->name('maintenance.schedule.deactivate');
    Route::get('/due/list', [MaintenanceController::class, 'dueList'])->name('maintenance.due.list');
});

// ============================================================================
// 11. MAINTENANCE TYPES, VENDORS & SCHEDULES
// ============================================================================

Route::prefix('maintenance-types')->middleware('auth')->group(function () {
    Route::get('/', [MaintenanceTypeController::class, 'index'])->name('maintenance-types.index');
    Route::post('/store', [MaintenanceTypeController::class, 'store'])->name('maintenance-types.store');
    Route::get('/edit/{maintenanceType}', [MaintenanceTypeController::class, 'edit'])->name('maintenance-types.edit');
    Route::put('/update/{maintenanceType}', [MaintenanceTypeController::class, 'update'])->name('maintenance-types.update');
    Route::delete('/delete/{maintenanceType}', [MaintenanceTypeController::class, 'destroy'])->name('maintenance-types.destroy');
    Route::get('maintenance-types-data', [MaintenanceTypeController::class, 'data'])->name('maintenance.types.data');
});

Route::prefix('maintenance-vendors')->middleware('auth')->group(function () {
    Route::get('/', [MaintenanceVendorController::class, 'index'])->name('maintenance-vendors.index');
    Route::post('/store', [MaintenanceVendorController::class, 'store'])->name('maintenance.vendors.store');
    Route::get('/edit/{vendor}', [MaintenanceVendorController::class, 'edit'])->name('maintenance.vendors.edit');
    Route::post('/update/{vendor}', [MaintenanceVendorController::class, 'update'])->name('maintenance.vendors.update');
    Route::delete('/delete/{vendor}', [MaintenanceVendorController::class, 'destroy'])->name('maintenance.vendors.destroy');
});

Route::prefix('maintenance-schedules')->middleware('auth')->group(function () {
    Route::get('/', [MaintenanceScheduleController::class, 'index'])->name('maintenance.schedules.index');
    Route::get('/create', [MaintenanceScheduleController::class, 'create'])->name('maintenance.schedules.create');
    Route::post('/store', [MaintenanceScheduleController::class, 'store'])->name('maintenance.schedules.store');
    Route::get('/edit/{schedule}', [MaintenanceScheduleController::class, 'edit'])->name('maintenance-schedules.edit');
    Route::post('/update/{schedule}', [MaintenanceScheduleController::class, 'update'])->name('maintenance.schedules.update');
    Route::delete('/delete/{schedule}', [MaintenanceScheduleController::class, 'destroy'])->name('maintenance-schedules.destroy');
    Route::get('/{id}', [MaintenanceScheduleController::class, 'show'])->name('maintenance-schedules.show');
    Route::post('maintenance-schedules/toggle-active/{id}', [MaintenanceScheduleController::class, 'toggleActive'])->name('maintenance-schedules.toggleActive');
    Route::get('maintenance-schedules/server/load', [MaintenanceScheduleController::class, 'server'])->name('maintenance.schedules.server');
});

Route::prefix('maintenance-categories')->group(function () {
    Route::get('/', [MaintenanceCategoryController::class, 'index'])->name('maintenance-categories.index');
    Route::post('/', [MaintenanceCategoryController::class, 'store'])->name('maintenance-categories.store');
    Route::get('/{id}/edit', [MaintenanceCategoryController::class, 'edit'])->name('maintenance-categories.edit');
    Route::delete('/{id}', [MaintenanceCategoryController::class, 'destroy'])->name('maintenance-categories.destroy');
});

// ============================================================================
// 12. REPORTS
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Requisition Reports
    Route::get('requisitions', [RequisitionReportController::class, 'index'])->name('reports.requisitions');
    Route::get('requisitions/excel', [RequisitionReportController::class, 'exportExcel'])->name('reports.requisitions.excel');
    Route::get('requisitions/pdf', [RequisitionReportController::class, 'exportPdf'])->name('reports.requisitions.pdf');
});

// Trip & Fuel Consumption Report
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/trips-fuel', [TripFuelReportController::class, 'index'])->name('trips_fuel');
    Route::get('/reports/trips-fuel/ajax', [TripFuelReportController::class, 'ajax'])->name('trips_fuel.ajax');
    Route::get('/reports/trips-fuel/excel', [TripFuelReportController::class, 'excel'])->middleware('role:Super Admin,Admin')->name('trips_fuel.excel');
    Route::get('/reports/trips-fuel/pdf', [TripFuelReportController::class, 'pdf'])->middleware('role:Super Admin,Admin')->name('trips_fuel.pdf');
});

// Vehicle Utilization Report
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/vehicle-utilization', [VehicleUtilizationReportController::class, 'index'])->name('vehicle_utilization');
    Route::get('/reports/vehicle-utilization/ajax', [VehicleUtilizationReportController::class, 'ajax'])->name('vehicle_utilization.ajax');
    Route::get('/reports/vehicle-utilization/excel', [VehicleUtilizationReportController::class, 'excel'])->middleware('role:Super Admin,Admin')->name('vehicle_utilization.excel');
    Route::get('/reports/vehicle-utilization/pdf', [VehicleUtilizationReportController::class, 'pdf'])->middleware('role:Super Admin,Admin')->name('vehicle_utilization.pdf');
});

// Driver Performance Report
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/driver-performance', [DriverPerformanceReportController::class, 'index'])->name('driver_performance');
    Route::get('/reports/driver-performance/ajax', [DriverPerformanceReportController::class, 'ajax'])->name('driver_performance.ajax');
    Route::get('/reports/driver-performance/excel', [DriverPerformanceReportController::class, 'excel'])->middleware('role:Super Admin,Admin')->name('driver_performance.excel');
    Route::get('/reports/driver-performance/pdf', [DriverPerformanceReportController::class, 'pdf'])->middleware('role:Super Admin,Admin')->name('driver_performance.pdf');
});

// Maintenance Reports
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/maintenance', [MaintenanceReportController::class, 'index'])->name('maintenance');
    Route::get('/reports/maintenance/ajax', [MaintenanceReportController::class, 'ajax'])->name('maintenance.ajax');
    Route::get('/reports/maintenance/excel', [MaintenanceReportController::class, 'excel'])->middleware('role:Super Admin,Admin')->name('maintenance.excel');
    Route::get('/reports/maintenance/pdf', [MaintenanceReportController::class, 'pdf'])->middleware('role:Super Admin,Admin')->name('maintenance.pdf');
});
// ============================================================================
// 13. SUBSCRIPTIONS & PLANS
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('plans', SubscriptionPlanController::class)->except(['show', 'destroy']);
});

// Pricing page
Route::get('/pricing', [SubscriptionPlanController::class, 'price'])->name('pricing');

// Subscription Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe/{slug}', [SubscriptionController::class, 'select'])->name('subscription.select');
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/subscription-expired', [SubscriptionController::class, 'expired'])->name('subscription.expired');
});

// Subscription check for features
Route::middleware(['auth', 'subscription.active'])->group(function () {
    Route::resource('trips', TripSheetController::class);
});

// ============================================================================
// 14. PAYMENTS (MANUAL & STRIPE)
// ============================================================================

Route::middleware(['auth'])->group(function () {
        // Stripe
    // Route::post('/stripe/pay', [StripeController::class,'pay'])
    //     ->name('stripe.pay');

    Route::get('/payment/stripe', [StripeController::class,'pay'])
    ->name('payment.stripe');
    
    // Manual Payment
    Route::get('/payment/manual/{plan}', [ManualPaymentController::class, 'form'])->name('payment.manual');
    Route::post('/manual-payment/ajax-store', [ManualPaymentController::class, 'ajaxStore'])->name('manual.payment.ajax');
    Route::post('/manual-payment/store', [ManualPaymentController::class, 'store']);
    
    // Invoices
    Route::get('/invoice/{payment}', [ManualPaymentController::class, 'invoice'])->name('invoice.download');
    Route::get('/admin/payments/{payment}/invoice', [ManualPaymentController::class, 'invoice'])->name('admin.payments.invoice');
    
    // Stripe
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
});

// ============================================================================
// 15. ADMIN CONTROLS & PAYMENTS
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Payment Management
    Route::get('payments/pending', [AdminPaymentController::class, 'pending'])->name('payments.pending');
    Route::get('payments/paid', [AdminPaymentController::class, 'paid'])->name('payments.paid');
    Route::get('admin/payments/paid/data', [AdminPaymentController::class, 'paidData'])->name('payments.paid.data');
    Route::post('/payments/approve/{payment}', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/reject/{payment}', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/subscriptions/expiring', [AdminPaymentController::class, 'expiring']);
    Route::get('/revenue/plans', [AdminPaymentController::class, 'byPlan']);
});

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/subscriptions/pending', [SubscriptionApprovalController::class, 'pending']);
    Route::post('/subscriptions/approve/{payment}', [SubscriptionApprovalController::class, 'approve']);
});

// ============================================================================
// 16. ORGANIZATION SETUP
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Units
    Route::get('units/data', [UnitController::class, 'data'])->name('units.data');
    Route::get('units/list', [UnitController::class, 'list'])->name('units.list');
    Route::resource('units', UnitController::class);
    
    // Companies
    Route::get('company/data', [CompanyController::class, 'data'])->name('company.data');
    Route::resource('company', CompanyController::class);
    
    // Departments
    Route::get('departments/data', [DepartmentController::class, 'data'])->name('departments.data');
    Route::get('departments/list', [DepartmentController::class, 'list'])->name('departments.list');
    Route::resource('departments', DepartmentController::class);
    Route::get('departments/{id}/head-info', [DepartmentController::class, 'getHeadInfo'])->name('departments.head-info');
    Route::get('unit-wise-department', [DepartmentController::class, 'unitWiseDepartment'])->name('unit-wise-department');
    
    // Department Heads Management
    Route::get('department-heads', [DepartmentHeadController::class, 'index'])->name('department-heads.index');
    Route::post('department-heads', [DepartmentHeadController::class, 'store'])->name('department-heads.store');
    Route::post('department-heads/send-notification', [DepartmentHeadController::class, 'sendNotification'])->name('department-heads.send-notification');
    Route::delete('department-heads/remove', [DepartmentHeadController::class, 'remove'])->name('department-heads.remove');
    Route::get('department-heads/employees/{departmentId}', [DepartmentHeadController::class, 'getEmployeesByDepartment'])->name('department-heads.employees');
    
    // Locations
    Route::get('locations/data', [LocationController::class, 'data'])->name('locations.data');
    Route::get('locations/list', [LocationController::class, 'list'])->name('locations.list');
    Route::resource('locations', LocationController::class);
});

// ============================================================================
// 17. EMPLOYEE & USER MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Employees
    Route::resource('employees', EmployeeController::class);
    Route::post('import', [EmployeeController::class, 'import'])->name('employee.import');
    Route::post('importuser', [EmployeeController::class, 'importuser'])->name('employee.importuser');
    Route::post('employee/importuser', [UserController::class, 'importUser'])->name('employee.importuser');
    Route::post('employee/export', [UserController::class, 'exportUser'])->name('employee.export');
    
    // Users
    Route::get('users/getData', [UserController::class, 'getData'])->name('users.getData');
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('users', UserController::class);
    // Route::resource('users', UserController::class)->except(['show']);

    Route::post('users/validate', [UserController::class, 'validateUser'])->name('users.validate');
    Route::post('users/ajaxSubmit', [UserController::class, 'ajaxSubmit'])->name('users.ajaxSubmit');
    
    // Get employee details for auto-populate
    Route::get('users/employee-details/{employeeId}', [UserController::class, 'getEmployeeDetails'])->name('users.get-employee-details');
    
    // User Profile
    Route::get('user-profile', [UserController::class, 'userprofile'])->name('user-profile');
    Route::post('profile-update', [UserController::class, 'updateProfile'])->name('profile-update');
    Route::post('profile-password-update', [UserController::class, 'profilepasswordupdate'])->name('profile-password-update');
});

// ============================================================================
// 18. PERMISSIONS & ROLES
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Roles
    Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::resource('roles', RoleController::class);
    Route::post('roles/{id}/duplicate', [RoleController::class, 'duplicate'])
    ->name('roles.duplicate');
    // Permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/list', [PermissionController::class, 'list'])->name('permissions.list');
    Route::post('/permissions/validate', [PermissionController::class, 'validatePermission'])->name('permissions.validate');
    
    Route::resource('permissions', PermissionController::class);
});

// ============================================================================
// 19. PUSH NOTIFICATIONS
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::post('push-subscribe', [PushSubscriptionController::class, 'store'])->name('push.subscribe');
    Route::post('push-unsubscribe', [PushSubscriptionController::class, 'destroy'])->name('push.unsubscribe');
    Route::get('/admin/push-subscribers', [PushSubscriptionController::class, 'index'])->name('admin.push.subscribers');
    Route::get('/settings/notifications', [SettingController::class, 'notification'])->name('settings.notifications');
    
    // Test Push Notification
    Route::get('/test-push', function () {
        auth()->user()->notify(new \App\Notifications\RequisitionCreated());
        return 'Push Sent';
    });

    Route::post('/admin/push/test', [PushTestController::class, 'send'])->name('admin.push.test');

});

// Notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('admin.notifications.unread');
    Route::get('/admin/notifications/unread-count', function () {
        return response()->json(['count' => \App\Models\Notification::where('user_id', auth()->id())->where('is_read', 0)->count()]);
    })->name('notifications.unread');
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.all');
});

// ============================================================================
// 20. DOCUMENTS MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::resource('documents', DocumentController::class);
    
    // Document Operations
    Route::group(['prefix' => 'documents'], function () {
        Route::get('/{document}/show', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::post('/{document}/approve', [DocumentController::class, 'approve'])->name('documents.approve');
        Route::post('/{document}/reject', [DocumentController::class, 'reject'])->name('documents.reject');
    });
    
    // Document Approval
    Route::get('documents/pending-approval', [DocumentController::class, 'pendingApproval'])->name('documents.pending-approval');
    Route::get('documents/{id}/return-modal', [DocumentController::class, 'showReturnModal'])->name('documents.return-modal');
    Route::post('documents/{id}/return', [DocumentController::class, 'returnDocument'])->name('documents.return');
});

// ============================================================================
// 21. LANGUAGES & LOCALIZATION
// ============================================================================

Route::middleware(['auth'])->prefix('Super Admin')->group(function () {
    Route::post('/language/switch', [LanguageController::class, 'switch'])->name('admin.language.switch');
    Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');
    Route::get('/language/list', [LanguageController::class, 'list'])->name('language.list');
    
    Route::get('/translations', [TranslationController::class, 'index'])->name('admin.translations');
    Route::post('/translations', [TranslationController::class, 'store'])->name('translations.store');
    Route::post('/translations/update', [TranslationController::class, 'update'])->name('translations.update');
    Route::post('/translations/auto-translate', [TranslationController::class, 'autoTranslate'])->name('admin.translations.auto');
    Route::get('translations/ajax', [TranslationController::class, 'ajaxTranslations'])->name('admin.translations.ajax');
    Route::post('translations/create', [TranslationController::class, 'store'])->name('translations.create');
});

// ============================================================================
// 22. MISCELLANEOUS ROUTES
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Projects & Lands
    Route::resource('projects', ProjectController::class);
    Route::resource('lands', LandController::class);
    
    // License Types
    Route::get('license-types/data', [LicneseTypeController::class, 'data'])->name('license-types.data');
    Route::resource('license-types', LicneseTypeController::class);
    
    // Categories
    if (class_exists(\App\Http\Controllers\CategoryController::class)) {
        Route::resource('categories', CategoryController::class);
    }
    Route::post('import-category', [CategoryController::class, 'import'])->name('category.import-category');
    
    // Settings & Configuration
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/store', [SettingController::class, 'store'])->name('settings.store');
    Route::get('settings/languages', [SettingController::class, 'loadLanguages'])->name('settings.languages');
    Route::post('admin/language/clear-cache', [SettingController::class, 'clearTranslationCache'])->name('admin.language.clear-cache');
    Route::post('admin/mail/clear-cache', [SettingController::class, 'clearMailConfigCache'])->name('admin.mail.clear-cache');
    Route::post('admin/language/sync', [SettingController::class, 'syncLanguages'])->name('admin.language.sync');
    
    // Menus
    Route::resource('menus', MenuController::class);
    Route::post('menus/reorder', [MenuController::class, 'menuoder'])->name('menus.reorder');
    
    // Import/Export
    Route::post('import-task', [SupportController::class, 'import'])->name('import-task.import');
    Route::post('sample_import-file', [SupportController::class, 'importexcelfile'])->name('support.sample_import-file');
});

// ============================================================================
// END OF ROUTES FILE
// ============================================================================
