<?php
// modules/dashboard/gfm_dashboard.php
include_once __DIR__ . '/../../config/config.php';
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
?>

<style>
  /* Dynamic Theme Adapter Classes */
  .theme-text { color: var(--text-color, #212529) !important; }
  .theme-text-muted { color: var(--text-color, #212529) !important; opacity: 0.7; }
  .theme-bg { background-color: var(--card-bg, #ffffff) !important; }
  .theme-border { border-color: var(--border-color, #dee2e6) !important; }
  
  /* Form Inputs Adaptability (Fixes white-on-white issue) */
  .theme-input {
    background-color: var(--input-bg, transparent) !important;
    color: var(--text-color, #212529) !important;
    border: 1px solid var(--border-color, #6c757d) !important;
    color-scheme: dark light;
  }
  .theme-input:focus {
    background-color: var(--input-bg, transparent) !important;
    color: var(--text-color, #212529) !important;
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
  }
  .theme-input option {
    background-color: var(--card-bg, #ffffff) !important;
    color: var(--text-color, #212529) !important;
  }
  
  /* Table Adaptability */
  .theme-table { border-color: var(--border-color, #dee2e6) !important; }
  .theme-table th {
    background-color: rgba(128, 128, 128, 0.1) !important;
    color: var(--text-color, #212529) !important;
    border-bottom: 1px solid var(--border-color, #dee2e6) !important;
  }
  .theme-table td {
    background-color: transparent !important;
    color: var(--text-color, #212529) !important;
    border-bottom: 1px solid var(--border-color, #dee2e6) !important;
  }
  .theme-table-hover tbody tr:hover td {
    background-color: rgba(128, 128, 128, 0.05) !important;
  }
  .btn-close-theme { filter: var(--btn-close-filter, none); }
</style>

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar Area -->
    <div class="col-md-3 col-lg-2 p-0 min-vh-100">
      <?php include_once __DIR__ . '/../../includes/sidebar.php'; ?>
    </div>

    <!-- Main Content Area -->
    <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
      
      <!-- Title Block -->
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom theme-border">
        <div>
          <h1 class="dashboard-title mb-1 theme-text">Guardian Faculty Member(GFM) Dashboard</h1>
          <p class="theme-text-muted mb-0">Practical Assessment Performance & Student Progress Overview</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
          <span class="badge bg-primary px-3 py-2 fs-6 fw-normal">Academic Year 2025-26</span>
        </div>
      </div>

      <!-- KPI Summary Cards -->
      <div class="row mb-4">
        
        <div class="col-xl-3 col-md-6 mb-3">
          <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="theme-text-muted d-block small fw-medium mb-1">Total Assigned Mentees</span>
                <div class="card-value-custom theme-text">60</div>
              </div>
              <div class="p-3 bg-primary bg-opacity-10 rounded-3">
                <i class="bi bi-people-fill text-primary fs-3"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
          <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="theme-text-muted d-block small fw-medium mb-1">Avg Practical Attendance</span>
                <div class="card-value-custom theme-text">92%</div>
              </div>
              <div class="p-3 bg-success bg-opacity-10 rounded-3">
                <i class="bi bi-person-check-fill text-success fs-3"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
          <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="theme-text-muted d-block small fw-medium mb-1">Avg Practical Score</span>
                <div class="card-value-custom theme-text">21 / 25</div>
              </div>
              <div class="p-3 bg-warning bg-opacity-10 rounded-3">
                <i class="bi bi-award-fill text-warning fs-3"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
          <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="theme-text-muted d-block small fw-medium mb-1">Defaulter Students</span>
                <div class="card-value-custom text-danger">4</div>
              </div>
              <div class="p-3 bg-danger bg-opacity-10 rounded-3">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-3"></i>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Batch Progress & Attendance Chart -->
      <div class="row mb-4">
        <div class="col-lg-7 mb-3">
          <div class="card-custom h-100">
            <h5 class="card-title-custom mb-4 theme-text">Batch-wise Experiment Completion Rate</h5>
            
            <div class="mb-4">
              <div class="d-flex justify-content-between mb-2">
                <span class="fw-medium theme-text">Batch B1 (Computer Networks Lab)</span>
                <span class="fw-bold text-primary">85%</span>
              </div>
              <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 85%;"></div>
              </div>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between mb-2">
                <span class="fw-medium theme-text">Batch B2 (Web Development Lab)</span>
                <span class="fw-bold text-primary">92%</span>
              </div>
              <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 92%;"></div>
              </div>
            </div>

            <div class="mb-2">
              <div class="d-flex justify-content-between mb-2">
                <span class="fw-medium theme-text">Batch B3 (Database Management Lab)</span>
                <span class="fw-bold text-primary">78%</span>
              </div>
              <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 78%;"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 mb-3">
          <div class="card-custom h-100">
            <h5 class="card-title-custom mb-3 theme-text">Attendance Distribution</h5>
            <div style="position: relative; height: 230px;">
              <canvas id="attendanceDoughnutChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Overview with Search Bar -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card-custom">
            
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
              <h5 class="card-title-custom mb-0 theme-text">Mentee Performance & Marks Breakdown</h5>
              
              <div class="d-flex align-items-center gap-2">
                <!-- Dashboard Table Search Bar -->
                <div class="input-group input-group-sm" style="width: 250px;">
                  <span class="input-group-text theme-input theme-border"><i class="bi bi-search"></i></span>
                  <input type="text" id="menteeSearchInput" class="form-control theme-input" placeholder="Search roll no or name...">
                </div>
                <a href="../reports/student_report.php" class="btn btn-sm btn-outline-primary">View Report</a>
              </div>
            </div>
            
            <div class="table-responsive">
              <table class="table align-middle mb-0 theme-table theme-table-hover" id="menteeTable">
                <thead>
                  <tr>
                    <th>Roll No</th>
                    <th>Student Name</th>
                    <th>Regularity (5)</th>
                    <th>Conduction (10)</th>
                    <th>Output (5)</th>
                    <th>Viva (5)</th>
                    <th>Total Score (25)</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>3101</td>
                    <td class="fw-medium">Aarav Sharma</td>
                    <td>5</td>
                    <td>10</td>
                    <td>5</td>
                    <td>5</td>
                    <td><strong class="text-primary">25</strong></td>
                    <td><span class="badge bg-success">Excellent</span></td>
                  </tr>
                  <tr>
                    <td>3102</td>
                    <td class="fw-medium">Ananya Patel</td>
                    <td>5</td>
                    <td>7</td>
                    <td>3</td>
                    <td>4</td>
                    <td><strong class="text-primary">19</strong></td>
                    <td><span class="badge bg-info">Good</span></td>
                  </tr>
                  <tr>
                    <td>3103</td>
                    <td class="fw-medium">Rohan Verma</td>
                    <td>0</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td><strong class="text-danger">10</strong></td>
                    <td><span class="badge bg-danger">Defaulter</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

<!-- ================= 1. MARK ATTENDANCE POPUP MODAL ================= -->
<div class="modal fade" id="markAttendanceModal" tabindex="-1" aria-labelledby="markAttendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content theme-bg theme-text theme-border">
      <form id="markAttendanceForm" action="../attendance/save_attendance.php" method="POST">
        
        <div class="modal-header border-bottom theme-border">
          <h5 class="modal-title fw-bold text-primary" id="markAttendanceModalLabel">
            <i class="bi bi-clipboard-check me-2"></i>Mark Practical Attendance
          </h5>
          <button type="button" class="btn-close btn-close-theme" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-4">
            
            <!-- Academic Year Filter -->
            <div class="col-md-4">
              <label class="form-label fw-semibold theme-text">Academic Year</label>
              <select class="form-select theme-input" name="academic_year" required>
                <option value="">Choose Year...</option>
                <option value="2025-26">2025-26</option>
                <option value="2026-27">2026-27</option>
              </select>
            </div>

            <!-- Semester Filter -->
            <div class="col-md-4">
              <label class="form-label fw-semibold theme-text">Semester</label>
              <select class="form-select theme-input" name="semester" required>
                <option value="">Choose Semester...</option>
                <option value="Sem I">Sem I</option>
                <option value="Sem II">Sem II</option>
                <option value="Sem III">Sem III</option>
                <option value="Sem IV">Sem IV</option>
              </select>
            </div>

            <!-- Division Filter -->
            <div class="col-md-4">
              <label class="form-label fw-semibold theme-text">Division</label>
              <select class="form-select theme-input" name="division" required>
                <option value="">Choose Division...</option>
                <option value="Div A">Div A</option>
                <option value="Div B">Div B</option>
                <option value="Div C">Div C</option>
              </select>
            </div>

            <!-- Batch Filter -->
            <div class="col-md-4">
              <label class="form-label fw-semibold theme-text">Select Batch</label>
              <select class="form-select theme-input" name="batch_id" required>
                <option value="">Choose Batch...</option>
                <option value="B1">Batch B1</option>
                <option value="B2">Batch B2</option>
                <option value="B3">Batch B3</option>
              </select>
            </div>

            <!-- Subject Filter -->
            <div class="col-md-4">
              <label class="form-label fw-semibold theme-text">Select Subject</label>
              <select class="form-select theme-input" name="subject_id" required>
                <option value="">Choose Subject...</option>
                <option value="1">Computer Networks Lab</option>
                <option value="2">Web Development Lab</option>
                <option value="3">DBMS Lab</option>
              </select>
            </div>

            <!-- Time Slot Filter -->
            <div class="col-md-4">
              <label class="form-label fw-semibold theme-text">Time Slot</label>
              <select class="form-select theme-input" name="time_slot" required>
                <option value="">Choose Time Slot...</option>
                <option value="09:00 AM - 11:00 AM">09:00 AM - 11:00 AM</option>
                <option value="11:15 AM - 01:15 PM">11:15 AM - 01:15 PM</option>
                <option value="02:00 PM - 04:00 PM">02:00 PM - 04:00 PM</option>
              </select>
            </div>

            <!-- Location / Lab Filter -->
            <div class="col-md-6">
              <label class="form-label fw-semibold theme-text">Location / Lab</label>
              <select class="form-select theme-input" name="location" required>
                <option value="">Choose Location...</option>
                <option value="Lab 1 (NC-301)">Lab 1 (NC-301)</option>
                <option value="Lab 2 (NC-302)">Lab 2 (NC-302)</option>
                <option value="Programming Lab (CC-101)">Programming Lab (CC-101)</option>
              </select>
            </div>

            <!-- Session Date Filter -->
            <div class="col-md-6">
              <label class="form-label fw-semibold theme-text">Session Date</label>
              <input type="date" class="form-control theme-input" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

          </div>

          <!-- Mark Attendance Table Header with Search Bar -->
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h6 class="fw-bold mb-0 text-primary">Student List</h6>
            <div class="input-group input-group-sm" style="width: 220px;">
              <span class="input-group-text theme-input theme-border"><i class="bi bi-search"></i></span>
              <input type="text" id="markSearchInput" class="form-control theme-input" placeholder="Search student...">
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-middle theme-table theme-table-hover" id="markAttendanceTable">
              <thead>
                <tr>
                  <th>Roll No</th>
                  <th>Student Name</th>
                  <th class="text-center">Attendance Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>3101</td>
                  <td class="fw-medium">Aarav Sharma</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <input type="radio" class="btn-check" name="status[3101]" id="p_3101" value="Present" checked>
                      <label class="btn btn-outline-success btn-sm" for="p_3101">Present</label>

                      <input type="radio" class="btn-check" name="status[3101]" id="a_3101" value="Absent">
                      <label class="btn btn-outline-danger btn-sm" for="a_3101">Absent</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>3102</td>
                  <td class="fw-medium">Ananya Patel</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <input type="radio" class="btn-check" name="status[3102]" id="p_3102" value="Present" checked>
                      <label class="btn btn-outline-success btn-sm" for="p_3102">Present</label>

                      <input type="radio" class="btn-check" name="status[3102]" id="a_3102" value="Absent">
                      <label class="btn btn-outline-danger btn-sm" for="a_3102">Absent</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>3103</td>
                  <td class="fw-medium">Rohan Verma</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <input type="radio" class="btn-check" name="status[3103]" id="p_3103" value="Present">
                      <label class="btn btn-outline-success btn-sm" for="p_3103">Present</label>

                      <input type="radio" class="btn-check" name="status[3103]" id="a_3103" value="Absent" checked>
                      <label class="btn btn-outline-danger btn-sm" for="a_3103">Absent</label>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer border-top theme-border">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i>Save Attendance
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- ================= 2. VIEW ATTENDANCE POPUP MODAL ================= -->
<div class="modal fade" id="viewAttendanceModal" tabindex="-1" aria-labelledby="viewAttendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content theme-bg theme-text theme-border">
      
      <div class="modal-header border-bottom theme-border">
        <h5 class="modal-title fw-bold text-primary" id="viewAttendanceModalLabel">
          <i class="bi bi-eye me-2"></i>View Attendance Records
        </h5>
        <button type="button" class="btn-close btn-close-theme" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3 mb-4">
          
          <!-- Academic Year Filter -->
          <div class="col-md-3">
            <label class="form-label fw-semibold theme-text">Academic Year</label>
            <select class="form-select theme-input">
              <option value="2025-26">2025-26</option>
              <option value="2026-27">2026-27</option>
            </select>
          </div>

          <!-- Semester Filter -->
          <div class="col-md-3">
            <label class="form-label fw-semibold theme-text">Semester</label>
            <select class="form-select theme-input">
              <option value="Sem II">Sem II</option>
              <option value="Sem I">Sem I</option>
              <option value="Sem III">Sem III</option>
              <option value="Sem IV">Sem IV</option>
            </select>
          </div>

          <!-- Division Filter -->
          <div class="col-md-3">
            <label class="form-label fw-semibold theme-text">Division</label>
            <select class="form-select theme-input">
              <option value="Div A">Div A</option>
              <option value="Div B">Div B</option>
              <option value="Div C">Div C</option>
            </select>
          </div>

          <!-- Batch Filter -->
          <div class="col-md-3">
            <label class="form-label fw-semibold theme-text">Batch</label>
            <select class="form-select theme-input">
              <option value="B1">Batch B1</option>
              <option value="B2">Batch B2</option>
              <option value="B3">Batch B3</option>
            </select>
          </div>

          <!-- Subject Filter -->
          <div class="col-md-4">
            <label class="form-label fw-semibold theme-text">Subject</label>
            <select class="form-select theme-input">
              <option value="1">Computer Networks Lab</option>
              <option value="2">Web Development Lab</option>
              <option value="3">DBMS Lab</option>
            </select>
          </div>

          <!-- Time Slot Filter -->
          <div class="col-md-4">
            <label class="form-label fw-semibold theme-text">Time Slot</label>
            <select class="form-select theme-input">
              <option value="09:00 AM - 11:00 AM">09:00 AM - 11:00 AM</option>
              <option value="11:15 AM - 01:15 PM">11:15 AM - 01:15 PM</option>
              <option value="02:00 PM - 04:00 PM">02:00 PM - 04:00 PM</option>
            </select>
          </div>

          <!-- Location / Lab Filter -->
          <div class="col-md-4">
            <label class="form-label fw-semibold theme-text">Location / Lab</label>
            <select class="form-select theme-input">
              <option value="Lab 1 (NC-301)">Lab 1 (NC-301)</option>
              <option value="Lab 2 (NC-302)">Lab 2 (NC-302)</option>
              <option value="Programming Lab (CC-101)">Programming Lab (CC-101)</option>
            </select>
          </div>

        </div>

        <!-- View Attendance Table Header with Search Bar -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
          <h6 class="fw-bold mb-0 text-primary">Attendance Summary</h6>
          <div class="input-group input-group-sm" style="width: 220px;">
            <span class="input-group-text theme-input theme-border"><i class="bi bi-search"></i></span>
            <input type="text" id="viewSearchInput" class="form-control theme-input" placeholder="Search student...">
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle theme-table theme-table-hover" id="viewAttendanceTable">
            <thead>
              <tr>
                <th>Roll No</th>
                <th>Student Name</th>
                <th>Total Sessions</th>
                <th>Attended</th>
                <th>Percentage</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr id="view-row-3101">
                <td>3101</td>
                <td class="fw-medium">Aarav Sharma</td>
                <td class="total-sessions">12</td>
                <td class="total-attended">12</td>
                <td class="attendance-percent"><strong class="text-success">100.0%</strong></td>
                <td><span class="badge bg-success attendance-badge">Regular</span></td>
              </tr>
              <tr id="view-row-3102">
                <td>3102</td>
                <td class="fw-medium">Ananya Patel</td>
                <td class="total-sessions">12</td>
                <td class="total-attended">11</td>
                <td class="attendance-percent"><strong class="text-primary">91.6%</strong></td>
                <td><span class="badge bg-success attendance-badge">Regular</span></td>
              </tr>
              <tr id="view-row-3103">
                <td>3103</td>
                <td class="fw-medium">Rohan Verma</td>
                <td class="total-sessions">12</td>
                <td class="total-attended">6</td>
                <td class="attendance-percent"><strong class="text-danger">50.0%</strong></td>
                <td><span class="badge bg-danger attendance-badge">Shortage</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer border-top theme-border">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- ================= JAVASCRIPT LOGIC ================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Reusable Live Search Filtering Helper Function
    function setupTableSearch(inputId, tableId) {
        const searchInput = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        
        if (searchInput && table) {
            searchInput.addEventListener('keyup', function() {
                let filter = searchInput.value.toLowerCase();
                let rows = table.getElementsByTagName('tr');
                
                for (let i = 1; i < rows.length; i++) {
                    let rowText = rows[i].textContent || rows[i].innerText;
                    if (rowText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            });
        }
    }

    // Initialize Search Functionality Across Dashboard & Modals
    setupTableSearch('menteeSearchInput', 'menteeTable');
    setupTableSearch('markSearchInput', 'markAttendanceTable');
    setupTableSearch('viewSearchInput', 'viewAttendanceTable');

    // Mark Attendance Form Submission & View Sync Logic
    const markForm = document.getElementById('markAttendanceForm');
    
    if (markForm) {
        markForm.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const formData = new FormData(this);
            fetch(this.action, {
                method: this.method,
                body: formData
            }).catch(err => console.log('Backend sync warning: ', err)); 
            
            for (let [key, value] of formData.entries()) {
                if (key.startsWith('status[')) {
                    let rollNo = key.match(/\[(\d+)\]/)[1];
                    let status = value; 
                    
                    let viewRow = document.getElementById('view-row-' + rollNo);
                    if (viewRow) {
                        let sessionsCell = viewRow.querySelector('.total-sessions');
                        let attendedCell = viewRow.querySelector('.total-attended');
                        let percentCell = viewRow.querySelector('.attendance-percent');
                        let badgeCell = viewRow.querySelector('.attendance-badge');
                        
                        let sessions = parseInt(sessionsCell.innerText);
                        let attended = parseInt(attendedCell.innerText);
                        
                        sessions += 1;
                        if (status === 'Present') {
                            attended += 1;
                        }
                        
                        let percent = ((attended / sessions) * 100).toFixed(1);
                        
                        sessionsCell.innerText = sessions;
                        attendedCell.innerText = attended;
                        
                        if (percent >= 75) {
                            percentCell.innerHTML = `<strong class="text-success">${percent}%</strong>`;
                            badgeCell.className = "badge bg-success attendance-badge";
                            badgeCell.innerText = "Regular";
                        } else {
                            percentCell.innerHTML = `<strong class="text-danger">${percent}%</strong>`;
                            badgeCell.className = "badge bg-danger attendance-badge";
                            badgeCell.innerText = "Shortage";
                        }
                    }
                }
            }
            
            let markModalEl = document.getElementById('markAttendanceModal');
            let markModal = bootstrap.Modal.getInstance(markModalEl);
            if(markModal) markModal.hide();
            
            let viewModalEl = document.getElementById('viewAttendanceModal');
            let viewModal = new bootstrap.Modal(viewModalEl);
            viewModal.show();
        });
    }
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>