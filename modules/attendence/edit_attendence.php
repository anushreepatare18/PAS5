<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practical Management System - Edit Attendance</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            background-color: #f4f6f9;
            color: #333;
            height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #1a1936;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand i {
            font-size: 24px;
            color: #9b51e0;
        }

        .brand h2 {
            font-size: 14px;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .menu-category {
            font-size: 11px;
            color: #7b7e96;
            padding: 15px 20px 5px 20px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .nav-list {
            list-style: none;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            color: #b3b6c8;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .nav-item a:hover, .nav-item.active a {
            background-color: #512da8;
            color: #fff;
        }

        .schedule-card {
            background-color: #262447;
            margin: 15px;
            padding: 15px;
            border-radius: 8px;
            font-size: 12px;
        }

        .schedule-card h4 {
            color: #a5a6f6;
            margin-bottom: 5px;
        }

        .schedule-card p {
            color: #ccc;
            margin-bottom: 10px;
        }

        .btn-view {
            background-color: #512da8;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 12px;
        }

        /* Main Content Styling */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Top Header */
        .header {
            background-color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .breadcrumb {
            font-size: 12px;
            color: #777;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-badge {
            font-size: 13px;
            color: #555;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .user-info h4 {
            font-size: 13px;
        }

        .user-info p {
            font-size: 11px;
            color: #777;
        }

        /* Content Container */
        .container {
            padding: 25px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .page-title i {
            font-size: 20px;
            color: #512da8;
        }

        .page-title h3 {
            color: #333;
            font-size: 18px;
        }

        /* Practical Details Box */
        .details-box {
            background-color: #f0f0ff;
            border: 1px solid #dcdcfe;
            border-radius: 8px;
            padding: 15px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-item i {
            color: #512da8;
            font-size: 16px;
        }

        .detail-item div h5 {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }

        .detail-item div p {
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .icon-blue { background: #e3f2fd; color: #1e88e5; }
        .icon-green { background: #e8f5e9; color: #2e7d32; }
        .icon-red { background: #ffebee; color: #c62828; }
        .icon-orange { background: #fff3e0; color: #ef6c00; }

        .stat-data h4 {
            font-size: 11px;
            color: #777;
        }

        .stat-data p {
            font-size: 20px;
            font-weight: bold;
        }

        /* Table Section */
        .table-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h4 {
            font-size: 14px;
            color: #333;
            text-transform: uppercase;
        }

        .table-actions {
            display: flex;
            gap: 10px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 6px 10px 6px 30px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;
        }

        .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 12px;
        }

        .select-filter {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;
        }

        .btn-update-all {
            background-color: #512da8;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        /* Data Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #fafafa;
            color: #666;
            font-weight: 600;
        }

        .radio-label {
            margin-right: 15px;
            cursor: pointer;
        }

        .status-present { color: #2e7d32; font-weight: 500; }
        .status-absent { color: #c62828; font-weight: 500; }

        .remark-input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
        }

        /* Bottom Buttons */
        .bottom-actions {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-save {
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-reset {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-back {
            background-color: #fff;
            border: 1px solid #c62828;
            color: #c62828;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div>
            <div class="brand">
                <i class="fa-solid fa-flask"></i>
                <h2>PRACTICAL<br><span style="font-size: 10px; color: #a5a6f6;">MANAGEMENT SYSTEM</span></h2>
            </div>

            <div class="menu-category">MAIN MENU</div>
            <ul class="nav-list">
                <li class="nav-item"><a href="#"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class="nav-item"><a href="#"><i class="fa-solid fa-flask"></i> Practicals</a></li>
                <li class="nav-item"><a href="#"><i class="fa-solid fa-book"></i> Subjects</a></li>
                <li class="nav-item"><a href="#"><i class="fa-solid fa-user-graduate"></i> Students</a></li>
                <li class="nav-item"><a href="#"><i class="fa-solid fa-users"></i> Batches</a></li>
                <li class="nav-item active"><a href="#"><i class="fa-solid fa-calendar-check"></i> Attendance</a></li>
                <li class="nav-item"><a href="#"><i class="fa-solid fa-chart-bar"></i> Reports</a></li>
                <li class="nav-item"><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
            </ul>
        </div>

        <div class="schedule-card">
            <h4>Today's Schedule</h4>
            <p>Ohm's Law Verification<br>10:00 AM - 12:00 PM<br>Lab 1</p>
            <button class="btn-view">View Schedule</button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navigation Header -->
        <div class="header">
            <div class="header-left">
                <i class="fa-solid fa-bars" style="cursor: pointer; color: #555;"></i>
                <div class="breadcrumb">
                    Dashboard > Attendance > <b>Edit Attendance</b>
                </div>
            </div>
            <div class="header-right">
                <div class="date-badge">
                    <i class="fa-regular fa-calendar"></i> 18 May 2025
                </div>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/35" alt="User Avatar">
                    <div class="user-info">
                        <h4>Prof. S. Patil</h4>
                        <p>Faculty</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Container -->
        <div class="container">
            <div class="page-title">
                <i class="fa-regular fa-pen-to-square"></i>
                <div>
                    <h3>EDIT ATTENDANCE</h3>
                    <p style="font-size: 12px; color: #666;">Update attendance for the selected practical session</p>
                </div>
            </div>

            <!-- Practical Session Details -->
            <div class="details-box">
                <div class="detail-item">
                    <i class="fa-solid fa-flask"></i>
                    <div>
                        <h5>Practical</h5>
                        <p>Ohm's Law Verification</p>
                    </div>
                </div>
                <div class="detail-item">
                    <i class="fa-solid fa-book"></i>
                    <div>
                        <h5>Subject</h5>
                        <p>Basic Electrical Engineering</p>
                    </div>
                </div>
                <div class="detail-item">
                    <i class="fa-solid fa-users"></i>
                    <div>
                        <h5>Batch</h5>
                        <p>FY - Batch A</p>
                    </div>
                </div>
                <div class="detail-item">
                    <i class="fa-regular fa-calendar-days"></i>
                    <div>
                        <h5>Date</h5>
                        <p>18 May 2025</p>
                    </div>
                </div>
                <div class="detail-item">
                    <i class="fa-regular fa-clock"></i>
                    <div>
                        <h5>Session</h5>
                        <p>Session 1 (10:00 AM - 12:00 PM)</p>
                    </div>
                </div>
                <div class="detail-item">
                    <i class="fa-solid fa-user-tie"></i>
                    <div>
                        <h5>Faculty</h5>
                        <p>Prof. S. Patil</p>
                    </div>
                </div>
            </div>

            <!-- Attendance Summary Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-blue"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-data">
                        <h4>Total Students</h4>
                        <p>30</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-green"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="stat-data">
                        <h4>Present</h4>
                        <p>24</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-red"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div class="stat-data">
                        <h4>Absent</h4>
                        <p>6</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-orange"><i class="fa-solid fa-percent"></i></div>
                    <div class="stat-data">
                        <h4>Attendance Percentage</h4>
                        <p>80%</p>
                    </div>
                </div>
            </div>

            <!-- Student Attendance Table -->
            <div class="table-section">
                <div class="table-header">
                    <h4>Student Attendance</h4>
                    <div class="table-actions">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Search student...">
                        </div>
                        <select class="select-filter">
                            <option>All Status</option>
                            <option>Present</option>
                            <option>Absent</option>
                        </select>
                        <button class="btn-update-all"><i class="fa-solid fa-user-check"></i> Update All Present</button>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Roll No.</th>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Remarks (Optional)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>FE24BE001</td>
                            <td>Aditya Deshmukh</td>
                            <td>
                                <label class="radio-label status-present"><input type="radio" name="s1" checked> Present</label>
                                <label class="radio-label"><input type="radio" name="s1"> Absent</label>
                            </td>
                            <td><input type="text" class="remark-input" placeholder="Enter remarks (optional)"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>FE24BE002</td>
                            <td>Sahil Kulkarni</td>
                            <td>
                                <label class="radio-label"><input type="radio" name="s2"> Present</label>
                                <label class="radio-label status-absent"><input type="radio" name="s2" checked> Absent</label>
                            </td>
                            <td><input type="text" class="remark-input" value="Medical Leave"></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>FE24BE003</td>
                            <td>Rohan Patil</td>
                            <td>
                                <label class="radio-label status-present"><input type="radio" name="s3" checked> Present</label>
                                <label class="radio-label"><input type="radio" name="s3"> Absent</label>
                            </td>
                            <td><input type="text" class="remark-input" placeholder="Enter remarks (optional)"></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>FE24BE004</td>
                            <td>Omkar Jadhav</td>
                            <td>
                                <label class="radio-label status-present"><input type="radio" name="s4" checked> Present</label>
                                <label class="radio-label"><input type="radio" name="s4"> Absent</label>
                            </td>
                            <td><input type="text" class="remark-input" placeholder="Enter remarks (optional)"></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>FE24BE005</td>
                            <td>Tejas More</td>
                            <td>
                                <label class="radio-label"><input type="radio" name="s5"> Present</label>
                                <label class="radio-label status-absent"><input type="radio" name="s5" checked> Absent</label>
                            </td>
                            <td><input type="text" class="remark-input" value="Not Well"></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>FE24BE006</td>
                            <td>Pranav Shinde</td>
                            <td>