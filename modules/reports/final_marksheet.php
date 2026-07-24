<?php
// modules/reports/final_marksheet.php
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
  
  /* Form Inputs Adaptability */
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

  /* Print Styles Optimization */
  @media print {
    body { background: #ffffff !important; color: #000000 !important; }
    .no-print, .sidebar-container, nav, .btn-toolbar { display: none !important; }
    main { width: 100% !important; margin: 0 !important; padding: 0 !important; }
    .card-custom { border: none !important; box-shadow: none !important; background: #ffffff !important; color: #000000 !important; }
  }
</style>

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar Area -->
    <div class="col-md-3 col-lg-2 p-0 min-vh-100 sidebar-container no-print">
      <?php include_once __DIR__ . '/../../includes/sidebar.php'; ?>
    </div>

    <!-- Main Content Area -->
    <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
      
      <!-- Title Block & Actions -->
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom theme-border no-print">
        <div>
          <h1 class="dashboard-title mb-1 theme-text">Final Practical Marksheet</h1>
          <p class="theme-text-muted mb-0">Generate, review, and print semester-end consolidated student assessments</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0 gap-2">
          <a href="../dashboard/gfm_dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
          </a>
          <button onclick="window.print();" class="btn btn-primary btn-sm">
            <i class="bi bi-printer me-1"></i>Print Marksheet
          </button>
        </div>
      </div>

      <!-- Filter Controls Card -->
      <div class="card-custom mb-4 no-print">
        <form method="GET" action="" class="row g-3 align-items-end">
          
          <div class="col-md-2">
            <label class="form-label fw-semibold theme-text small">Academic Year</label>
            <select class="form-select form-select-sm theme-input" name="academic_year">
              <option value="2025-26">2025-26</option>
              <option value="2026-27">2026-27</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-semibold theme-text small">Semester</label>
            <select class="form-select form-select-sm theme-input" name="semester">
              <option value="Sem II">Sem II</option>
              <option value="Sem I">Sem I</option>
              <option value="Sem III">Sem III</option>
              <option value="Sem IV">Sem IV</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-semibold theme-text small">Division</label>
            <select class="form-select form-select-sm theme-input" name="division">
              <option value="Div A">Div A</option>
              <option value="Div B" selected>Div B</option>
              <option value="Div C">Div C</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-semibold theme-text small">Batch</label>
            <select class="form-select form-select-sm theme-input" name="batch">
              <option value="B1" selected>Batch B1</option>
              <option value="B2">Batch B2</option>
              <option value="B3">Batch B3</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold theme-text small">Subject</label>
            <select class="form-select form-select-sm theme-input" name="subject">
              <option value="1">Computer Networks Lab</option>
              <option value="2">Web Development Lab</option>
              <option value="3">DBMS Lab</option>
            </select>
          </div>

          <div class="col-md-1">
            <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
          </div>

        </form>
      </div>

      <!-- Marksheet Document Layout Container -->
      <div class="card-custom p-4 theme-bg theme-border shadow-sm">
        
        <!-- Institution Header -->
        <div class="text-center border-bottom theme-border pb-3 mb-4">
          <h3 class="fw-bold text-primary mb-1">INSTITUTE OF TECHNOLOGY & RESEARCH</h3>
          <p class="theme-text-muted small mb-1">Department of Computer Engineering & Information Technology</p>
          <h5 class="fw-semibold theme-text mt-2">CONSOLIDATED PRACTICAL ASSESSMENT MARKSHEET</h5>
        </div>

        <!-- Meta Information Grid -->
        <div class="row g-3 mb-4 theme-text small">
          <div class="col-md-4">
            <strong>Academic Year:</strong> <span class="theme-text-muted">2025-26</span>
          </div>
          <div class="col-md-4">
            <strong>Semester:</strong> <span class="theme-text-muted">Sem II</span>
          </div>
          <div class="col-md-4">
            <strong>Division / Batch:</strong> <span class="theme-text-muted">Division B / Batch B1</span>
          </div>
          <div class="col-md-8">
            <strong>Subject Name:</strong> <span class="theme-text-muted">Computer Networks Lab (Course Code: PC-CS201L)</span>
          </div>
          <div class="col-md-4">
            <strong>Date of Generation:</strong> <span class="theme-text-muted"><?php echo date('d-m-Y'); ?></span>
          </div>
        </div>

        <!-- Marksheet Data Table -->
        <div class="table-responsive mb-5">
          <table class="table table-bordered align-middle theme-table text-center">
            <thead>
              <tr>
                <th rowspan="2" class="align-middle">Sr. No.</th>
                <th rowspan="2" class="align-middle text-start">Roll No & Student Name</th>
                <th colspan="4">Assessment Components</th>
                <th rowspan="2" class="align-middle">Total Marks<br><small class="fw-normal text-muted">(Out of 25)</small></th>
                <th rowspan="2" class="align-middle">Grade / Status</th>
              </tr>
              <tr>
                <th>Regularity<br><small>(5)</small></th>
                <th>Conduction<br><small>(10)</small></th>
                <th>Output<br><small>(5)</small></th>
                <th>Viva<br><small>(5)</small></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td class="text-start fw-medium">3101 - Aarav Sharma</td>
                <td>5</td>
                <td>10</td>
                <td>5</td>
                <td>5</td>
                <td><strong class="text-primary">25</strong></td>
                <td><span class="badge bg-success">EX (Excellent)</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td class="text-start fw-medium">3102 - Ananya Patel</td>
                <td>5</td>
                <td>7</td>
                <td>3</td>
                <td>4</td>
                <td><strong class="text-primary">19</strong></td>
                <td><span class="badge bg-info">GD (Good)</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td class="text-start fw-medium">3103 - Rohan Verma</td>
                <td>0</td>
                <td>5</td>
                <td>2</td>
                <td>3</td>
                <td><strong class="text-danger">10</strong></td>
                <td><span class="badge bg-danger">DEF (Defaulter)</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Grading Guidelines Note -->
        <div class="alert alert-secondary bg-opacity-10 theme-border theme-text small mb-5">
          <strong>Grading Scale:</strong> EX = 22–25 (Excellent), GD = 17–21 (Good), SAT = 12–16 (Satisfactory), DEF = Below 12 (Defaulter / Shortage).
        </div>

        <!-- Signature Block -->
        <div class="row mt-5 pt-4 text-center theme-text">
          <div class="col-4">
            <div class="border-top theme-border pt-2 mt-4 mx-auto" style="width: 80%;">
              <strong>Guardian Faculty (GFM)</strong>
            </div>
          </div>
          <div class="col-4">
            <div class="border-top theme-border pt-2 mt-4 mx-auto" style="width: 80%;">
              <strong>Subject Incharge</strong>
            </div>
          </div>
          <div class="col-4">
            <div class="border-top theme-border pt-2 mt-4 mx-auto" style="width: 80%;">
              <strong>Head of Department (HOD)</strong>
            </div>
          </div>
        </div>

      </div>

    </main>
  </div>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>