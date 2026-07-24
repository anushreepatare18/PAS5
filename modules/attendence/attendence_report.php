<?php
// Attendance Dashboard UI
// Save this file as index.php or dashboard.php and open it in VSCode (using an extension like PHP Server or XAMPP)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --sidebar-bg: #152238;
            --sidebar-hover: #1e2f4c;
            --sidebar-active: #1a56db;
            --text-main: #334155;
            --text-light: #64748b;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --border-color: #e2e8f0;
            --primary-blue: #2563eb;
            --success-green: #10b981;
            --danger-red: #ef4444;
            --warning-orange: #f59e0b;
            --purple: #8b5cf6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--white);
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .logo-section {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo-section i {
            font-size: 24px;
            color: #60a5fa;
        }

        .logo-section div h2 {
            font-size: 14px;
            letter-spacing: 1px;
        }

        .logo-section div p {
            font-size: 10px;
            color: #94a3b8;
        }

        .nav-menu {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }
        
        .nav-menu::-webkit-scrollbar {
            width: 4px;
        }

        .menu-category {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            padding: 0 20px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: 0.2s;
            color: #cbd5e1;
            font-size: 14px;
            text-decoration: none;
        }

        .nav-item:hover {
            background-color: var(--sidebar-hover);
            color: var(--white);
        }

        .nav-item.active {
            background-color: var(--sidebar-active);
            color: var(--white);
            border-radius: 0 20px 20px 0;
            margin-right: 15px;
        }

        .nav-item i {
            width: 20px;
            text-align: center;
        }

        .nav-item .chevron {
            margin-left: auto;
            font-size: 12px;
        }

        .sub-menu {
            background-color: #0f172a;
            padding: 5px 0;
        }

        .sub-item {
            padding: 10px 20px 10px 55px;
            display: block;
            color: #94a3b8;
            font-size: 13px;
            text-decoration: none;
            transition: 0.2s;
        }

        .sub-item:hover {
            color: var(--white);
        }
        
        .sub-item.active {
            background-color: var(--sidebar-active);
            color: var(--white);
            border-radius: 0 20px 20px 0;
            margin-right: 15px;
        }

        .quick-info {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .info-card {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-card i {
            font-size: 20px;
            color: #94a3b8;
        }

        .info-card p {
            font-size: 12px;
            color: #94a3b8;
        }

        .info-card h4 {
            font-size: 14px;
            font-weight: 500;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Navbar */
        .navbar {
            background-color: var(--white);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            font-size: 20px;
            color: var(--text-light);
            cursor: pointer;
        }

        .page-title h1 {
            font-size: 20px;
            color: #0f172a;
        }

        .breadcrumbs {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 5px;
        }
        
        .breadcrumbs span {
            color: var(--primary-blue);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-selector {
            border: 1px solid var(--border-color);
            padding: 8px 15px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-main);
            background: var(--white);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info h4 {
            font-size: 14px;
            color: #0f172a;
        }

        .user-info p {
            font-size: 12px;
            color: var(--text-light);
        }

        /* Dashboard Body */
        .dashboard-body {
            padding: 20px 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Filter Section */
        .card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .filter-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-size: 12px;
            color: var(--text-light);
        }

        .form-control {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            color: var(--text-main);
            outline: none;
            background-color: var(--white);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            color: var(--white);
        }

        .btn-outline {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        /* KPI Cards */
        .kpi-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .kpi-card {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .kpi-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }
        
        .bg-blue-light { background-color: #eff6ff; color: #3b82f6; }
        .bg-green-light { background-color: #f0fdf4; color: #22c55e; }
        .bg-red-light { background-color: #fef2f2; color: #ef4444; }
        .bg-indigo-light { background-color: #eef2ff; color: #6366f1; }
        .bg-purple-light { background-color: #faf5ff; color: #a855f7; }

        .kpi-details p {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 2px;
        }

        .kpi-details h2 {
            font-size: 22px;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .kpi-details span {
            font-size: 11px;
            color: var(--text-light);
        }

        /* Charts Section */
        .charts-container {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 20px;
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            text-transform: uppercase;
        }

        .chart-wrapper {
            position: relative;
            height: 250px;
            width: 100%;
        }

        /* Table Section */
        .table-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            color: var(--text-light);
            font-weight: 500;
            background-color: #f8fafc;
        }

        .performance-bar-container {
            width: 100%;
            height: 4px;
            background-color: var(--border-color);
            border-radius: 2px;
            position: relative;
        }

        .performance-bar {
            height: 100%;
            border-radius: 2px;
            position: absolute;
            left: 0;
            top: 0;
        }

        .performance-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            position: absolute;
            right: -4px;
            top: -2px;
            border: 2px solid var(--white);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }

        .badge-excellent { background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-good { background-color: #f0fdf4; color: #22c55e; border: 1px solid #bbf7d0; }
        .badge-average { background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .badge-warning { background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .badge-defaulter { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        .table-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
            width: 100%;
        }

        .pct-green { color: #16a34a; font-weight: 600; }
        .pct-orange { color: #ea580c; font-weight: 600; }
        .pct-red { color: #dc2626; font-weight: 600; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-section">
            <i class="fa-solid fa-flask"></i>
            <div>
                <h2>PRACTICAL</h2>
                <p>MANAGEMENT SYSTEM</p>
            </div>
        </div>

        <div class="nav-menu">
            <div class="menu-category">MAIN MENU</div>
            
            <a href="#" class="nav-item">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="#" class="nav-item">
                <i class="fa-solid fa-file-alt"></i>
                <span>Practicals</span>
                <i class="fa-solid fa-chevron-down chevron"></i>
            </a>

            <a href="#" class="nav-item">
                <i class="fa-solid fa-book"></i>
                <span>Subjects</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fa-solid fa-user-group"></i>
                <span>Students</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fa-solid fa-layer-group"></i>
                <span>Batches</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fa-solid fa-check-square"></i>
                <span>Attendance</span>
                <i class="fa-solid fa-chevron-up chevron"></i>
            </a>
            
            <div class="sub-menu">
                <a href="#" class="sub-item">
                    <i class="fa-solid fa-user-check" style="margin-right: 8px;"></i> Mark Attendance
                </a>
                <a href="#" class="sub-item">
                    <i class="fa-solid fa-pen-to-square" style="margin-right: 8px;"></i> Edit Attendance
                </a>
                <a href="#" class="sub-item active">
                    <i class="fa-solid fa-chart-simple" style="margin-right: 8px;"></i> Attendance Report
                </a>
            </div>

            <a href="#" class="nav-item">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Reports</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </div>

        <div class="quick-info">
            <div class="menu-category" style="padding:0; margin-bottom:15px;">QUICK INFO</div>
            <div class="info-card">
                <i class="fa-regular fa-calendar"></i>
                <div>
                    <p>Today's Date</p>
                    <h4>18 May 2025</h4>
                    <p>Sunday</p>
                </div>
            </div>
            <div class="info-card">
                <i class="fa-regular fa-clock"></i>
                <div>
                    <p>Current Time</p>
                    <h4 id="clock">10:45 AM</h4>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Navbar -->
        <header class="navbar">
            <div class="nav-left">
                <i class="fa-solid fa-bars menu-toggle"></i>
                <div class="page-title">
                    <h1>Attendance Report Dashboard</h1>
                    <div class="breadcrumbs">
                        <span>Dashboard</span> &gt; Reports &gt; Attendance Report
                    </div>
                </div>
            </div>
            <div class="nav-right">
                <div class="date-selector">
                    <i class="fa-regular fa-calendar"></i>
                    18 May 2025
                    <i class="fa-solid fa-chevron-down" style="font-size:10px; margin-left:5px;"></i>
                </div>
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Prof+S+Patil&background=0D8ABC&color=fff" alt="User Profile">
                    <div class="user-info">
                        <h4>Prof. S. Patil</h4>
                        <p>Faculty</p>
                    </div>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px; color:var(--text-light);"></i>
                </div>
            </div>
        </header>

        <!-- Dashboard Body -->
        <div class="dashboard-body">
            
            <!-- Filters -->
            <div class="card">
                <div class="filter-header">
                    <i class="fa-solid fa-filter"></i> FILTER REPORT
                </div>
                <div class="filter-grid">
                    <div class="form-group">
                        <label>Practical</label>
                        <select class="form-control">
                            <option>All Practicals</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select class="form-control">
                            <option>All Subjects</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Batch</label>
                        <select class="form-control">
                            <option>FY - Batch A</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select class="form-control">
                            <option>Semester 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Range</label>
                        <div class="form-control" style="display:flex; align-items:center; gap:8px;">
                            <i class="fa-regular fa-calendar"></i>
                            01 May 2025 - 18 May 2025
                        </div>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-primary"><i class="fa-solid fa-filter"></i> Apply Filter</button>
                    <button class="btn btn-outline"><i class="fa-solid fa-rotate-right"></i> Reset</button>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="kpi-container">
                <div class="kpi-card">
                    <div class="kpi-icon bg-blue-light"><i class="fa-solid fa-user-group"></i></div>
                    <div class="kpi-details">
                        <p>Total Students</p>
                        <h2>30</h2>
                        <span>100% of Total</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon bg-green-light"><i class="fa-regular fa-circle-check"></i></div>
                    <div class="kpi-details">
                        <p>Total Present</p>
                        <h2>672</h2>
                        <span>74.67%</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon bg-red-light"><i class="fa-regular fa-circle-xmark"></i></div>
                    <div class="kpi-details">
                        <p>Total Absent</p>
                        <h2>228</h2>
                        <span>25.33%</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon bg-indigo-light"><i class="fa-solid fa-percent"></i></div>
                    <div class="kpi-details">
                        <p>Overall Attendance</p>
                        <h2>74.67%</h2>
                        <span>Average</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon bg-purple-light"><i class="fa-regular fa-calendar-check"></i></div>
                    <div class="kpi-details">
                        <p>Total Sessions</p>
                        <h2>12</h2>
                        <span>Conducted</span>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-container">
                <div class="card">
                    <div class="chart-header">
                        <div class="chart-title">ATTENDANCE OVERVIEW <span style="text-transform:none; font-weight:400; color:#94a3b8;">(Daily / Weekly / Monthly)</span></div>
                        <select class="form-control" style="width: auto; padding: 4px 10px;">
                            <option>Daily View</option>
                        </select>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <div class="chart-header">
                        <div class="chart-title">ATTENDANCE TREND <span style="text-transform:none; font-weight:400; color:#94a3b8;">(Daily / Weekly / Monthly)</span></div>
                        <select class="form-control" style="width: auto; padding: 4px 10px;">
                            <option>Monthly View</option>
                        </select>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="table-header-flex">
                    <div class="chart-title">STUDENT ATTENDANCE PERFORMANCE TRACKER <span style="text-transform:none; font-weight:400; color:#94a3b8;">(Yearly)</span></div>
                    <select class="form-control" style="width: auto; padding: 4px 10px;">
                        <option>Yearly View</option>
                    </select>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Student Name</th>
                            <th width="15%" style="text-align: center;">Yearly Attendance</th>
                            <th width="45%">Performance Indicator</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rahul Sharma</td>
                            <td class="text-center pct-green">92%</td>
                            <td>
                                <div class="performance-bar-container">
                                    <div class="performance-bar" style="width: 92%; background-color: #22c55e;">
                                        <div class="performance-dot" style="background-color: #22c55e;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-excellent">Excellent</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Priya Patil</td>
                            <td class="text-center pct-green">85%</td>
                            <td>
                                <div class="performance-bar-container">
                                    <div class="performance-bar" style="width: 85%; background-color: #22c55e;">
                                        <div class="performance-dot" style="background-color: #22c55e;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-good">Good</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Akash More</td>
                            <td class="text-center pct-green">76%</td>
                            <td>
                                <div class="performance-bar-container">
                                    <div class="performance-bar" style="width: 76%; background-color: #22c55e;">
                                        <div class="performance-dot" style="background-color: #22c55e;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-average">Average</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Sneha Joshi</td>
                            <td class="text-center pct-orange">68%</td>
                            <td>
                                <div class="performance-bar-container">
                                    <div class="performance-bar" style="width: 68%; background-color: #f59e0b;">
                                        <div class="performance-dot" style="background-color: #f59e0b;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-warning">Warning</span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Amit Kale</td>
                            <td class="text-center pct-red">59%</td>
                            <td>
                                <div class="performance-bar-container">
                                    <div class="performance-bar" style="width: 59%; background-color: #ef4444;">
                                        <div class="performance-dot" style="background-color: #ef4444;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-defaulter">Defaulter</span></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Pooja Deshmukh</td>
                            <td class="text-center pct-red">48%</td>
                            <td>
                                <div class="performance-bar-container">
                                    <div class="performance-bar" style="width: 48%; background-color: #ef4444;">
                                        <div class="performance-dot" style="background-color: #ef4444;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-defaulter">Defaulter</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-actions">
                    <div style="flex:1;"></div>
                    <button class="btn btn-outline" style="color:var(--primary-blue); font-weight:500;"><i class="fa-solid fa-chart-column"></i> View Complete Report</button>
                    <div style="flex:1; text-align:right;">
                        <button class="btn btn-primary" style="background-color:#1e3a8a;"><i class="fa-solid fa-file-excel"></i> Export to Excel</button>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <script>
        // Real-time clock update (Simulated based on image for aesthetics)
        function updateTime() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; 
            minutes = minutes < 10 ? '0' + minutes : minutes;
            document.getElementById('clock').innerText = hours + ':' + minutes + ' ' + ampm;
        }
        setInterval(updateTime, 60000); // Update every minute

        // Charts JS Initialization
        const ctxOverview = document.getElementById('overviewChart').getContext('2d');
        const ctxTrend = document.getElementById('trendChart').getContext('2d');

        // Overview Chart (Daily)
        const labelsDaily = ['01 May','02 May','03 May','04 May','05 May','06 May','07 May','08 May','09 May','10 May','11 May','12 May','13 May','14 May','15 May','16 May','17 May','18 May'];
        const dataPresent = [75, 78, 72, 80, 76, 70, 74, 79, 82, 68, 71, 77, 78, 75, 73, 76, 79, 75];
        const dataAbsent = [25, 22, 28, 20, 24, 30, 26, 21, 18, 32, 29, 23, 22, 25, 27, 24, 21, 25];

        new Chart(ctxOverview, {
            type: 'line',
            data: {
                labels: labelsDaily,
                datasets: [
                    {
                        label: 'Present (%)',
                        data: dataPresent,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 3
                    },
                    {
                        label: 'Absent (%)',
                        data: dataAbsent,
                        borderColor: '#2563eb',
                        borderWidth: 1.5,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, boxWidth: 8, font: {size: 11} }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: function(value) { return value + "%" }, stepSize: 25, font: {size: 10} }
                    },
                    x: { ticks: { font: {size: 9} }, grid: {display: false} }
                }
            }
        });

        // Trend Chart (Monthly)
        const labelsMonthly = ['Jan 2025', 'Feb 2025', 'Mar 2025', 'Apr 2025', 'May 2025'];
        const dataTrend = [72, 76, 79, 74, 75];

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: labelsMonthly,
                datasets: [{
                    label: 'Trend',
                    data: dataTrend,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2563eb',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    datalabels: { display: true, align: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: function(value) { return value + "%" }, stepSize: 25, font: {size: 10} }
                    },
                    x: { ticks: { font: {size: 11} }, grid: {display: false} }
                }
            },
            plugins: [{
                afterDraw: function(chart) {
                    var ctx = chart.ctx;
                    chart.data.datasets.forEach(function(dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function(element, index) {
                                ctx.fillStyle = '#64748b';
                                var fontSize = 11;
                                var fontStyle = 'normal';
                                var fontFamily = 'Inter';
                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
                                var dataString = dataset.data[index].toString() + '%';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                var padding = 15;
                                var position = element.tooltipPosition();
                                ctx.fillText(dataString, position.x, position.y - padding);
                            });
                        }
                    });
                }
            }]
        });
    </script>
</body>
</html>