<?php
// modules/assessment/regularity.php
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
          <h1 class="dashboard-title mb-1 theme-text">Assessment Management</h1>
          <p class="theme-text-muted mb-0">View, edit, and monitor student regularity & practical scores</p>
        </div>
      </div>

      <!-- Assessment Records Table Card with Search Bar -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card-custom theme-bg theme-border p-4 rounded-3 shadow-sm">
            
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
              <h5 class="card-title-custom mb-0 theme-text">
                <i class="bi bi-journal-text me-2"></i>Assessment Records
              </h5>
              
              <!-- Live Search Bar -->
              <div class="input-group input-group-sm" style="width: 260px;">
                <span class="input-group-text theme-input theme-border"><i class="bi bi-search"></i></span>
                <input type="text" id="assessmentSearchInput" class="form-control theme-input" placeholder="Search student, roll no, subject...">
              </div>
            </div>
            
            <div class="table-responsive">
              <table class="table align-middle mb-0 theme-table theme-table-hover" id="assessmentTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Experiment</th>
                    <th>Marks</th>
                    <th>Remarks</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#9</td>
                    <td>105</td>
                    <td class="fw-medium">Rohit Patil</td>
                    <td>Computer Network</td>
                    <td>Experiment 1 - Introduction</td>
                    <td><span class="badge bg-primary">56 / 100</span></td>
                    <td>-</td>
                    <td>2025-26</td>
                    <td>Sem II</td>
                    <td>23-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#8</td>
                    <td>104</td>
                    <td class="fw-medium">Sneha Joshi</td>
                    <td>Computer Network</td>
                    <td>Experiment 1 - Introduction</td>
                    <td><span class="badge bg-primary">34 / 100</span></td>
                    <td>-</td>
                    <td>2025-26</td>
                    <td>Sem II</td>
                    <td>23-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#7</td>
                    <td>103</td>
                    <td class="fw-medium">Amit Kumar</td>
                    <td>Computer Network</td>
                    <td>Experiment 1 - Introduction</td>
                    <td><span class="badge bg-primary">89 / 100</span></td>
                    <td>-</td>
                    <td>2025-26</td>
                    <td>Sem II</td>
                    <td>23-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#6</td>
                    <td>105</td>
                    <td class="fw-medium">Rohit Patil</td>
                    <td>Computer Network</td>
                    <td>Experiment 1 - Introduction</td>
                    <td><span class="badge bg-primary">90 / 100</span></td>
                    <td>-</td>
                    <td>2026-27</td>
                    <td>Sem III</td>
                    <td>22-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#5</td>
                    <td>104</td>
                    <td class="fw-medium">Sneha Joshi</td>
                    <td>Computer Network</td>
                    <td>Experiment 1 - Introduction</td>
                    <td><span class="badge bg-primary">89 / 100</span></td>
                    <td>-</td>
                    <td>2026-27</td>
                    <td>Sem III</td>
                    <td>22-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#4</td>
                    <td>103</td>
                    <td class="fw-medium">Amit Kumar</td>
                    <td>Computer Network</td>
                    <td>Experiment 1 - Introduction</td>
                    <td><span class="badge bg-primary">67 / 100</span></td>
                    <td>-</td>
                    <td>2026-27</td>
                    <td>Sem III</td>
                    <td>22-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#2</td>
                    <td>104</td>
                    <td class="fw-medium">Sneha Joshi</td>
                    <td>Computer Network</td>
                    <td>Experiment 2 - ER Diagram</td>
                    <td><span class="badge bg-primary">80 / 100</span></td>
                    <td>-</td>
                    <td>2025-26</td>
                    <td>Sem II</td>
                    <td>22-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#1</td>
                    <td>103</td>
                    <td class="fw-medium">Amit Kumar</td>
                    <td>Computer Network</td>
                    <td>Experiment 2 - ER Diagram</td>
                    <td><span class="badge bg-primary">50 / 100</span></td>
                    <td>-</td>
                    <td>2025-26</td>
                    <td>Sem II</td>
                    <td>22-07-2026</td>
                    <td>
                      <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm text-dark fw-bold"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                      </div>
                    </td>
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

<!-- ================= JAVASCRIPT LOGIC ================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('assessmentSearchInput');
    const table = document.getElementById('assessmentTable');
    
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
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
