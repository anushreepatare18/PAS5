<?php
// includes/navbar.php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Practical-Assessment-System/');
}
?>
<nav class="navbar navbar-expand-lg border-bottom sticky-top px-4 py-2" style="background-color: var(--card-bg);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" style="color: var(--primary-color);" href="<?php echo BASE_URL; ?>modules/dashboard/gfm_dashboard.php">
      <i class="bi bi-mortarboard-fill me-2"></i> Practical Assessment System
    </a>

    <div class="d-flex align-items-center gap-3 ms-auto">
      <!-- Dark / Light Theme Button -->
      <button id="themeToggleBtn" class="theme-toggle-btn">
        <i class="bi bi-moon-stars-fill text-warning" id="themeIcon"></i>
        <span id="themeLabel">Dark Mode</span>
      </button>

      <div class="vr mx-1"></div>

      <!-- Notifications -->
      <div class="position-relative">
        <i class="bi bi-bell fs-5" style="color: var(--text-color);"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
          3
        </span>
      </div>

      <div class="vr mx-1"></div>

      <!-- Quick Logout -->
      <a href="<?php echo BASE_URL; ?>modules/authentication/logout.php" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>
  </div>
</nav>