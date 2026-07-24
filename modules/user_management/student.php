<div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl space-y-6 search-target-container">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 dark:border-slate-800 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading">Department Students</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">View and manage division-wise student details and marksheets.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs w-full sm:w-64">
                <i class="bi bi-search text-slate-400"></i>
                <input type="text" id="studentSearchInput" onkeyup="filterStudentTable()" placeholder="Search student name..." class="bg-transparent border-none outline-none text-slate-800 dark:text-slate-200 w-full placeholder-slate-400">
            </div>
            <button onclick="exportTableToPDF('studentsTable', 'Department Students', 'Students_List.pdf')" class="bg-rose-100 hover:bg-rose-200 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 px-4 py-2 rounded-xl font-semibold text-xs flex items-center gap-1.5 transition-colors border border-rose-200 dark:border-rose-800">
                <i class="bi bi-file-earmark-pdf-fill text-sm"></i> PDF
            </button>
            <button onclick="exportTableToExcel('studentsTable', 'Students_List.xlsx')" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 px-4 py-2 rounded-xl font-semibold text-xs flex items-center gap-1.5 transition-colors border border-emerald-200 dark:border-emerald-800">
                <i class="bi bi-file-earmark-excel-fill text-sm"></i> Excel
            </button>
        </div>
    </div>

    <!-- Division Filter -->
    <div class="flex items-center gap-3">
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1"><i class="bi bi-funnel"></i> Filter by Division:</span>
        <select id="studentDivFilter" onchange="filterStudentTable()" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-200 outline-none focus:ring-2 focus:ring-brand-500">
            <option value="All">All Divisions</option>
            <option value="Div A">Div A</option>
            <option value="Div B">Div B</option>
            <option value="Div C">Div C</option>
        </select>
    </div>

    <!-- Students Table -->
    <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
        <table id="studentsTable" class="w-full text-sm text-left global-table">
            <thead class="bg-slate-100/70 dark:bg-slate-800/70 text-slate-600 dark:text-slate-300 font-semibold border-b border-slate-200 dark:border-slate-800 text-xs">
                <tr>
                    <th class="p-3.5">Roll No</th>
                    <th class="p-3.5">Student Name</th>
                    <th class="p-3.5">Division</th>
                    <th class="p-3.5 text-center">Avg Attendance</th>
                    <th class="p-3.5 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 bg-white/40 dark:bg-slate-900/40 text-xs font-medium">
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors inner-searchable">
                    <td class="p-3.5 font-bold text-slate-700 dark:text-slate-300">SE-A-101</td>
                    <td class="p-3.5 font-semibold text-slate-900 dark:text-white">Aditi Sharma</td>
                    <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 font-bold text-[11px]">Div A</span></td>
                    <td class="p-3.5 text-center font-bold text-emerald-600">92%</td>
                    <td class="p-3.5 text-center">
                        <button class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
                            <i class="bi bi-download"></i> Marksheet
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterStudentTable() {
        const searchVal = document.getElementById('studentSearchInput').value.toLowerCase();
        const divVal = document.getElementById('studentDivFilter').value;
        const rows = document.querySelectorAll('#studentsTable tbody tr');
        
        rows.forEach(row => {
            const name = row.cells[1].innerText.toLowerCase();
            const roll = row.cells[0].innerText.toLowerCase();
            const div = row.cells[2].innerText.trim();
            const matchesSearch = name.includes(searchVal) || roll.includes(searchVal);
            const matchesDiv = (divVal === 'All' || div === divVal);
            row.style.display = (matchesSearch && matchesDiv) ? '' : 'none';
        });
    }
</script>