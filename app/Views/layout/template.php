<?php
// File: app/Views/layout/template.php - Modern Version
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Manajemen Sarana Prasarana' ?> - SMK Abdurrab Pekanbaru</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Modern Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #3730a3;
            --success-color: #10b981;
            --success-light: #34d399;
            --warning-color: #f59e0b;
            --warning-light: #fbbf24;
            --danger-color: #ef4444;
            --danger-light: #f87171;
            --info-color: #06b6d4;
            --info-light: #22d3ee;
            --secondary-color: #6b7280;
            --light-color: #f9fafb;
            --dark-color: #1f2937;
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --box-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --sidebar-width: 260px;
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background: #f8fafc;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Navigation Bar */
        .navbar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
            box-shadow: var(--box-shadow);
            border: none;
            padding: 0.75rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white !important;
            padding: 0.75rem 1.5rem;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand:hover {
            color: #e2e8f0 !important;
        }

        .navbar-brand i {
            color: var(--primary-light);
        }

        .dropdown-toggle {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0 !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--box-shadow-lg);
            border-radius: var(--border-radius);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--light-color);
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: var(--sidebar-width);
            padding: 76px 0 0;
            background: white;
            border-right: 1px solid #e2e8f0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 76px);
            padding: 1rem 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar-sticky::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-sticky::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Navigation Links */
        .nav-link {
            font-weight: 500;
            color: var(--secondary-color);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover i,
        .nav-link.active i {
            transform: scale(1.1);
        }

        /* Main Content */
        main {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.25rem;
            font-weight: 500;
            box-shadow: var(--box-shadow);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #7f1d1d;
            border-left: 4px solid var(--danger-color);
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #78350f;
            border-left: 4px solid var(--warning-color);
        }

        .alert-info {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            color: #0c4a6e;
            border-left: 4px solid var(--info-color);
        }

        .btn-close {
            opacity: 0.6;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Dashboard Specific Styles */
        .dashboard-header {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-subtitle {
            margin: 0;
            font-size: 1rem;
            color: var(--secondary-color);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        }

        /* Stats Cards */
        .stats-card-modern {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stats-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-lg);
        }

        .stats-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color) 0%, var(--card-color-light) 100%);
        }

        .stats-card-modern.primary {
            --card-color: var(--primary-color);
            --card-color-light: var(--primary-light);
        }

        .stats-card-modern.success {
            --card-color: var(--success-color);
            --card-color-light: var(--success-light);
        }

        .stats-card-modern.warning {
            --card-color: var(--warning-color);
            --card-color-light: var(--warning-light);
        }

        .stats-card-modern.danger {
            --card-color: var(--danger-color);
            --card-color-light: var(--danger-light);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-light) 100%);
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            line-height: 1;
        }

        .stats-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .stats-detail {
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin-top: 0.25rem;
        }

        .stats-trend {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.2rem;
            opacity: 0.7;
        }

        /* Activity Cards */
        .activity-card,
        .user-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .activity-card:hover,
        .user-card:hover {
            box-shadow: var(--box-shadow-lg);
            transform: translateY(-2px);
        }

        .activity-header,
        .user-card-header {
            padding: 1.5rem 1.5rem 1rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(135deg, #fafbfc 0%, #f4f5f7 100%);
        }

        .activity-icon,
        .user-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 1rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .activity-title,
        .user-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid transparent;
        }

        .status-badge.primary {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            color: var(--primary-color);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .status-badge.success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(52, 211, 153, 0.1) 100%);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .status-badge.warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(251, 191, 36, 0.1) 100%);
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.2);
        }

        .status-badge.danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.1) 100%);
            color: var(--danger-color);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .status-badge.info {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(34, 211, 238, 0.1) 100%);
            color: var(--info-color);
            border-color: rgba(6, 182, 212, 0.2);
        }

        .status-badge.secondary {
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.1) 0%, rgba(156, 163, 175, 0.1) 100%);
            color: var(--secondary-color);
            border-color: rgba(107, 114, 128, 0.2);
        }

        /* Button Styles */
        .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            padding: 0.5rem 1.25rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--box-shadow);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Card General Styles */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: white;
        }

        .card-header {
            background: linear-gradient(135deg, #fafbfc 0%, #f4f5f7 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            color: var(--dark-color);
            padding: 1rem 0.75rem;
        }

        .table td {
            border-top: 1px solid #f1f5f9;
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(249, 250, 251, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
                z-index: 1050;
            }

            main {
                margin-left: 0;
                padding: 1.5rem;
            }

            .dashboard-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .dashboard-title {
                font-size: 1.75rem;
            }

            .stats-card-modern {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .stats-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            main {
                padding: 1rem;
            }

            .dashboard-header {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }

            .stats-card-modern {
                padding: 1rem;
            }

            .stats-number {
                font-size: 1.75rem;
            }

            .activity-header,
            .user-card-header {
                padding: 1rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .stats-card-modern,
        .activity-card,
        .user-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .nav-link {
            animation: slideInLeft 0.4s ease-out;
        }

        .stats-card-modern:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stats-card-modern:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stats-card-modern:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stats-card-modern:nth-child(4) {
            animation-delay: 0.4s;
        }

        .nav-link:nth-child(1) {
            animation-delay: 0.1s;
        }

        .nav-link:nth-child(2) {
            animation-delay: 0.15s;
        }

        .nav-link:nth-child(3) {
            animation-delay: 0.2s;
        }

        .nav-link:nth-child(4) {
            animation-delay: 0.25s;
        }

        .nav-link:nth-child(5) {
            animation-delay: 0.3s;
        }

        .nav-link:nth-child(6) {
            animation-delay: 0.35s;
        }

        .nav-link:nth-child(7) {
            animation-delay: 0.4s;
        }

        /* Perbaikan CSS untuk Dashboard - Tambahkan ke template.php */

        /* Dashboard Layout Fixes */
        .dashboard-header {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }

        .dashboard-subtitle {
            margin: 0;
            font-size: 1rem;
            color: var(--secondary-color);
        }

        /* Stats Cards Layout Fix */
        .stats-card-modern {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stats-card-modern:hover {
            transform: translateY(-3px);
            box-shadow: var(--box-shadow-lg);
        }

        .stats-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color) 0%, var(--card-color-light) 100%);
        }

        .stats-card-modern.primary {
            --card-color: var(--primary-color);
            --card-color-light: var(--primary-light);
        }

        .stats-card-modern.success {
            --card-color: var(--success-color);
            --card-color-light: var(--success-light);
        }

        .stats-card-modern.warning {
            --card-color: var(--warning-color);
            --card-color-light: var(--warning-light);
        }

        .stats-card-modern.danger {
            --card-color: var(--danger-color);
            --card-color-light: var(--danger-light);
        }

        /* Stats Card Content */
        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-light) 100%);
            color: white;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-content {
            flex: 1;
        }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark-color);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .stats-detail {
            font-size: 0.75rem;
            color: var(--secondary-color);
            margin-top: 0.25rem;
        }

        .stats-trend {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1rem;
            opacity: 0.6;
        }

        /* Activity Cards Layout Fix */
        .activity-card,
        .user-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .activity-card:hover,
        .user-card:hover {
            box-shadow: var(--box-shadow-lg);
            transform: translateY(-2px);
        }

        .activity-header,
        .user-card-header {
            padding: 1.25rem 1.5rem 1rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(135deg, #fafbfc 0%, #f4f5f7 100%);
            flex-shrink: 0;
        }

        .activity-icon,
        .user-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            margin-right: 1rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .activity-title,
        .user-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .activity-content,
        .user-card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 250px;
        }

        .activity-list,
        .user-activity-list {
            flex: 1;
            padding: 0 1.5rem;
            overflow-y: auto;
        }

        .activity-item,
        .user-activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f8fafc;
        }

        .activity-item:last-child,
        .user-activity-item:last-child {
            border-bottom: none;
        }

        .activity-item-info,
        .user-activity-info {
            flex: 1;
            min-width: 0;
            /* Untuk text truncation */
        }

        .activity-item-title,
        .user-activity-title {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-item-subtitle,
        .user-activity-date {
            color: var(--secondary-color);
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-item-status,
        .user-activity-status {
            margin-left: 0.75rem;
            flex-shrink: 0;
        }

        .activity-footer,
        .user-card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f1f5f9;
            background: #f9fafb;
            flex-shrink: 0;
        }

        /* Empty State */
        .empty-state,
        .user-empty-state {
            text-align: center;
            padding: 2rem 1.5rem;
            color: var(--secondary-color);
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .status-badge.primary {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .status-badge.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .status-badge.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.2);
        }

        .status-badge.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .status-badge.info {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border-color: rgba(6, 182, 212, 0.2);
        }

        .status-badge.secondary {
            background: rgba(107, 114, 128, 0.1);
            color: var(--secondary-color);
            border-color: rgba(107, 114, 128, 0.2);
        }

        /* Urgent Alert */
        .urgent-alert {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #f87171;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-top: 2rem;
        }

        .urgent-alert-header {
            background: var(--danger-color);
            color: white;
            padding: 1.25rem;
            display: flex;
            align-items: center;
        }

        .urgent-alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-right: 1rem;
        }

        .urgent-alert-content {
            flex: 1;
        }

        .urgent-alert-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .urgent-alert-subtitle {
            margin: 0.25rem 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .urgent-alert-body {
            background: white;
            padding: 1.25rem;
        }

        /* Responsive Fixes */
        @media (max-width: 1200px) {
            .stats-number {
                font-size: 1.8rem;
            }

            .stats-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 992px) {

            .activity-content,
            .user-card-content {
                min-height: 200px;
            }

            .dashboard-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .dashboard-title {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 768px) {
            .stats-card-modern {
                padding: 1.25rem;
                margin-bottom: 1rem;
            }

            .stats-number {
                font-size: 1.6rem;
            }

            .stats-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }

            .activity-header,
            .user-card-header {
                padding: 1rem;
            }

            .activity-icon,
            .user-card-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .dashboard-header {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }
        }

        @media screen and (min-width: 1200px) {
            body {
                zoom: 0.8;
                /* Chrome, Edge, Safari */
            }

            /* Fallback untuk Firefox */
            @-moz-document url-prefix() {
                body {
                    transform: scale(0.8);
                    transform-origin: top left;
                    width: 125%;
                    height: 125%;
                    overflow-x: hidden;
                }
            }
        }

        .navbar-logo {
            height: 40px !important;
            width: auto !important;
            max-width: 50px !important;
            object-fit: contain !important;
            border: 2px solid red !important;
            /* Temporary border untuk debug */
            background-color: white !important;
            /* Temporary background untuk debug */
            display: inline-block !important;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0" href="/dashboard">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="SMP SMK Abdurrab" class="navbar-logo me-2" style="height: 35px; width: auto;">
            SMP SMK Abdurrab
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>
                        <?= session()->get('full_name') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text"><i class="fas fa-id-badge me-2"></i>Role: <?= ucfirst(session()->get('role')) ?></span></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url(true)->getPath() == '/dashboard') ? 'active' : '' ?>" href="/dashboard">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>

                        <?php if (session()->get('role') !== 'user'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (strpos(current_url(), '/items') !== false) ? 'active' : '' ?>" href="/items">
                                    <i class="fas fa-boxes"></i>
                                    Data Barang
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (session()->get('role') === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (strpos(current_url(), '/categories') !== false) ? 'active' : '' ?>" href="/categories">
                                    <i class="fas fa-tags"></i>
                                    Kategori
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= (strpos(current_url(), '/users') !== false) ? 'active' : '' ?>" href="/users">
                                    <i class="fas fa-users"></i>
                                    Data Pengguna
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), '/requests') !== false) ? 'active' : '' ?>" href="/requests">
                                <i class="fas fa-file-alt"></i>
                                <?= session()->get('role') === 'user' ? 'Permintaan Saya' : 'Data Permintaan' ?>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), '/loans') !== false) ? 'active' : '' ?>" href="/loans">
                                <i class="fas fa-handshake"></i>
                                <?= session()->get('role') === 'user' ? 'Pinjaman Saya' : 'Data Pinjaman' ?>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), '/damage-reports') !== false) ? 'active' : '' ?>" href="/damage-reports">
                                <i class="fas fa-exclamation-triangle"></i>
                                <?= session()->get('role') === 'user' ? 'Laporan Kerusakan' : 'Data Kerusakan' ?>
                            </a>
                        </li>

                        <?php if (session()->get('role') !== 'user'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (strpos(current_url(), '/reports') !== false) ? 'active' : '' ?>" href="/reports">
                                    <i class="fas fa-chart-bar"></i>
                                    Laporan
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Page Content -->
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Confirm delete actions
            $('.btn-delete').click(function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });

            // Sidebar toggle for mobile
            $('.navbar-toggler').click(function() {
                $('.sidebar').toggleClass('show');
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function(e) {
                if (!$(e.target).closest('.sidebar, .navbar-toggler').length) {
                    $('.sidebar').removeClass('show');
                }
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').click(function(e) {
                e.preventDefault();
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 500);
                }
            });

            // Add loading state to buttons
            $('.btn-loading').click(function() {
                var btn = $(this);
                var originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...');
                btn.prop('disabled', true);

                setTimeout(function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }, 2000);
            });

            // Form validation enhancement
            $('.needs-validation').on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass('was-validated');
            });

            // Tooltip initialization
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Enhanced card animations
            $('.stats-card-modern, .activity-card, .user-card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );

            // Progress bar animation
            $('.progress-bar').each(function() {
                var width = $(this).attr('aria-valuenow');
                $(this).animate({
                    width: width + '%'
                }, 1000);
            });

            // Number counter animation
            $('.stats-number').each(function() {
                var $this = $(this);
                var countTo = parseInt($this.text());

                $({
                    countNum: 0
                }).animate({
                    countNum: countTo
                }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }
                });
            });

            // Search functionality enhancement
            $('.search-input').on('input', function() {
                var searchTerm = $(this).val().toLowerCase();
                var targetTable = $(this).data('target');

                $(targetTable + ' tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Status badge click to filter
            $('.status-badge').click(function(e) {
                e.preventDefault();
                var status = $(this).text().toLowerCase();
                var table = $(this).closest('.card').find('table');

                table.find('tbody tr').each(function() {
                    var rowStatus = $(this).find('.status-badge').text().toLowerCase();
                    if (status === 'all' || rowStatus.indexOf(status) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Auto-refresh data every 5 minutes for dashboard
            if (window.location.pathname === '/dashboard') {
                setInterval(function() {
                    // Only refresh if user is still active (mouse moved in last 10 minutes)
                    if (Date.now() - lastActivity < 600000) {
                        location.reload();
                    }
                }, 300000); // 5 minutes
            }

            // Track user activity
            var lastActivity = Date.now();
            $(document).on('mousemove keypress scroll', function() {
                lastActivity = Date.now();
            });

            // Copy to clipboard functionality
            $('.copy-btn').click(function() {
                var textToCopy = $(this).data('copy');
                navigator.clipboard.writeText(textToCopy).then(function() {
                    // Show success message
                    var btn = $('.copy-btn');
                    var originalText = btn.html();
                    btn.html('<i class="fas fa-check text-success"></i>');
                    setTimeout(function() {
                        btn.html(originalText);
                    }, 2000);
                });
            });

            // File upload preview
            $('.file-input').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.file-preview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Print functionality
            $('.btn-print').click(function() {
                window.print();
            });

            // Export functionality
            $('.btn-export').click(function() {
                var exportType = $(this).data('type');
                var tableId = $(this).data('table');

                if (exportType === 'csv') {
                    exportTableToCSV(tableId);
                } else if (exportType === 'excel') {
                    exportTableToExcel(tableId);
                }
            });

            // CSV Export function
            function exportTableToCSV(tableId) {
                var csv = [];
                var rows = document.querySelectorAll(tableId + " tr");

                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll("td, th");

                    for (var j = 0; j < cols.length; j++) {
                        row.push(cols[j].innerText);
                    }

                    csv.push(row.join(","));
                }

                downloadCSV(csv.join("\n"), 'export.csv');
            }

            function downloadCSV(csv, filename) {
                var csvFile;
                var downloadLink;

                csvFile = new Blob([csv], {
                    type: "text/csv"
                });
                downloadLink = document.createElement("a");
                downloadLink.download = filename;
                downloadLink.href = window.URL.createObjectURL(csvFile);
                downloadLink.style.display = "none";
                document.body.appendChild(downloadLink);
                downloadLink.click();
            }

            // Advanced form handling
            $('.form-step').each(function(index) {
                if (index !== 0) {
                    $(this).hide();
                }
            });

            $('.btn-next').click(function() {
                var currentStep = $(this).closest('.form-step');
                var nextStep = currentStep.next('.form-step');

                if (nextStep.length) {
                    currentStep.hide();
                    nextStep.show();
                }
            });

            $('.btn-prev').click(function() {
                var currentStep = $(this).closest('.form-step');
                var prevStep = currentStep.prev('.form-step');

                if (prevStep.length) {
                    currentStep.hide();
                    prevStep.show();
                }
            });

            // Enhanced table interactions
            $('.table-hover tbody tr').hover(
                function() {
                    $(this).addClass('table-active');
                },
                function() {
                    $(this).removeClass('table-active');
                }
            );

            // Auto-save form data to localStorage (for draft functionality)
            $('.auto-save').on('input change', function() {
                var formId = $(this).closest('form').attr('id');
                var fieldName = $(this).attr('name');
                var fieldValue = $(this).val();

                if (formId && fieldName) {
                    localStorage.setItem(formId + '_' + fieldName, fieldValue);
                }
            });

            // Restore form data from localStorage
            $('.auto-save').each(function() {
                var formId = $(this).closest('form').attr('id');
                var fieldName = $(this).attr('name');

                if (formId && fieldName) {
                    var savedValue = localStorage.getItem(formId + '_' + fieldName);
                    if (savedValue) {
                        $(this).val(savedValue);
                    }
                }
            });

            // Clear saved form data on successful submit
            $('form').on('submit', function() {
                var formId = $(this).attr('id');
                if (formId) {
                    $(this).find('.auto-save').each(function() {
                        var fieldName = $(this).attr('name');
                        if (fieldName) {
                            localStorage.removeItem(formId + '_' + fieldName);
                        }
                    });
                }
            });

            // Dynamic breadcrumb update
            function updateBreadcrumb() {
                var path = window.location.pathname;
                var breadcrumb = $('.breadcrumb');

                if (breadcrumb.length) {
                    breadcrumb.empty();
                    var pathArray = path.split('/').filter(function(item) {
                        return item !== '';
                    });

                    breadcrumb.append('<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>');

                    for (var i = 0; i < pathArray.length; i++) {
                        var isLast = (i === pathArray.length - 1);
                        var itemName = pathArray[i].charAt(0).toUpperCase() + pathArray[i].slice(1);

                        if (isLast) {
                            breadcrumb.append('<li class="breadcrumb-item active">' + itemName + '</li>');
                        } else {
                            var href = '/' + pathArray.slice(0, i + 1).join('/');
                            breadcrumb.append('<li class="breadcrumb-item"><a href="' + href + '">' + itemName + '</a></li>');
                        }
                    }
                }
            }

            // Call breadcrumb update
            updateBreadcrumb();

            // Keyboard shortcuts
            $(document).keydown(function(e) {
                // Ctrl + S to save form
                if ((e.ctrlKey || e.metaKey) && e.which === 83) {
                    e.preventDefault();
                    var form = $('form:visible').first();
                    if (form.length) {
                        form.submit();
                    }
                }

                // Escape key to close modals
                if (e.which === 27) {
                    $('.modal.show').modal('hide');
                }

                // Ctrl + F to focus search
                if ((e.ctrlKey || e.metaKey) && e.which === 70) {
                    var searchInput = $('.search-input:visible').first();
                    if (searchInput.length) {
                        e.preventDefault();
                        searchInput.focus();
                    }
                }
            });

            // PWA install prompt
            let deferredPrompt;

            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;

                // Show install button
                $('.pwa-install-btn').show();
            });

            $('.pwa-install-btn').click(function() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        deferredPrompt = null;
                        $('.pwa-install-btn').hide();
                    });
                }
            });

            // Connection status indicator
            function updateConnectionStatus() {
                if (navigator.onLine) {
                    $('.connection-status').removeClass('offline').addClass('online').text('Online');
                } else {
                    $('.connection-status').removeClass('online').addClass('offline').text('Offline');
                }
            }

            window.addEventListener('online', updateConnectionStatus);
            window.addEventListener('offline', updateConnectionStatus);
            updateConnectionStatus();
        });

        // Global utility functions
        function showLoading() {
            if ($('#loadingModal').length === 0) {
                $('body').append(`
                    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
                        <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center p-4">
                                    <div class="spinner-border text-primary mb-3" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mb-0">Memproses data...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }
            $('#loadingModal').modal('show');
        }

        function hideLoading() {
            $('#loadingModal').modal('hide');
        }

        function showNotification(message, type = 'success') {
            var alertClass = 'alert-' + type;
            var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            var notification = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            $('body').append(notification);

            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }

        function confirmAction(message, callback) {
            if (confirm(message)) {
                callback();
            }
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        function formatDate(date) {
            return new Intl.DateTimeFormat('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }).format(new Date(date));
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Service Worker registration for PWA functionality
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful');
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed');
                });
        }

        // Performance monitoring
        window.addEventListener('load', function() {
            if ('performance' in window) {
                setTimeout(function() {
                    var perfData = performance.getEntriesByType('navigation')[0];
                    if (perfData) {
                        console.log('Page load time:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
                    }
                }, 0);
            }
        });
    </script>