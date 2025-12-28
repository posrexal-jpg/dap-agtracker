@extends('layouts.app')
@section('title', 'Admin Dashboard - Dag-ag Tracker')

@section('content')
<div class="admin-dashboard">
    <!-- Modern Header Section -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7">
                    <div class="header-content">
                        <div class="d-flex align-items-center mb-2">
                            <div class="header-icon me-3">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div>
                                <h1 class="header-title mb-0">Admin Dashboard</h1>
                                <p class="header-subtitle mb-0">Monitor and manage COTS tracking data across Southern Leyte</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 text-end">
                    <div class="header-actions">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <div class="header-stats">
                                <div class="stat-item">
                                    <span class="stat-value">{{ $userCount }}</span>
                                    <span class="stat-label">Active Users</span>
                                </div>
                            </div>
                            <div class="brand-logo">
                                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <div class="container-fluid">
            <!-- Enhanced Stats Cards -->
            <div class="stats-grid">
                <div class="stats-row">
                    <div class="stat-card users-card">
                        <div class="stat-card-inner">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $userCount }}</div>
                                <div class="stat-label">Total Users</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+12%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card cots-card">
                        <div class="stat-card-inner">
                            <div class="stat-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $totalCots }}</div>
                                <div class="stat-label">Total COTS</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+8%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card locations-card">
                        <div class="stat-card-inner">
                            <div class="stat-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $locationCount }}</div>
                                <div class="stat-label">Active Locations</div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+15%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card municipalities-card">
                        <div class="stat-card-inner">
                            <div class="stat-icon">
                                <i class="fas fa-city"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ count($municipalities ?? []) }}</div>
                                <div class="stat-label">Municipalities</div>
                                <div class="stat-trend">
                                    <i class="fas fa-minus"></i>
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Actions Section -->
            <div class="dashboard-grid">
                <!-- Main Chart -->
                <div class="chart-section">
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">
                                <i class="fas fa-chart-pie"></i>
                                <span>COTS Distribution by Municipality</span>
                            </div>
                            <div class="chart-actions">
                                <button class="btn btn-sm btn-outline-primary" onclick="refreshChart()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chart-body">
                            <div id="pieChart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Recent Activity -->
                <div class="actions-section">
                    <!-- Quick Actions -->
                    <div class="action-card">
                        <div class="action-header">
                            <div class="action-title">
                                <i class="fas fa-bolt"></i>
                                <span>Quick Actions</span>
                            </div>
                        </div>
                        <div class="action-body">
                            <div class="action-buttons">
                                <a href="{{ route('admin.location') }}" class="action-btn primary">
                                    <div class="action-icon">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-label">Manage Locations</span>
                                        <span class="action-desc">View and edit sighting data</span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>

                                <a href="{{ route('admin.users.index') }}" class="action-btn success">
                                    <div class="action-icon">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-label">Manage Users</span>
                                        <span class="action-desc">Add and manage user accounts</span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>

                                <a href="{{ route('admin.report') }}" class="action-btn info">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-label">Generate Reports</span>
                                        <span class="action-desc">Export data and analytics</span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>

                                <a href="{{ route('admin.download') }}" class="action-btn warning">
                                    <div class="action-icon">
                                        <i class="fas fa-download"></i>
                                    </div>
                                    <div class="action-content">
                                        <span class="action-label">Download Data</span>
                                        <span class="action-desc">Bulk data export options</span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="status-card">
                        <div class="status-header">
                            <div class="status-title">
                                <i class="fas fa-server"></i>
                                <span>System Status</span>
                            </div>
                        </div>
                        <div class="status-body">
                            <div class="status-items">
                                <div class="status-item">
                                    <div class="status-indicator online"></div>
                                    <span>Database</span>
                                </div>
                                <div class="status-item">
                                    <div class="status-indicator online"></div>
                                    <span>File Storage</span>
                                </div>
                                <div class="status-item">
                                    <div class="status-indicator online"></div>
                                    <span>API Services</span>
                                </div>
                                <div class="status-item">
                                    <div class="status-indicator warning"></div>
                                    <span>Backup Status</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="recent-activity">
                <div class="activity-card">
                    <div class="activity-header">
                        <div class="activity-title">
                            <i class="fas fa-history"></i>
                            <span>Recent Activity</span>
                        </div>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="activity-body">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">New COTS sighting reported in Sogod</div>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">New user account created</div>
                                    <div class="activity-time">4 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">Monthly report generated</div>
                                    <div class="activity-time">1 day ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card shadow h-100">
                    <div class="card-body text-center p-4">
                        <div class="stats-icon bg-primary bg-gradient text-white">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <h4 class="mb-2">{{ $userCount }}</h4>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card shadow h-100">
                    <div class="card-body text-center p-4">
                        <div class="stats-icon bg-warning bg-gradient text-white">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                        <h4 class="mb-2">{{ $totalCots }}</h4>
                        <p class="text-muted mb-0">Total COTS</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card shadow h-100">
                    <div class="card-body text-center p-4">
                        <div class="stats-icon bg-info bg-gradient text-white">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <h4 class="mb-2">{{ $locationCount }}</h4>
                        <p class="text-muted mb-0">Active Locations</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card shadow h-100">
                    <div class="card-body text-center p-4">
                        <div class="stats-icon bg-success bg-gradient text-white">
                            <i class="fas fa-city fa-lg"></i>
                        </div>
                        <h4 class="mb-2">{{ count($municipalities ?? []) }}</h4>
                        <p class="text-muted mb-0">Municipalities</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card chart-card shadow">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Locations by Municipality
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="pieChart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card chart-card shadow">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary mb-0">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body quick-actions">
                        <a href="{{ route('admin.location') }}" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-map-marked-alt me-2"></i>Manage Locations
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-lg w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Manage Users
                        </a>
                        <a href="{{ route('admin.report') }}" class="btn btn-info btn-lg w-100 mb-3">
                            <i class="fas fa-chart-bar me-2"></i>Generate Reports
                        </a>
                        <a href="{{ route('admin.download') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-download me-2"></i>Download Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Admin Dashboard Styles */
