<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', config('app.name', 'InayaFleet360'))</title>
    @include('admin.dashboard.common.header')
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Premium Dashboard CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --secondary-color: #0ea5e9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --header-height: 64px;
            --transition-speed: 0.3s;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        /* Preloader Styles */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4f46e5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        
        .preloader.fade-out {
            opacity: 0;
            visibility: hidden;
        }
        
        .preloader-content {
            text-align: center;
            color: #fff;
        }
        
        .preloader-spinner {
            width: 80px;
            height: 80px;
            border: 3px solid rgba(255, 255, 255, 0.2);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .preloader-brand {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .preloader-tagline {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            opacity: 0.8;
        }
        
        /* Wrapper Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar-left {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: width var(--transition-speed) ease;
            overflow: hidden;
        }
        
        .sidebar-left.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }
        
        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .sidebar-brand-text {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            
        }
        
        .sidebar-toggle {
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            color: #fff;
        }
        
        .sidebar-nav {
            padding: 15px 0;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }
        
        .nav-main {
            list-style: none;
        }
        
        .nav-main li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 12px;
            border-left: 3px solid transparent;
        }
        
        .nav-main li a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left-color: var(--primary-color);
        }
        
        .nav-main li.active > a {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.2), transparent);
            color: #fff;
            border-left-color: var(--primary-color);
        }
        
        .nav-main li a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .nav-children {
            list-style: none;
            background: rgba(0, 0, 0, 0.2);
            padding-left: 20px;
        }
        
        .nav-children li a {
            padding-left: 52px;
            font-size: 14px;
        }
        
        /* Content Wrapper */
        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
            width: auto;
            transition: all var(--transition-speed) ease;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        .sidebar-left.collapsed ~ .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Wrapper */
        .wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Sidebar - ensure it doesn't shrink */
        .sidebar-left {
            flex-shrink: 0;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        
        /* Inner Page Container - Full Width */
        .main-content .page-content,
        .main-content .inner-page {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box;
            margin: -20px !important;
            padding: 0 !important;
        }
        
        .main-content .card,
        .main-content .table-responsive {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }
        
        /* Container fix for inner pages */
        .main-content .container,
        .main-content .container-fluid,
        .main-content .row {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .main-content .col,
        .main-content .col-1,
        .main-content .col-2,
        .main-content .col-3,
        .main-content .col-4,
        .main-content .col-5,
        .main-content .col-6,
        .main-content .col-7,
        .main-content .col-8,
        .main-content .col-9,
        .main-content .col-10,
        .main-content .col-11,
        .main-content .col-12 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding: 10px !important;
            box-sizing: border-box;
        }
        
        /* Force full width for any form content */
        .main-content form,
        .main-content .form-group,
        .main-content .form-row,
        .main-content .form-inline {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .main-content input[type="text"],
        .main-content input[type="email"],
        .main-content input[type="password"],
        .main-content input[type="number"],
        .main-content input[type="date"],
        .main-content select,
        .main-content textarea {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Bootstrap utility overrides */
        .main-content .p-0,
        .main-content .p-1,
        .main-content .p-2,
        .main-content .p-3,
        .main-content .p-4,
        .main-content .p-5 {
            padding: 0 !important;
        }
        
        .main-content .m-0,
        .main-content .m-1,
        .main-content .m-2,
        .main-content .m-3,
        .main-content .m-4,
        .main-content .m-5 {
            margin: 0 !important;
        }
    
    /* Dashboard Specific */
    .main-content .dashboard-container {
        padding: 0;
    }
    
    /* Bootstrap Utility Classes */
    
    /* Stats Cards */
    .stats-row .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stats-row .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }
    
    .stat-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    
    .stat-card-primary .stat-card-icon {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
    }
    
    .stat-card-warning .stat-card-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }
    
    .stat-card-success .stat-card-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }
    
    .stat-card-danger .stat-card-icon {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }
    
    .stat-card-info .stat-card-icon {
        background: rgba(14, 165, 233, 0.1);
        color: var(--info-color);
    }
    
    .stat-card-secondary .stat-card-icon {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
    }
    
    .stat-card-content {
        flex: 1;
        min-width: 0;
    }
    
    .stat-label {
        display: block;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 4px;
        font-weight: 500;
    }
    
    .stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }
    
    .stat-trend {
        display: block;
        font-size: 12px;
        margin-top: 4px;
    }
    
    .stat-trend-up { color: var(--success-color); }
    .stat-trend-down { color: var(--danger-color); }
    .stat-trend-neutral { color: #64748b; }
    
    /* Dashboard Cards */
    .dashboard-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        height: 100%;
        overflow: hidden;
    }
    
    .dashboard-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    
    .dashboard-card-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .dashboard-card-title i { color: var(--primary-color); }
    
    .dashboard-card-body { padding: 20px; }
    
    .card-action-link {
        font-size: 13px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
    
    .card-action-link:hover { text-decoration: underline; }
    
    /* Activity List */
    .activity-list { max-height: 320px; overflow-y: auto; }
    
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s ease;
    }
    
    .activity-item:last-child { border-bottom: none; }
    
    .activity-item:hover { background: #fafbfc; }
    
    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    .activity-icon-success { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
    .activity-icon-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
    .activity-icon-info { background: rgba(14, 165, 233, 0.1); color: var(--info-color); }
    .activity-icon-primary { background: rgba(79, 70, 229, 0.1); color: var(--primary-color); }
    
    .activity-content { flex: 1; min-width: 0; }
    
    .activity-text {
        font-size: 14px;
        color: #1e293b;
        margin: 0 0 4px 0;
        line-height: 1.4;
    }
    
    .activity-time { font-size: 12px; color: #94a3b8; }
    
    /* Quick Actions */
    .quick-actions-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    
    .quick-action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    
    .quick-action-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        background: #fff;
    }
    
    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        margin-bottom: 12px;
    }
    
    .quick-action-item span {
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
        text-align: center;
    }
    
    /* Table Styles */
    .table { margin: 0; }
    
    .table thead th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 16px;
    }
    
    .table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: #1e293b;
        vertical-align: middle;
    }
    
    .table tbody tr:hover { background: #fafbfc; }
    
    .badge {
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 6px;
    }
    
    .badge-primary { background: rgba(79, 70, 229, 0.1); color: var(--primary-color); }
    .badge-success { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
    .badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger-color); }
    .badge-info { background: rgba(14, 165, 233, 0.1); color: var(--info-color); }
    
    /* Alert Styles */
    .alert { border-radius: 10px; border: none; }
    
    .alert-primary { background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.15)); color: var(--primary-color); }
    .alert-info { background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(6, 182, 212, 0.15)); color: #0891b2; }
    .alert-warning { background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.15)); color: #d97706; }
    .alert-success { background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.15)); color: #059669; }
    
    .alert-role i:first-child { font-size: 24px; }
    
    /* Header Styles */
        .main-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 999;
            transition: left var(--transition-speed) ease;
        }
        
        .sidebar-left.collapsed ~ .main-header {
            left: var(--sidebar-collapsed-width);
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        /* Menu Toggle Button in Header */
        .header-menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.3s ease;
        }
        
        .header-menu-toggle:hover {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }
        
        @media (max-width: 991px) {
            .header-menu-toggle {
                display: flex;
            }
        }
        
        .header-search {
            position: relative;
        }
        
        .header-search input {
            width: 320px;
            padding: 10px 16px 10px 44px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            background: #f8fafc;
            transition: all 0.3s ease;
        }
        
        .header-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: #fff;
        }
        
        .header-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .header-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: none;
            background: #f8fafc;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .header-icon-btn:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
        }
        
        .header-icon-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 20px;
            height: 20px;
            background: var(--danger-color);
            color: #fff;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
            border-radius: 10px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .header-icon-btn:hover {
            background: var(--primary-color);
            color: #fff;
        }
        
        .header-icon-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: var(--danger-color);
            color: #fff;
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        
        .user-dropdown:hover {
            background: #f1f5f9;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-info {
            text-align: left;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--dark-color);
        }
        
        .user-role {
            font-size: 12px;
            color: #64748b;
        }
        
        /* Main Content */
        .main-content {
            padding: 24px;
        }
        
        /* Page Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .page-title i {
            margin-right: 12px;
            color: var(--primary-color);
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #64748b;
        }
        
        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* Card Styles */
        .card {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .card-body {
            padding: 24px;
        }
        
        /* Stats Cards */
        .stats-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stats-icon.primary {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.2));
            color: var(--primary-color);
        }
        
        .stats-icon.success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.2));
            color: var(--success-color);
        }
        
        .stats-icon.warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.2));
            color: var(--warning-color);
        }
        
        .stats-icon.danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.2));
            color: var(--danger-color);
        }
        
        .stats-icon.info {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(6, 182, 212, 0.2));
            color: var(--info-color);
        }
        
        .stats-content h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
            line-height: 1.2;
        }
        
        .stats-content p {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }
        
        .stats-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            margin-top: 8px;
        }
        
        .stats-trend.up {
            color: var(--success-color);
        }
        
        .stats-trend.down {
            color: var(--danger-color);
        }
        
        /* Button Styles */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #fff;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: var(--dark-color);
        }
        
        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table th {
            font-weight: 600;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr:hover {
            background: #f8fafc;
        }
        
        /* Badge Styles */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
        
        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }
        
        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }
        
        .badge-info {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar-left {
                transform: translateX(-100%);
            }
            
            .sidebar-left.show {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .main-header {
                left: 0;
            }
            
            .header-search {
                display: none;
            }
        }
        
        /* Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        /* Form Validation Styles */
        .form-control.is-invalid {
            border-color: var(--danger-color);
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 12px;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 16px;
            border: none;
        }
        
        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 24px;
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 16px 24px;
        }
        
        /* Role Badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .role-badge.admin {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }
        
        .role-badge.manager {
            background: rgba(14, 165, 233, 0.1);
            color: var(--secondary-color);
        }
        
        .role-badge.transport {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }
        
        .role-badge.employee {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Preloader -->
    <div id="preloader" class="preloader">
        <div class="preloader-content">
            <div class="preloader-spinner"></div>
            <div class="preloader-brand">InayaFleet360</div>
            <div class="preloader-tagline">Fleet Management System</div>
        </div>
    </div>
    
    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.dashboard.common.sidebar')
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Header -->
            <header class="main-header">
                <div class="header-left">
                    <div class="header-search">
                        <i class="fa fa-search"></i>
                        <input type="text" placeholder="Search requisitions, vehicles, drivers...">
                    </div>
                </div>
                
                <div class="header-right">
                    <button class="header-icon-btn" title="Refresh">
                        <i class="fa fa-sync-alt"></i>
                    </button>
                    
                    <button class="header-icon-btn" title="Notifications">
                        <i class="fa fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    
                    <button class="header-icon-btn" title="Messages">
                        <i class="fa fa-envelope"></i>
                        <span class="badge">5</span>
                    </button>
                    
                    <div class="user-dropdown" onclick="toggleUserMenu()">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">
                                @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin'))
                                    <span class="role-badge admin"><i class="fa fa-shield-alt"></i> Admin</span>
                                @elseif(Auth::user()->hasRole('Department Head') || Auth::user()->hasRole('Manager'))
                                    <span class="role-badge manager"><i class="fa fa-user-tie"></i> Manager</span>
                                @elseif(Auth::user()->hasRole('Transport'))
                                    <span class="role-badge transport"><i class="fa fa-truck"></i> Transport</span>
                                @else
                                    <span class="role-badge employee"><i class="fa fa-user"></i> Employee</span>
                                @endif
                            </div>
                        </div>
                        <i class="fa fa-chevron-down" style="color: #64748b; font-size: 12px;"></i>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="main-content">
                @yield('main_content')
            </main>
        </div>
    </div>
    
    <!-- Core JS Files -->
    <script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    @stack('scripts')
    
    <script>
        // Preloader
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('preloader').classList.add('fade-out');
            }, 500);
        });
        
        // Sidebar Toggle
        function toggleSidebar() {
            document.querySelector('.sidebar-left').classList.toggle('collapsed');
        }
        
        // Submenu Toggle
        function toggleSubmenu(element) {
            var parent = element.parentElement;
            parent.classList.toggle('nav-expanded');
            var children = parent.querySelector('.nav-children');
            if (children) {
                children.classList.toggle('show');
            }
        }
        
        // User Menu Toggle
        function toggleUserMenu() {
            // Add your user menu toggle logic here
        }
        
        // Initialize
        $(document).ready(function() {
            // Tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>
