<div class="glass-panel p-6 md:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading">Academic Environment View</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure your dashboard viewing scope parameters.</p>
    </div>
    <form class="space-y-6" id="dashboardFilterForm">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex flex-col space-y-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <i class="bi bi-calendar-event text-brand-500"></i> Academic Year
                </label>
                <select id="selectYear" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all shadow-sm cursor-pointer">
                    <option value="2026-27" selected>2026-27</option>
                    <option value="2025-26">2025-26</option>
                </select>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <i class="bi bi-mortarboard text-indigo-500"></i> Year of Study
                </label>
                <select id="selectStudyYear" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm cursor-pointer">
                    <option value="FE">First Year (FE)</option>
                    <option value="SE" selected>Second Year (SE)</option>
                    <option value="TE">Third Year (TE)</option>
                    <option value="BE">Final Year (BE)</option>
                </select>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <i class="bi bi-journal-bookmark text-emerald-500"></i> Semester
                </label>
                <select id="selectSemester" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all shadow-sm cursor-pointer">
                    <option value="1" selected>Semester 1 (Odd)</option>
                    <option value="2">Semester 2 (Even)</option>
                </select>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <i class="bi bi-people text-rose-500"></i> Division
                </label>
                <select id="selectDivision" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-rose-500 outline-none transition-all shadow-sm cursor-pointer">
                    <option value="A">Division A</option>
                    <option value="B">Division B</option>
                    <option value="C" selected>Division C</option>
                </select>
            </div>
        </div>
        <div class="pt-4 border-t border-slate-200 dark:border-slate-800/80 flex items-center justify-end">
            <button type="button" class="bg-gradient-to-r from-brand-600 to-blue-600 hover:from-brand-500 hover:to-blue-500 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/25 flex items-center gap-2 text-sm cursor-pointer">
                <span>Update View</span><i class="bi bi-check-circle"></i>
            </button>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 search-target-container">
    <!-- Attendance Chart -->
    <div class="glass-panel p-5 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg lg:col-span-2 searchable-item">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 id="chartHeading" class="text-base font-bold text-slate-900 dark:text-white font-heading">Division C Attendance (Semester 1)</h3>
                <p id="chartSubheading" class="text-xs text-slate-500 dark:text-slate-400">Subject-wise average attendance for SE Div C - Sem 1</p>
            </div>
            <div class="p-2 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-lg"><i class="bi bi-bar-chart-fill"></i></div>
        </div>
        <div id="divCAttendanceChart" class="w-full h-72"></div>
    </div>

    <!-- Notifications Widget -->
    <div class="glass-panel p-5 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg flex flex-col h-full searchable-item">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-slate-900 dark:text-white font-heading">Notifications</h3>
            <a href="?page=notifications" class="text-xs font-semibold text-brand-600 dark:text-sky-400 hover:underline">View All</a>
        </div>
        <div class="flex-1 space-y-4 overflow-y-auto pr-1 scrollbar-thin">
            <div class="flex gap-3 inner-searchable"><div class="w-2.5 h-2.5 mt-1 rounded-full bg-rose-500 flex-shrink-0 shadow-sm shadow-rose-500/40"></div><div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">5 Faculty pending mark entries.</p><p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1"><i class="bi bi-clock"></i> 10 min ago</p></div></div>
            <div class="flex gap-3 inner-searchable"><div class="w-2.5 h-2.5 mt-1 rounded-full bg-amber-500 flex-shrink-0 shadow-sm shadow-amber-500/40"></div><div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">12 Students below attendance limit.</p><p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1"><i class="bi bi-clock"></i> 30 min ago</p></div></div>
            <div class="flex gap-3 inner-searchable"><div class="w-2.5 h-2.5 mt-1 rounded-full bg-brand-500 flex-shrink-0 shadow-sm shadow-brand-500/40"></div><div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">Mock Practical exam starts tomorrow.</p><p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1"><i class="bi bi-clock"></i> 1 hr ago</p></div></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('divCAttendanceChart')) {
            const options = {
                series: [{ name: 'Attendance %', data: [88, 75, 92, 85, 68] }],
                chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif', foreColor: '#64748b' },
                plotOptions: { bar: { borderRadius: 6, horizontal: false, columnWidth: '45%' } },
                dataLabels: { enabled: false },
                xaxis: { categories: ['DSA', 'OOP', 'DBMS', 'CG', 'DEL'], labels: { style: { fontWeight: 600 } } },
                yaxis: { max: 100, tickAmount: 5 },
                colors: ['#3b82f6'],
                grid: { borderColor: '#e2e8f0', strokeDashArray: 4 },
                theme: { mode: 'light' }
            };
            const chart = new ApexCharts(document.getElementById("divCAttendanceChart"), options);
            chart.render();
            
            window.updateChartThemes = function() {
                const isDark = document.documentElement.classList.contains('dark');
                chart.updateOptions({
                    theme: { mode: isDark ? 'dark' : 'light' },
                    grid: { borderColor: isDark ? '#1e293b' : '#e2e8f0' }
                });
            }
        }
    });
</script>