:root {
    --primary-color: #1e40af;
    --primary-dark: #1e3a8a;
    --primary-light: #3b82f6;
    --secondary-color: #64748b;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --border-color: #e2e8f0;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
}

.admin-dashboard {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

/* Header Styles */
.dashboard-header {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
}

.header-content .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.header-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.header-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 400;
}

.header-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-md);
    backdrop-filter: blur(10px);
}

.stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.brand-logo img {
    height: 50px;
    width: auto;
}

/* Stats Grid */
.stats-grid {
    margin-bottom: 2rem;
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

.stat-card-inner {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.users-card .stat-icon { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); }
.cots-card .stat-icon { background: linear-gradient(135deg, var(--warning-color), #fbbf24); }
.locations-card .stat-icon { background: linear-gradient(135deg, var(--info-color), #22d3ee); }
.municipalities-card .stat-icon { background: linear-gradient(135deg, var(--success-color), #34d399); }

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--secondary-color);
    font-weight: 500;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--success-color);
    margin-top: 0.25rem;
}

.stat-trend i {
    font-size: 0.625rem;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

/* Chart Section */
.chart-section .chart-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.chart-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chart-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark-color);
}

.chart-title i {
    color: var(--primary-color);
}

.chart-actions .btn {
    border-radius: var(--radius-md);
    padding: 0.5rem;
}

.chart-body {
    padding: 1.5rem;
}

/* Actions Section */
.actions-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.action-card, .status-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.action-header, .status-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.action-title, .status-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark-color);
}

.action-title i, .status-title i {
    color: var(--primary-color);
}

.action-body {
    padding: 1.5rem;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-lg);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    background: white;
}

.action-btn:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-md);
}

.action-btn.primary { border-left: 4px solid var(--primary-color); }
.action-btn.success { border-left: 4px solid var(--success-color); }
.action-btn.info { border-left: 4px solid var(--info-color); }
.action-btn.warning { border-left: 4px solid var(--warning-color); }

.action-btn.primary:hover { background: rgba(59, 130, 246, 0.05); }
.action-btn.success:hover { background: rgba(16, 185, 129, 0.05); }
.action-btn.info:hover { background: rgba(6, 182, 212, 0.05); }
.action-btn.warning:hover { background: rgba(245, 158, 11, 0.05); }

