<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.dashboard.common.header')
    
    <!-- Premium Dashboard CSS - Must load after theme.css to override -->
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
        
        /* Override any conflicting styles from theme.css for sidebar */
        #sidebar-left.sidebar-left,
        .sidebar-left {
            width: var(--sidebar-width) !important;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%) !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            z-index: 1000 !important;
            transition: width var(--transition-speed) ease !important;
            overflow: hidden !important;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3) !important;
        }
        
        #sidebar-left.sidebar-left.collapsed,
        .sidebar-left.collapsed {
            width: var(--sidebar-collapsed-width) !important;
        }
        
        #sidebar-left .sidebar-header,
        .sidebar-left .sidebar-header {
            padding: 20px !important;
            background: rgba(0, 0, 0, 0.1) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
        
        #sidebar-left .sidebar-brand,
        .sidebar-left .sidebar-brand {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            text-decoration: none !important;
            color: #fff !important;
        }
        
        #sidebar-left .sidebar-brand:hover,
        .sidebar-left .sidebar-brand:hover {
            opacity: 0.9 !important;
        }
        
        #sidebar-left .sidebar-brand:hover .sidebar-brand-icon,
        .sidebar-left .sidebar-brand:hover .sidebar-brand-icon {
            transform: scale(1.05) !important;
        }
        
        #sidebar-left .sidebar-brand-icon,
        .sidebar-left .sidebar-brand-icon {
            width: 40px !important;
            height: 40px !important;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 20px !important;
            transition: transform 0.2s ease !important;
        }
        
        #sidebar-left .sidebar-brand-text,
        .sidebar-left .sidebar-brand-text {
            font-size: 14px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            color: #fff !important;
        }
        
        /* ==========================================================================
           Sidebar Content - Scrollable navigation area
           ========================================================================== */
        #sidebar-left .sidebar-content,
        .sidebar-left .sidebar-content {
            padding: 15px 0 !important;
            height: calc(100vh - 80px) !important;
            overflow-y: auto !important;
            scrollbar-width: thin !important;
            scrollbar-color: rgba(255, 255, 255, 0.4) rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Webkit Scrollbar Styling */
        #sidebar-left .sidebar-content::-webkit-scrollbar,
        .sidebar-left .sidebar-content::-webkit-scrollbar {
            width: 8px !important;
        }
        
        #sidebar-left .sidebar-content::-webkit-scrollbar-track,
        .sidebar-left .sidebar-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        #sidebar-left .sidebar-content::-webkit-scrollbar-thumb,
        .sidebar-left .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4) !important;
            border-radius: 4px !important;
        }
        
        #sidebar-left .sidebar-content::-webkit-scrollbar-thumb:hover,
        .sidebar-left .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.6) !important;
        }
        
        /* Navigation Styles */
        #sidebar-left .nav-main,
        .sidebar-left .nav-main {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        #sidebar-left .nav-main > li,
        .sidebar-left .nav-main > li {
            /* margin: 2px 10px !important; */
        }
        
        #sidebar-left .nav-main > li > a,
        .sidebar-left .nav-main > li > a {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            padding: 12px 15px !important;
            color: rgba(255, 255, 255, 0.85) !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            gap: 12px !important;
            border-left: 3px solid transparent !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            margin-bottom: 2px !important;
        }
        
        #sidebar-left .nav-main > li > a:hover,
        .sidebar-left .nav-main > li > a:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            transform: translateX(3px) !important;
        }
        
        #sidebar-left .nav-main > li.active > a,
        .sidebar-left .nav-main > li.active > a {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.3) 0%, rgba(79, 70, 229, 0.1) 100%) !important;
            color: #fff !important;
            border-left-color: #818cf8 !important;
        }
        
        #sidebar-left .nav-main > li > a i:not(.arrow),
        .sidebar-left .nav-main > li > a i:not(.arrow) {
            width: 24px !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 16px !important;
            flex-shrink: 0 !important;
        }
        
        #sidebar-left .nav-main > li > a span,
        .sidebar-left .nav-main > li > a span {
            flex: 1 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        
        #sidebar-left .nav-main > li > a .arrow,
        .sidebar-left .nav-main > li > a .arrow {
            width: 20px !important;
            height: 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            color: rgba(255, 255, 255, 0.5) !important;
            transition: transform 0.3s ease !important;
            flex-shrink: 0 !important;
            text-shadow: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        
        #sidebar-left .nav-main > li.expanded > a .arrow,
        .sidebar-left .nav-main > li.expanded > a .arrow {
            transform: rotate(90deg) !important;
            color: #fff !important;
        }
        
        /* Submenu Styles */
        #sidebar-left .nav-children,
        .sidebar-left .nav-children {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: none !important;
            background: rgba(0, 0, 0, 0.2) !important;
            border-radius: 6px !important;
            margin-top: 4px !important;
            transition: all 0.3s ease !important;
        }
        
        #sidebar-left .nav-children.show,
        .sidebar-left .nav-children.show {
            display: block !important;
        }
        
        #sidebar-left .nav-children > li,
        .sidebar-left .nav-children > li {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        #sidebar-left .nav-children > li > a,
        .sidebar-left .nav-children > li > a {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            padding: 10px 15px 10px 50px !important;
            color: rgba(255, 255, 255, 0.75) !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            font-size: 13px !important;
            gap: 10px !important;
            border-left: none !important;
            margin: 2px 8px !important;
            border-radius: 4px !important;
        }
        
        #sidebar-left .nav-children > li > a:hover,
        .sidebar-left .nav-children > li > a:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            padding-left: 53px !important;
        }
        
        #sidebar-left .nav-children > li.active > a,
        .sidebar-left .nav-children > li.active > a {
            background: rgba(79, 70, 229, 0.2) !important;
            color: #fff !important;
            border-left: none !important;
            padding-left: 50px !important;
        }
        
        #sidebar-left .nav-children > li > a i,
        .sidebar-left .nav-children > li > a i {
            width: 18px !important;
            height: 18px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            flex-shrink: 0 !important;
        }
        
        #sidebar-left .nav-children > li > a span,
        .sidebar-left .nav-children > li > a span {
            flex: 1 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        
        /* Sidebar divider and section title */
        #sidebar-left .divider,
        .sidebar-left .divider {
            height: 1px !important;
            background: rgba(255, 255, 255, 0.1) !important;
            margin: 16px 20px !important;
        }
        
        #sidebar-left .section-title,
        .sidebar-left .section-title {
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            color: rgba(255, 255, 255, 0.4) !important;
            padding: 20px 20px 8px 20px !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }
        
        /* Smooth animations */
        #sidebar-left .nav-main li a,
        .sidebar-left .nav-main li a {
            transition: all 0.2s ease !important;
        }
        
        /* Badge styles for menu items */
        #sidebar-left .nav-main li a .badge,
        .sidebar-left .nav-main li a .badge {
            margin-left: auto !important;
            background: #ef4444 !important;
            color: #fff !important;
            font-size: 10px !important;
            padding: 2px 6px !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
        }
        
        /* ==========================================================================
           Layout Wrapper - Main flex container for sidebar + content
           ========================================================================== */
        .wrapper {
            display: flex;
            flex-direction: row;
            align-items: stretch;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }
        
        /* ==========================================================================
           Content Wrapper - Main content area adjacent to sidebar
           ========================================================================== */
        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
            transition: margin-left var(--transition-speed) ease, width var(--transition-speed) ease;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-color: #f1f5f9;
        }
        
        /* Sidebar collapsed state - updates content wrapper */
        .sidebar-left.collapsed ~ .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
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
            box-sizing: border-box !important;
            margin: -20px !important;
            padding: 0 !important;
        }
        
        /* ==========================================================================
           Main Content Components - Cards, Tables, Containers
           ========================================================================== */
        .main-content .card,
        .main-content .table-responsive {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }
        
        /* Card-specific overrides */
        .main-content .card {
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            margin-bottom: 0 !important;
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
        .main-content .pt-0,
        .main-content .pt-1,
        .main-content .pt-2,
        .main-content .pt-3,
        .main-content .pt-4,
        .main-content .pb-0,
        .main-content .pb-1,
        .main-content .pb-2,
        .main-content .pb-3,
        .main-content .pb-4 {
            padding: 0 !important;
        }
        
        /* Header styles */
        .main-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            transition: left var(--transition-speed) ease;
            width: calc(100% - var(--sidebar-width));
        }
        
        .sidebar-left.collapsed ~ .content-wrapper .main-header {
            left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }
        
        /* Responsive - Mobile */
        @media (max-width: 1024px) {
            #sidebar-left.sidebar-left,
            .sidebar-left {
                transform: translateX(-100%) !important;
            }
            
            #sidebar-left.sidebar-left.show,
            .sidebar-left.show {
                transform: translateX(0) !important;
            }
            
            .content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .main-header {
                left: 0 !important;
                width: 100% !important;
            }
        }
        
        /* Sidebar Collapsed State */
        .sidebar-left.collapsed .sidebar-brand-text {
            display: none !important;
        }
        
        .sidebar-left.collapsed .sidebar-header {
            padding: 15px !important;
            justify-content: center !important;
        }
        
        .sidebar-left.collapsed .nav-main > li > a {
            justify-content: center !important;
            padding: 12px !important;
        }
        
        .sidebar-left.collapsed .nav-main > li > a span {
            display: none !important;
        }
        
        .sidebar-left.collapsed .nav-main > li > a .arrow {
            display: none !important;
        }
        
        .sidebar-left.collapsed .divider,
        .sidebar-left.collapsed .section-title {
            display: none !important;
        }
        
        .sidebar-left.collapsed .nav-children {
            display: none !important;
        }
        
        .sidebar-left.collapsed:hover .nav-main > li > a {
            justify-content: flex-start !important;
            padding: 12px 20px !important;
        }
        
        .sidebar-left.collapsed:hover .nav-main > li > a span {
            display: block !important;
        }
        
        /* Page specific styles */
        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .header-search {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 8px 16px;
            gap: 8px;
        }
        
        .header-search i {
            color: #94a3b8;
        }
        
        .header-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            width: 250px;
        }
        
        .header-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }
        
        .header-icon-btn:hover {
            background: #e2e8f0;
            color: #4f46e5;
        }
        
        .header-icon-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .user-dropdown:hover {
            background: #f1f5f9;
        }
        
        .user-dropdown.active {
            background: #f1f5f9;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #0ea5e9);
            color: #fff;
            display: flex;
            align-items: center;
               justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-info {
            text-align: left;
        }
        
        .user-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        
        .user-role {
            font-size: 12px;
            color: #64748b;
        }
        
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .role-badge.admin {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .role-badge.manager {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        
        .role-badge.transport {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        
        .role-badge.employee {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
        }
        
        /* ==========================================================================
           User Dropdown Menu
           ========================================================================== */
        .user-dropdown {
            position: relative;
            cursor: pointer;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            min-width: 200px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 1001;
            overflow: hidden;
        }
        
        .user-dropdown.active .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .user-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #1e293b;
            text-decoration: none;
            transition: background 0.2s ease;
            font-size: 14px;
        }
        
        .user-dropdown-menu .dropdown-item:hover {
            background: #f1f5f9;
            color: #4f46e5;
        }
        
        .user-dropdown-menu .dropdown-item.text-danger {
            color: #ef4444;
        }
        
        .user-dropdown-menu .dropdown-item.text-danger:hover {
            background: rgba(239, 68, 68, 0.1);
        }
        
        .user-dropdown-menu .dropdown-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 4px 0;
        }
        
        .user-dropdown-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
        }
        
        .user-dropdown-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        .header-divider {
            width: 1px;
            height: 24px;
            background: #e2e8f0;
            margin: 0 8px;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .header-search {
                display: none;
            }
            
            .user-info {
                display: none;
            }
            
            .main-header {
                padding: 0 16px;
            }
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
    </style>

    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-content">
            <div class="preloader-spinner"></div>
            <div class="preloader-brand">InayaFleet360</div>
            <div class="preloader-tagline">Fleet Management System</div>
        </div>
    </div>
</head>
<body>
    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.dashboard.common.sidebar')
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main Header with Navigation -->
            <header class="main-header">
                <div class="header-left">
                    <button class="header-icon-btn toggle-sidebar-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="header-search">
                        <i class="fa fa-search"></i>
                        <input type="text" placeholder="Search requisitions, vehicles, drivers...">
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Notifications -->
                    @php
                    $notifications = \App\Models\Notification::where('user_id', auth()->id())
                        ->latest()
                        ->limit(10)
                        ->get();
                    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                        ->where('is_read', 0)
                        ->count();
                    @endphp
                    
                    <div class="dropdown notification-dropdown">
                        <a class="header-icon-btn dropdown-toggle" data-toggle="dropdown" title="Notifications">
                            <i class="fa fa-bell"></i>
                            @if($unreadCount > 0)
                                <span class="badge">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right">
                            <h6 class="dropdown-header">Notifications</h6>
                            <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                                @forelse($notifications as $note)
                                    <a href="{{ $note->link ?? '#' }}" class="dropdown-item">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $note->title }}</strong>
                                            <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($note->message)
                                            <p class="mb-0 text-muted" style="font-size: 13px;">{{ $note->message }}</p>
                                        @endif
                                    </a>
                                @empty
                                    <p class="text-center text-muted m-2">No notifications</p>
                                @endforelse
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.notifications.all') }}" class="dropdown-item text-center">View All</a>
                        </div>
                    </div>
                    
                    <button class="header-icon-btn" title="Messages">
                        <i class="fa fa-envelope"></i>
                        <span class="badge">5</span>
                    </button>
                    
                    <div class="user-dropdown" onclick="toggleUserMenu(event)">
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
                        
                        <!-- User Dropdown Menu -->
                        <div class="user-dropdown-menu">
                            <a href="{{ route('user-profile') }}" class="dropdown-item">
                                <i class="fa fa-user mr-2"></i> My Profile
                            </a>
                            <a href="{{ route('settings.index') }}" class="dropdown-item">
                                <i class="fa fa-cog mr-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt mr-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    
                    <!-- User Menu Overlay for closing -->
                    <div class="user-dropdown-overlay" onclick="closeUserMenu()"></div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="main-content">
                @yield('main_content')
            </main>
        </div>
    </div>

    <!-- Core JS Files - Already loaded in header.blade.php -->
    {{-- <script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables JS (local) -->
    {{-- DataTables includes its own jQuery --}}
    <script src="{{ asset('public/admin_resource/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/datatables-rowreorder/js/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    @stack('scripts')

    <script>
        // Preloader
        window.addEventListener('load', function() {
            setTimeout(function() {
                var preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('fade-out');
                }
            }, 500);
        });
        
        // Sidebar Toggle
        function toggleSidebar() {
            var sidebar = document.querySelector('.sidebar-left');
            if (sidebar) {
                sidebar.classList.toggle('collapsed');
            }
        }
        
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
                if (children.parentElement) {
                    children.parentElement.classList.add('expanded');
                }
            });
        });
        
        // User Menu Toggle
        function toggleUserMenu(event) {
            event.stopPropagation();
            var userDropdown = document.querySelector('.user-dropdown');
            if (userDropdown) {
                userDropdown.classList.toggle('active');
                var overlay = document.querySelector('.user-dropdown-overlay');
                if (overlay) {
                    overlay.classList.toggle('show');
                }
            }
        }
        
        // Close User Menu
        function closeUserMenu() {
            var userDropdown = document.querySelector('.user-dropdown');
            var overlay = document.querySelector('.user-dropdown-overlay');
            if (userDropdown) {
                userDropdown.classList.remove('active');
            }
            if (overlay) {
                overlay.classList.remove('show');
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var userDropdown = document.querySelector('.user-dropdown');
            var dropdownMenu = document.querySelector('.user-dropdown-menu');
            if (userDropdown && dropdownMenu) {
                if (!userDropdown.contains(event.target)) {
                    userDropdown.classList.remove('active');
                    var overlay = document.querySelector('.user-dropdown-overlay');
                    if (overlay) {
                        overlay.classList.remove('show');
                    }
                }
            }
        });
    </script>

    <!-- Premium Toast Notification Styles -->
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
        }
        
        .toast-container > * {
            pointer-events: auto;
        }
        
        .premium-toast {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            min-width: 350px;
            max-width: 450px;
            animation: slideInRight 0.4s ease-out;
            border-left: 4px solid;
            overflow: hidden;
            position: relative;
        }
        
        .premium-toast.success {
            border-left-color: #10b981;
        }
        
        .premium-toast.error {
            border-left-color: #ef4444;
        }
        
        .premium-toast.warning {
            border-left-color: #f59e0b;
        }
        
        .premium-toast.info {
            border-left-color: #3b82f6;
        }
        
        .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .premium-toast.success .toast-icon {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: #10b981;
        }
        
        .premium-toast.error .toast-icon {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #ef4444;
        }
        
        .premium-toast.warning .toast-icon {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
            color: #f59e0b;
        }
        
        .premium-toast.info .toast-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
            color: #3b82f6;
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-title {
            font-weight: 700;
            font-size: 15px;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .toast-message {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }
        
        .toast-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        
        .toast-close:hover {
            background: #f1f5f9;
            color: #1e293b;
        }
        
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }
        
        .toast-progress-bar {
            height: 100%;
            border-radius: 0 0 0 12px;
            transition: width 0.1s linear;
        }
        
        .premium-toast.success .toast-progress-bar {
            background: linear-gradient(90deg, #10b981, #34d399);
        }
        
        .premium-toast.error .toast-progress-bar {
            background: linear-gradient(90deg, #ef4444, #f87171);
        }
        
        .premium-toast.warning .toast-progress-bar {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }
        
        .premium-toast.info .toast-progress-bar {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }
        
        .premium-toast.hiding {
            animation: slideOutRight 0.3s ease-out forwards;
        }
    </style>

    <!-- Premium Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Premium Toast Notification Script -->
    <script>
        // Premium Toast Notification Function
        function showPremiumToast(type, title, message, duration = 5000) {
            const container = document.getElementById('toastContainer');
            
            if (!container) return;
            
            const icons = {
                success: '<i class="fas fa-check-circle"></i>',
                error: '<i class="fas fa-times-circle"></i>',
                warning: '<i class="fas fa-exclamation-triangle"></i>',
                info: '<i class="fas fa-info-circle"></i>'
            };
            
            const toastId = 'toast_' + Date.now();
            
            const toastHTML = `
                <div class="premium-toast ${type}" id="${toastId}">
                    <div class="toast-icon">${icons[type] || icons.info}</div>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="dismissToast('${toastId}')">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="toast-progress">
                        <div class="toast-progress-bar" style="width: 100%;"></div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', toastHTML);
            
            const toast = document.getElementById(toastId);
            const progressBar = toast.querySelector('.toast-progress-bar');
            
            // Animate progress bar
            setTimeout(() => {
                if (progressBar) {
                    progressBar.style.transition = `width ${duration}ms linear`;
                    progressBar.style.width = '0%';
                }
            }, 100);
            
            // Auto dismiss
            const dismissTimer = setTimeout(() => {
                dismissToast(toastId);
            }, duration);
            
            // Store timer on element for manual dismiss
            toast.dataset.timerId = dismissTimer;
            
            return toastId;
        }
        
        function dismissToast(toastId) {
            const toast = document.getElementById(toastId);
            if (!toast) return;
            
            // Clear the timer
            if (toast.dataset.timerId) {
                clearTimeout(toast.dataset.timerId);
            }
            
            // Add hiding class for animation
            toast.classList.add('hiding');
            
            // Remove after animation
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }
    </script>
</body>
</html>
