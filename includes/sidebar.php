<?php
// includes/sidebar.php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Practical-Assessment-System/');
}
?>

<style>
  /* Sidebar Theme Compatibility */
  .sidebar-wrapper {
    background-color: var(--card-bg, #ffffff) !important;
    border-right: 1px solid var(--border-color, #dee2e6);
  }
  .sidebar-theme-text {
    color: var(--text-color, #212529) !important;
  }
  .sidebar-theme-text-muted {
    color: var(--text-color, #212529) !important;
    opacity: 0.7;
  }
  .sidebar-divider {
    border-color: var(--border-color, #dee2e6) !important;
  }
  /* Fix link colors without breaking hover/active states */
  .sidebar-wrapper a.sidebar-item:not(.active):not(.text-danger), 
  .sidebar-wrapper a.sidebar-subitem {
    color: var(--text-color, #212529) !important;
    transition: all 0.2s ease-in-out;
  }
  .sidebar-wrapper a.sidebar-item:not(.active):not(.text-danger):hover, 
  .sidebar-wrapper a.sidebar-subitem:hover {
    color: var(--primary-color, #0d6efd) !important;
    background-color: rgba(128, 128, 128, 0.1);
  }
</style>

<div class="d-flex flex-column p-3 min-vh-100 sidebar-wrapper">
  
  <!-- Profile Summary -->
  <div class="text-center pb-3 mb-3 border-bottom sidebar-divider">
    <img src="<?php echo BASE_URL; ?>assets/images/icons/avatar-placeholder.png" alt="Profile" class="rounded-circle mb-2" width="65" height="65" style="object-fit: cover;">
    <h6 class="fw-bold mb-0 sidebar-theme-text">Faculty Name</h6>
    <small class="d-block sidebar-theme-text-muted">Computer Engineering</small>
  </div>

  <!-- Sidebar Navigation Links -->
  <ul class="nav nav-pills flex-column mb-auto gap-1">
    
    <!-- 1. GFM Dashboard -->
    <li class="nav-item">
      <a href="<?php echo BASE_URL; ?>modules/dashboard/gfm_dashboard.php" class="sidebar-item">
        <i class="bi bi-speedometer2 me-2"></i> GFM Dashboard
      </a>
    </li>

    <!-- 2. Practicals (Linked to view_practical.php) -->
    <li>
      <a href="<?php echo BASE_URL; ?>modules/practical_management/view_practical.php" class="sidebar-item active">
        <i class="bi bi-journal-plus me-2"></i> Practicals
      </a>
    </li>

    <!-- 3. Assessment -->
    <li>
      <a href="#assessmentSubmenu" data-bs-toggle="collapse" class="sidebar-item d-flex justify-content-between align-items-center">
        <span><i class="bi bi-calculator me-2"></i> Assessment</span>
        <i class="bi bi-chevron-down small"></i>
      </a>
      <div class="collapse ms-3 mt-1" id="assessmentSubmenu">
        <ul class="nav flex-column gap-1 border-start ps-2 sidebar-divider">
          <li>
            <a href="<?php echo BASE_URL; ?>modules/assessment/regularity.php" class="sidebar-subitem">
              <i class="bi bi-eye me-2"></i> View Assessment
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- 4. Attendance -->
    <li>
      <a href="#attendanceSubmenu" data-bs-toggle="collapse" class="sidebar-item d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clipboard-check me-2"></i> Attendance</span>
        <i class="bi bi-chevron-down small"></i>
      </a>
      <div class="collapse ms-3 mt-1" id="attendanceSubmenu">
        <ul class="nav flex-column gap-1 border-start ps-2 sidebar-divider">
          <li>
            <a href="#" class="sidebar-subitem" data-bs-toggle="modal" data-bs-target="#markAttendanceModal">
              <i class="bi bi-pen me-2"></i> Mark Attendance
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-subitem" data-bs-toggle="modal" data-bs-target="#viewAttendanceModal">
              <i class="bi bi-eye me-2"></i> View Attendance
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- 5. Marksheets -->
    <li>
      <a href="<?php echo BASE_URL; ?>modules/reports/final_marksheet.php" class="sidebar-item">
        <i class="bi bi-file-earmark-bar-graph me-2"></i> Marksheets
      </a>
    </li>

    <!-- 6. Reports -->
    <li>
      <a href="<?php echo BASE_URL; ?>modules/reports/student_report.php" class="sidebar-item">
        <i class="bi bi-file-earmark-text me-2"></i> Reports
      </a>
    </li>

    <!-- 7. Settings -->
    <li>
      <a href="<?php echo BASE_URL; ?>modules/settings/settings.php" class="sidebar-item">
        <i class="bi bi-gear me-2"></i> Settings
      </a>
    </li>

    <!-- 8. Logout -->
    <li>
      <a href="<?php echo BASE_URL; ?>modules/authentication/logout.php" class="sidebar-item text-danger">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </a>
    </li>

  </ul>

  <!-- Bottom Institutional Tag -->
  <div class="pt-3 mt-auto border-top text-center sidebar-divider">
    <small class="fw-bold text-primary d-block">PAS - ZCOER</small>
    <small class="sidebar-theme-text-muted" style="font-size: 11px;">Zeal College of Engg, Pune</small>
  </div>
</div>