<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance History</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #0b1a42;
            --sidebar-hover: #1c336b;
            --sidebar-active: #153fd3;
            --bg-color: #f4f7fe;
            --card-bg: #ffffff;
            --text-main: #2b3674;
            --text-muted: #a3aed1;
            --border-color: #e2e8f0;
            
            --success-color: #05cd99;
            --success-bg: #e6fcf5;
            --danger-color: #ee5d50;
            --danger-bg: #ffebe9;
            --warning-color: #ffce20;
            --warning-bg: #fffbf0;
            --purple-color: #8c62ff;
            --purple-bg: #f4f1ff;
            --blue-color: #4318ff;
            --blue-bg: #f4f7fe;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            display: flex;
            height: 100vh;
            overflow: hidden;
            color: var(--text-main);
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow-y: auto;
        }

        .logo-section {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo-icon {
            font-size: 24px;
            color: #4ea8de;
        }

        .logo-text h2 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .logo-text p {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .menu-label {
            font-size: 11px;
            color: var(--text-muted);
            padding: 20px 24px 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.3s;
            text-decoration: none;
            font-size: 14px;
        }

        .nav-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
        }

        .nav-item:hover {
            background-color: var(--sidebar-hover);
            color: white;
        }

        .nav-item.active-parent {
            color: white;
        }

        .sub-menu {
            list-style: none;
            padding-left: 44px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: 4px;
        }

        .sub-menu li {
            padding: 10px 16px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            border-radius: 6px;
        }
        
        .sub-menu li:hover {
            color: white;
        }

        .sub-menu li.active {
            background-color: var(--sidebar-active);
            color: white;
        }

        .quick-info {
            margin-top: auto;
            padding: 20px;
        }

        .info-card {
            background-color: rgba(255,255,255,0.05);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-card i {
            font-size: 20px;
            color: var(--text-muted);
        }

        .info-text p {
            font-size: 11px;
            color: var(--text-muted);
        }

        .info-text h4 {
            font-size: 13px;
            color: white;
            font-weight: 500;
            margin-top: 2px;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Top Header */
        .header {
            background-color: var(--card-bg);
            height: 70px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            font-size: 20px;
            cursor: pointer;
            color: var(--text-main);
        }

        .page-title h1 {
            font-size: 20px;
            font-weight: 700;
        }

        .breadcrumb {
            font-size: 12px;
            color: #8f9bba;
            margin-top: 4px;
        }
        .breadcrumb span { margin: 0 4px; }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-selector {
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-main);
            background: white;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info h4 {
            font-size: 14px;
            font-weight: 600;
        }

        .profile-info p {
            font-size: 12px;
            color: #8f9bba;
        }

        /* Content Area */
        .dashboard-container {
            padding: 24px 30px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .card-header {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Filter Section */
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: var(--text-main);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            color: var(--text-main);
            outline: none;
            background-color: white;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--sidebar-active);
            color: white;
        }

        .btn-outline {
            background-color: white;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.blue { background: var(--blue-bg); color: var(--sidebar-active); }
        .stat-icon.green { background: var(--success-bg); color: var(--success-color); }
        .stat-icon.red { background: var(--danger-bg); color: var(--danger-color); }
        .stat-icon.yellow { background: var(--warning-bg); color: var(--warning-color); }
        .stat-icon.purple { background: var(--purple-bg); color: var(--purple-color); }

        .stat-details p {
            font-size: 12px;
            color: #8f9bba;
            margin-bottom: 4px;
        }

        .stat-details h3 {
            font-size: 20px;
            font-weight: 700;
        }

        .stat-details span {
            font-size: 11px;
            color: #8f9bba;
        }

        /* Summary Section */
        .summary-wrapper {
            display: flex;
            gap: 24px;
        }

        .summary-stats {
            flex: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .summary-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .summary-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -30px;
            top: 20%;
            height: 60%;
            width: 1px;
            background-color: var(--border-color);
        }

        .s-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .s-icon.blue { background: var(--blue-bg); color: var(--sidebar-active); }
        .s-icon.green { background: var(--success-bg); color: var(--success-color); }
        .s-icon.red { background: var(--danger-bg); color: var(--danger-color); }

        .summary-item p { font-size: 12px; color: #8f9bba; margin-bottom: 4px; }
        .summary-item h3 { font-size: 22px; font-weight: 700; }
        .summary-item span { font-size: 12px; color: #8f9bba; }

        .badge-good {
            background: var(--success-bg);
            color: var(--success-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            margin: 4px 0;
        }

        .attendance-guide {
            flex: 1;
            border-left: 1px solid var(--border-color);
            padding-left: 24px;
        }

        .guide-title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .guide-list {
            list-style: none;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .guide-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .guide-list li::before {
            content: '•';
            font-size: 20px;
            margin-right: 8px;
            line-height: 10px;
        }
        .guide-list li:nth-child(1)::before { color: var(--success-color); }
        .guide-list li:nth-child(2)::before { color: var(--success-color); opacity: 0.7;}
        .guide-list li:nth-child(3)::before { color: var(--warning-color); }
        .guide-list li:nth-child(4)::before { color: var(--danger-color); }

        .badge-sm {
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-excellent { background: var(--success-bg); color: var(--success-color); }
        .badge-avg { background: var(--warning-bg); color: var(--warning-color); }
        .badge-def { background: var(--danger-bg); color: var(--danger-color); }

        /* Table Section */
        .table-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 10px;
            text-align: left;
            font-size: 13px;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            color: #8f9bba;
            font-weight: 600;
            background-color: #fafbfc;
        }

        td {
            color: var(--text-main);
            font-weight: 500;
        }

        tr:hover {
            background-color: #f9fbfd;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-present {
            background-color: var(--success-bg);
            color: var(--success-color);
        }
        
        .status-absent {
            background-color: var(--danger-bg);
            color: var(--danger-color);
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--sidebar-active);
            cursor: pointer;
            font-size: 16px;
            background-color: var(--blue-bg);
            width: 28px;
            height: 28px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .table-footer {
            margin-top: 16px;
            font-size: 12px;
            color: #8f9bba;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-section">
            <i class="fa-solid fa-flask logo-icon"></i>
            <div class="logo-text">
                <h2>PRACTICAL</h2>
                <p>Management System</p>
            </div>
        </div>

        <div class="menu-label">Main Menu</div>
        <ul class="nav-menu">
            <a href="#" class="nav-item">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-book-open"></i> Practicals <i class="fa-solid fa-chevron-down" style="margin-left:auto; font-size:10px;"></i>
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-book"></i> Subjects
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-user-graduate"></i> Students
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-layer-group"></i> Batches
            </a>
            <a href="#" class="nav-item active-parent">
                <i class="fa-solid fa-clipboard-check"></i> Attendance <i class="fa-solid fa-chevron-up" style="margin-left:auto; font-size:10px;"></i>
            </a>
            <ul class="sub-menu">
                <li>Mark Attendance</li>
                <li>Edit Attendance</li>
                <li class="active">Attendance History</li>
            </ul>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-chart-simple"></i> Attendance Report
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-chart-pie"></i> Reports
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
        </ul>

        <div class="menu-label" style="margin-top:20px;">Quick Info</div>
        <div class="quick-info">
            <div class="info-card">
                <i class="fa-regular fa-calendar"></i>
                <div class="info-text">
                    <p>Today's Date</p>
                    <h4>18 May 2025</h4>
                    <p>Sunday</p>
                </div>
            </div>
            <div class="info-card">
                <i class="fa-regular fa-clock"></i>
                <div class="info-text">
                    <p>Current Time</p>
                    <h4 id="clock">10:45 AM</h4>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <i class="fa-solid fa-bars menu-toggle"></i>
                <div>
                    <div class="page-title">
                        <h1>Student Attendance History</h1>
                    </div>
                    <div class="breadcrumb">
                        Dashboard <span>></span> Attendance <span>></span> History
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="date-selector">
                    <i class="fa-regular fa-calendar"></i> 18 May 2025 <i class="fa-solid fa-chevron-down" style="margin-left:10px; font-size:10px;"></i>
                </div>
                <div class="profile-section">
                    <div class="profile-img">
                        <img src="https://ui-avatars.com/api/?name=Prof+S+Patil&background=e2e8f0&color=2b3674" alt="Profile">
                    </div>
                    <div class="profile-info">
                        <h4>Prof. S. Patil</h4>
                        <p>Faculty <i class="fa-solid fa-chevron-down" style="margin-left:5px; font-size:10px;"></i></p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Container -->
        <div class="dashboard-container">
            
            <!-- Filters -->
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-filter" style="color:var(--sidebar-active)"></i> Filter History
                </div>
                <div class="filter-grid">
                    <div class="form-group">
                        <label>Batch</label>
                        <select class="form-control">
                            <option>FY - Batch A</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select class="form-control">
                            <option>Basic Electrical Engineering</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Student</label>
                        <select class="form-control">
                            <option>All Students</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>View Type</label>
                        <select class="form-control">
                            <option>Daily</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Range</label>
                        <div class="form-control" style="display:flex; align-items:center; gap:8px;">
                            <i class="fa-regular fa-calendar"></i> 01 May 2025 - 18 May 2025
                        </div>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-primary"><i class="fa-solid fa-filter"></i> Apply Filter</button>
                    <button class="btn btn-outline"><i class="fa-solid fa-rotate-right"></i> Reset</button>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-details">
                        <p>Total Classes</p>
                        <h3>18</h3>
                        <span>Conducted</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fa-regular fa-circle-check"></i></div>
                    <div class="stat-details">
                        <p>Classes Attended</p>
                        <h3>14</h3>
                        <span>77.78%</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fa-regular fa-circle-xmark"></i></div>
                    <div class="stat-details">
                        <p>Classes Missed</p>
                        <h3>4</h3>
                        <span>22.22%</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon yellow"><i class="fa-solid fa-percent"></i></div>
                    <div class="stat-details">
                        <p>Overall Attendance</p>
                        <h3>77.78%</h3>
                        <span>Good</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fa-regular fa-calendar-check"></i></div>
                    <div class="stat-details">
                        <p>Last Attended</p>
                        <h3>17 May 2025</h3>
                        <span>Saturday</span>
                    </div>
                </div>
            </div>

            <!-- Summary & Guide -->
            <div class="card">
                <div class="card-header">
                    ATTENDANCE SUMMARY (01 May 2025 - 18 May 2025)
                </div>
                <div class="summary-wrapper">
                    <div class="summary-stats">
                        <div class="summary-item">
                            <div class="s-icon blue"><i class="fa-regular fa-calendar"></i></div>
                            <p>Total Days</p>
                            <h3>18</h3>
                            <span>Days</span>
                        </div>
                        <div class="summary-item">
                            <div class="s-icon green"><i class="fa-regular fa-calendar-check"></i></div>
                            <p>Present Days</p>
                            <h3>14</h3>
                            <span>Days</span>
                        </div>
                        <div class="summary-item">
                            <div class="s-icon red"><i class="fa-regular fa-calendar-xmark"></i></div>
                            <p>Absent Days</p>
                            <h3>4</h3>
                            <span>Days</span>
                        </div>
                        <div class="summary-item">
                            <p>Percentage</p>
                            <h3>77.78%</h3>
                            <span>Attendance</span>
                        </div>
                        <div class="summary-item" style="border:none;">
                            <p>Performance</p>
                            <span class="badge-good">Good</span>
                            <span>Keep it up!</span>
                        </div>
                    </div>
                    
                    <div class="attendance-guide">
                        <div class="guide-title">Attendance Guide</div>
                        <ul class="guide-list">
                            <li><span>90% and above</span> <span class="badge-sm badge-excellent">Excellent</span></li>
                            <li><span>75% - 89%</span> <span class="badge-sm badge-excellent">Good</span></li>
                            <li><span>60% - 74%</span> <span class="badge-sm badge-avg">Average</span></li>
                            <li><span>Below 60%</span> <span class="badge-sm badge-def">Defaulter</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="table-header-row">
                    <div class="card-header" style="margin:0;">STUDENT ATTENDANCE HISTORY</div>
                    <button class="btn btn-outline" style="padding: 6px 12px;"><i class="fa-solid fa-download"></i> Export History <i class="fa-solid fa-chevron-down" style="margin-left:5px; font-size:10px;"></i></button>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Topic / Practical</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Marked By</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>18 May 2025</td>
                            <td>Sunday</td>
                            <td>RC Circuit Response</td>
                            <td><span class="status-badge status-present">Present</span></td>
                            <td>-</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>17 May 2025</td>
                            <td>Saturday</td>
                            <td>Half Wave Rectifier</td>
                            <td><span class="status-badge status-present">Present</span></td>
                            <td>Active participation</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>16 May 2025</td>
                            <td>Friday</td>
                            <td>Transistor CE Configuration</td>
                            <td><span class="status-badge status-present">Present</span></td>
                            <td>-</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>15 May 2025</td>
                            <td>Thursday</td>
                            <td>PN Junction Diode Characteristics</td>
                            <td><span class="status-badge status-absent">Absent</span></td>
                            <td>-</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>14 May 2025</td>
                            <td>Wednesday</td>
                            <td>Ohm's Law Verification</td>
                            <td><span class="status-badge status-present">Present</span></td>
                            <td>Good performance</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>13 May 2025</td>
                            <td>Tuesday</td>
                            <td>RC Circuit Response</td>
                            <td><span class="status-badge status-absent">Absent</span></td>
                            <td>Medical leave</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>12 May 2025</td>
                            <td>Monday</td>
                            <td>Half Wave Rectifier</td>
                            <td><span class="status-badge status-present">Present</span></td>
                            <td>-</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>10 May 2025</td>
                            <td>Saturday</td>
                            <td>Transistor CE Configuration</td>
                            <td><span class="status-badge status-present">Present</span></td>
                            <td>-</td>
                            <td>Prof. S. Patil</td>
                            <td><button class="action-btn"><i class="fa-regular fa-eye"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-footer">
                    <i class="fa-solid fa-circle-info"></i> Note: Attendance is calculated based on the selected date range and view type.
                </div>
            </div>

        </div>
    </main>

    <!-- JavaScript -->
    <script>
        // Simple script to update the real-time clock in the sidebar
        function updateTime() {
            const timeElement = document.getElementById('clock');
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            
            timeElement.textContent = hours + ':' + minutes + ' ' + ampm;
        }

        // Update time immediately and then every minute
        updateTime();
        setInterval(updateTime, 60000);
    </script>
</body>
</html>
<?php 
// This space can be used for any backend PHP logic or database connections. 
// For now, it seamlessly renders the required UI as a `.php` file.
?>