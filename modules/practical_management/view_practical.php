<?php
// modules/practical_management/view_practical.php
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

      <!-- Header -->
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom theme-border">
        <div>
          <h2 class="dashboard-title mb-1 theme-text">
            <i class="bi bi-list-task me-2"></i>View Practical
          </h2>
          <p class="theme-text-muted mb-0">View, Edit and Delete Practical Records[cite: 2]</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="../dashboard/gfm_dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
          </a>
        </div>
      </div>

      <!-- Search Card -->
      <div class="card shadow-sm border-0 rounded-4 mb-4 theme-bg theme-border">
        <div class="card-header bg-transparent border-bottom theme-border">
          <h4 class="theme-text fs-5 mb-0">
            <i class="bi bi-search text-primary me-2"></i>Search Practical[cite: 2]
          </h4>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label theme-text fw-semibold small">Subject[cite: 2]</label>
              <select class="form-select theme-input">
                <option>All Subjects[cite: 2]</option>
                <option>Java[cite: 2]</option>
                <option>Python[cite: 2]</option>
                <option>DBMS[cite: 2]</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label theme-text fw-semibold small">Semester[cite: 2]</label>
              <select class="form-select theme-input">
                <option>All Semesters[cite: 2]</option>
                <option>Sem I[cite: 2]</option>
                <option>Sem II[cite: 2]</option>
                <option>Sem III[cite: 2]</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label theme-text fw-semibold small">Search[cite: 2]</label>
              <input type="text" class="form-control theme-input" placeholder="Search Practical[cite: 2]">
            </div>
          </div>
        </div>
      </div>

      <!-- Practical Table -->
      <div class="card shadow-sm border-0 rounded-4 theme-bg theme-border mb-4">
        <div class="card-header bg-transparent border-bottom theme-border">
          <h4 class="theme-text fs-5 mb-0">
            <i class="bi bi-table text-primary me-2"></i>Practical List[cite: 2]
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle theme-table theme-table-hover">
              <thead>
                <tr>
                  <th>Experiment No[cite: 2]</th>
                  <th>Title[cite: 2]</th>
                  <th>Subject[cite: 2]</th>
                  <th>Semester[cite: 2]</th>
                  <th>Date[cite: 2]</th>
                  <th>Status[cite: 2]</th>
                  <th>Action[cite: 2]</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>EXP-101[cite: 2]</td>
                  <td>Introduction to Java[cite: 2]</td>
                  <td>Java[cite: 2]</td>
                  <td>Sem III[cite: 2]</td>
                  <td>21-07-2026[cite: 2]</td>
                  <td>
                    <span class="badge bg-success">Active[cite: 2]</span>
                  </td>
                  <td>
                    <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#viewModal">
                      <i class="bi bi-eye-fill"></i>
                    </button>
                    <button class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-danger btn-sm">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>EXP-102[cite: 2]</td>
                  <td>Database Connection[cite: 2]</td>
                  <td>DBMS[cite: 2]</td>
                  <td>Sem IV[cite: 2]</td>
                  <td>22-07-2026[cite: 2]</td>
                  <td>
                    <span class="badge bg-success">Active[cite: 2]</span>
                  </td>
                  <td>
                    <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#viewModal">
                      <i class="bi bi-eye-fill"></i>
                    </button>
                    <button class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-danger btn-sm">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

<!-- View Practical Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content theme-bg theme-text theme-border">
      <div class="modal-header border-bottom theme-border">
        <h5 class="modal-title fw-bold text-primary">Practical Details[cite: 2]</h5>
        <button type="button" class="btn-close btn-close-theme" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <strong>Experiment No :</strong> EXP-101[cite: 2]
          </div>
          <div class="col-md-6 mb-3">
            <strong>Subject :</strong> Java[cite: 2]
          </div>
          <div class="col-md-6 mb-3">
            <strong>Semester :</strong> Sem III[cite: 2]
          </div>
          <div class="col-md-6 mb-3">
            <strong>Date :</strong> 21-07-2026[cite: 2]
          </div>
          <div class="col-12 mb-3">
            <strong>Title :</strong> Introduction to Java Programming[cite: 2]
          </div>
          <div class="col-12">
            <strong>Description :</strong> This practical introduces students to Java programming concepts.[cite: 2]
          </div>
        </div>
      </div>
      <div class="modal-footer border-top theme-border">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close[cite: 2]</button>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>