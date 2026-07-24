// Live Clock and Sidebar Toggle Handlers
document.addEventListener("DOMContentLoaded", () => {
    // Live Clock functionality
    function updateClock() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' });
        const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        const dateEl = document.getElementById("currentDate");
        const clockEl = document.getElementById("liveClock");

        if (dateEl) dateEl.innerText = dateStr;
        if (clockEl) clockEl.innerText = timeStr;
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Responsive Mobile Sidebar Toggle
    const toggleBtn = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("show-mobile");
        });
    }
});