.action-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.action-btn.primary .action-icon { background: rgba(59, 130, 246, 0.1); color: var(--primary-color); }
.action-btn.success .action-icon { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
.action-btn.info .action-icon { background: rgba(6, 182, 212, 0.1); color: var(--info-color); }
.action-btn.warning .action-icon { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }

.action-content {
    flex: 1;
}

.action-label {
    display: block;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.action-desc {
    font-size: 0.875rem;
    color: var(--secondary-color);
}

/* Status Card */
.status-body {
    padding: 1.5rem;
}

.status-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--dark-color);
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-indicator.online { background: var(--success-color); }
.status-indicator.warning { background: var(--warning-color); }
.status-indicator.offline { background: var(--danger-color); }

/* Recent Activity */
.recent-activity .activity-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.activity-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.activity-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark-color);
}

.activity-title i {
    color: var(--primary-color);
}

.view-all {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.view-all:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

.activity-body {
    padding: 1.5rem;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-lg);
    background: var(--light-color);
    transition: background 0.3s ease;
}

.activity-item:hover {
    background: #e2e8f0;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-md);
    background: rgba(59, 130, 246, 0.1);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.activity-content {
    flex: 1;
}

.activity-text {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--secondary-color);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .stats-row {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem 0;
        margin-bottom: 1.5rem;
    }

    .header-content {
        margin-bottom: 1rem;
    }

    .header-title {
        font-size: 1.5rem;
    }

    .header-subtitle {
        font-size: 0.875rem;
    }

    .header-actions {
        justify-content: center !important;
    }

    .stats-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card-inner {
        padding: 1rem;
        gap: 0.75rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .dashboard-grid {
        gap: 1rem;
    }

    .chart-body {
        padding: 1rem;
    }

    .action-body, .status-body, .activity-body {
        padding: 1rem;
    }

    .action-btn {
        padding: 0.75rem;
        gap: 0.75rem;
    }

    .activity-item {
        padding: 0.75rem;
        gap: 0.75rem;
    }
}

@media (max-width: 576px) {
    .dashboard-header {
        padding: 1rem 0;
    }

    .header-content .header-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .header-title {
        font-size: 1.25rem;
    }

    .brand-logo img {
        height: 40px;
    }

    .stat-card-inner {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .action-btn {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .activity-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}

/* Dark mode support (optional) */
@media (prefers-color-scheme: dark) {
    .admin-dashboard {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    }

    .stat-card, .chart-card, .action-card, .status-card, .activity-card {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }

    .stat-number, .stat-label, .activity-text {
        color: #f9fafb;
    }

    .activity-item {
        background: #4b5563;
    }

    .activity-item:hover {
        background: #6b7280;
    }
}

/* Print styles */
@media print {
    .dashboard-header,
    .action-card,
    .status-card,
    .activity-card {
        display: none;
    }

    .stats-grid,
    .chart-section {
        break-inside: avoid;
    }
}
</style>

<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>

var municipalities = {!! json_encode($municipalities) !!};
var totalCotsArray = {!! json_encode($totalCotsArray) !!};

var baseColors = ['#f44336', '#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#3f51b5'];

var generatedColors = [];
for (var i = 0; i < municipalities.length; i++) {
    if (i < baseColors.length) {
        generatedColors.push(baseColors[i]);
    } else {
        generatedColors.push('#' + Math.floor(Math.random() * 16777215).toString(16));
    }
}

var optionsPieChart = {
    chart: {
        type: 'donut',
        height: 350,
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    series: totalCotsArray,
    labels: municipalities,
    colors: generatedColors,
    dataLabels: {
        enabled: true,
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            colors: ['#fff']
        },
        formatter: function (val, opts) {
            if (opts.series && opts.series[opts.seriesIndex] !== undefined) {
                var totalCots = opts.series[opts.seriesIndex];
                var percentage = (totalCots / opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0)) * 100;
                return totalCots + ' cots (' + percentage.toFixed(2) + '%)';
            } else {
                var municipality = municipalities[opts.seriesIndex];
                return municipality;
            }
        }
    },
    tooltip: {
        theme: 'dark',
        y: {
            formatter: function (val) {
                return val + ' cots';
            }
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '70%', // Adjust the size of the donut
                labels: {
                    show: false // Disable the total label at the center
                }
            }
        }
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '14px',
        fontWeight: 'bold',
        markers: {
            width: 15,
            height: 15,
            radius: 5
        }
    }
};

if (municipalities.length === totalCotsArray.length && municipalities.length > 0) {
    var chartPie = new ApexCharts(document.querySelector("#pieChart"), optionsPieChart);
    chartPie.render();
} else {
    console.error("Data mismatch or empty arrays:", municipalities.length, totalCotsArray.length);
}

</script>



@endsection