// Theme Controller & Dashboard Drivers
document.addEventListener("DOMContentLoaded", () => {
  const themeToggleBtn = document.getElementById("themeToggleBtn");
  const themeIcon = document.getElementById("themeIcon");
  const themeLabel = document.getElementById("themeLabel");

  // Load saved theme preference
  const currentTheme = localStorage.getItem("pas_theme") || "light";
  
  if (currentTheme === "dark") {
    document.documentElement.setAttribute("data-theme", "dark");
    if (themeIcon && themeLabel) {
      themeIcon.className = "bi bi-sun-fill text-warning";
      themeLabel.innerText = "Light Mode";
    }
  }

  // Theme Toggle Event Listener
  if (themeToggleBtn) {
    themeToggleBtn.addEventListener("click", () => {
      let theme = document.documentElement.getAttribute("data-theme");

      if (theme === "dark") {
        document.documentElement.removeAttribute("data-theme");
        localStorage.setItem("pas_theme", "light");
        themeIcon.className = "bi bi-moon-stars-fill text-warning";
        themeLabel.innerText = "Dark Mode";
      } else {
        document.documentElement.setAttribute("data-theme", "dark");
        localStorage.setItem("pas_theme", "dark");
        themeIcon.className = "bi bi-sun-fill text-warning";
        themeLabel.innerText = "Light Mode";
      }
    });
  }

  // Attendance Chart Initialization
  const ctx = document.getElementById("attendanceDoughnutChart");
  if (ctx) {
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: ["Present", "Absent", "Defaulter"],
        datasets: [{
          data: [85, 11, 4],
          backgroundColor: ["#10B981", "#F59E0B", "#EF4444"]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: "bottom" }
        }
      }
    });
  }
});