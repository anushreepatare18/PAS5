<?php
// --- Start Session for Profile Data ---
session_start();

// Initialize Profile Data in Session if it doesn't exist
if (!isset($_SESSION['profile_data'])) {
    $_SESSION['profile_data'] = [
        'name' => 'Prof. John Smith',
        'designation' => 'Head of Department',
        'personal' => [
            'Employee ID' => 'EMP-2026-ECE', 'Designation' => 'Head of Department', 
            'Department' => 'Electronics and Computer Engineering', 'Qualification' => 'Ph.D., M.Tech.', 
            'Gender' => 'Male', 'Date of Birth' => '1980-05-15'
        ],
        'contact' => [
            'Official Email ID' => 'hod.ece@zeal.edu', 'Personal Email' => 'john.smith@gmail.com', 
            'Mobile Number' => '+91 9876543210', 'Office Extension' => 'Ext. 405', 
            'Office Location' => 'Building A, Room 302', 'Address' => '123 University Road, Pune'
        ],
        'prof' => [
            'Date of Joining' => '2010-07-01', 'Years of Experience' => '16 Years', 
            'Specialization' => 'VLSI & Embedded Systems', 'Current Role' => 'HOD & Professor', 
            'Employee Type' => 'Permanent', 'Reporting Authority' => 'Principal', 'Office Timings' => '09:00 AM - 05:00 PM'
        ],
        'acad' => [
            'Subjects Assigned' => 'VLSI Design, Signals', 'Classes Handled' => 'TE, BE', 
            'Semester' => 'Semester 1 (Odd)', 'Academic Year' => '2026-27', 
            'Practical Subjects' => 'VLSI Lab', 'Faculty Supervised' => '24', 'Student Count' => '450'
        ]
    ];
}

// --- Handle Profile Update Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    if(isset($_POST['profile_name'])) {
        $_SESSION['profile_data']['name'] = htmlspecialchars($_POST['profile_name']);
    }
    
    $categories = ['personal', 'contact', 'prof', 'acad'];
    foreach($categories as $cat) {
        if(isset($_POST[$cat]) && is_array($_POST[$cat])) {
            foreach($_POST[$cat] as $key => $val) {
                // Replacing underscores with spaces to match array keys
                $realKey = str_replace('_', ' ', $key); 
                if(array_key_exists($realKey, $_SESSION['profile_data'][$cat])) {
                    $_SESSION['profile_data'][$cat][$realKey] = htmlspecialchars($val);
                }
            }
        }
    }
    // Redirect to prevent form resubmission
    header("Location: ?page=profile&success=1");
    exit;
}

// Assign active profile data to a variable
$profile = $_SESSION['profile_data'];
// Parse first/last name for the Avatar initials
$nameParts = explode(' ', str_replace('Prof. ', '', $profile['name']));
$initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

// --- Navigation Data Structure ---
$sidebarNavItems = [
    ["name" => "Dashboard", "icon" => "bi-grid-1x2-fill", "slug" => "dashboard"],
    ["name" => "Students", "icon" => "bi-people-fill", "slug" => "students"],
    ["name" => "My Profile", "icon" => "bi-person-badge", "slug" => "profile"],
    ["name" => "Reports", "icon" => "bi-file-earmark-bar-graph-fill", "slug" => "reports"], 
    ["name" => "Timetable", "icon" => "bi-clock-fill", "slug" => "timetable"],
    ["name" => "Notifications", "icon" => "bi-bell-fill", "slug" => "notifications"],
    ["name" => "Settings", "icon" => "bi-gear-fill", "slug" => "settings"]
];

// Determine current page (default to dashboard)
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard - Practical Assessment System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a', dark: '#0a1128', card: '#121e3d' }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- SheetJS CDN for Excel Export -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <!-- jsPDF & AutoTable CDN for PDF Export & Marksheet Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

    <style>
        .glass-panel { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .dark .glass-panel { background: rgba(18, 30, 61, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
        
        select, input[type="date"], input[type="time"] {
            -webkit-appearance: none; -moz-appearance: none; appearance: none;
        }
        
        /* Edit Mode Toggles */
        .edit-mode-input { display: none; }
        .is-editing .edit-mode-input { display: block; }
        .is-editing .view-mode-text { display: none; }

        /* Smooth accordion transitions */
        .accordion-content { transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out; max-height: 0; opacity: 0; overflow: hidden; }
        .accordion-content.expanded { max-height: 300px; opacity: 1; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#070d1e] text-slate-800 dark:text-slate-100 flex h-screen overflow-hidden transition-colors duration-300 font-sans antialiased">

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="w-72 bg-brand-900 dark:bg-brand-dark text-slate-200 flex flex-col justify-between flex-shrink-0 transition-all duration-300 z-30 fixed lg:static inset-y-0 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none border-r border-blue-900/40">
        <div>
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-blue-800/40 bg-gradient-to-r from-blue-950/80 to-brand-900 dark:from-brand-dark dark:to-blue-950/40">
                <div class="flex items-start space-x-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 to-sky-400 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-500/30 flex-shrink-0 ring-2 ring-white/10">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="flex flex-col">
                        <h1 class="font-extrabold text-white text-[13px] leading-snug tracking-wide font-heading">
                            ZES's Zeal College of<br>Engineering & Research
                        </h1>
                        <div class="mt-1.5 flex items-center gap-1.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold tracking-wider uppercase bg-sky-400/20 text-sky-300 border border-sky-400/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span> HOD Portal
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-3 space-y-1 overflow-y-auto max-h-[calc(100vh-160px)] scrollbar-thin">
                <?php foreach ($sidebarNavItems as $item): ?>
                    <?php 
                        $isActive = ($currentPage === $item['slug']);
                        $activeClass = $isActive 
                            ? "bg-gradient-to-r from-brand-600 to-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20 ring-1 ring-white/20" 
                            : "text-slate-300 hover:bg-white/5 hover:text-white"; 
                    ?>
                    <a href="?page=<?php echo $item['slug']; ?>" class="group relative flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 <?php echo $activeClass; ?>">
                        <i class="<?php echo $item['icon']; ?> text-base opacity-90 group-hover:scale-110 transition-transform"></i>
                        <span class="tracking-wide"><?php echo htmlspecialchars($item['name']); ?></span>
                        <?php if ($isActive): ?>
                            <span class="ml-auto w-2 h-2 rounded-full bg-white shadow-xs"></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Sidebar Footer / Sign Out -->
        <div class="p-3 border-t border-blue-900/40 bg-black/20">
            <button class="w-full flex items-center justify-center space-x-2 bg-rose-500/10 hover:bg-rose-600 text-rose-300 hover:text-white py-2.5 px-4 rounded-xl font-medium text-xs transition-all duration-200 border border-rose-500/20">
                <i class="bi bi-box-arrow-right text-sm"></i>
                <span>Sign Out</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <!-- Top Header -->
        <header class="bg-white/80 dark:bg-brand-card/80 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-3 flex items-center justify-between sticky top-0 z-20 shadow-xs transition-colors duration-300">
            <div class="flex items-center space-x-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-700 dark:text-slate-200 text-2xl focus:outline-none p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1 class="text-base md:text-lg font-bold text-slate-900 dark:text-white font-heading leading-tight flex items-center gap-2">
                        <?php 
                            if($currentPage === 'dashboard') echo "HOD Dashboard";
                            else echo ucfirst(str_replace('-', ' ', $currentPage));
                        ?>
                    </h1>
                    <div class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        <span class="inline-flex items-center gap-1.5 font-semibold text-brand-600 dark:text-sky-400">
                            <i class="bi bi-shield-check"></i> Department of Electronics and Computer Engineering
                        </span>
                    </div>
                </div>
            </div>

            <!-- Header Quick Tools & Profile -->
            <div class="flex items-center space-x-3">
                <div class="hidden md:flex items-center space-x-2 bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 rounded-xl px-3 py-1.5 text-xs text-slate-400 w-48 focus-within:w-64 transition-all">
                    <i class="bi bi-search"></i>
                    <input type="text" id="globalSearchInput" onkeyup="globalSearch()" placeholder="Search..." class="bg-transparent border-none outline-none text-slate-800 dark:text-slate-200 w-full placeholder-slate-400">
                </div>

                <button onclick="toggleDarkMode()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-sm border border-slate-200 dark:border-slate-700/60">
                    <i id="themeIcon" class="bi bi-moon-stars-fill"></i>
                </button>

                <!-- Clickable Notification Icon -->
                <a href="?page=notifications" class="relative cursor-pointer p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all border border-slate-200 dark:border-slate-700/60">
                    <i class="bi bi-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-brand-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold ring-2 ring-white dark:ring-slate-900">3</span>
                </a>

                <div class="flex items-center space-x-2.5 pl-2 border-l border-slate-200 dark:border-slate-700/60">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-600 p-0.5 shadow-md">
                        <div class="w-full h-full bg-white dark:bg-slate-900 rounded-[10px] flex items-center justify-center font-bold text-brand-600 dark:text-sky-400 text-xs">
                            <?php echo $initials; ?>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <p class="font-bold text-slate-900 dark:text-white text-xs leading-tight"><?php echo htmlspecialchars($profile['name']); ?></p>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400"><?php echo htmlspecialchars($profile['designation']); ?></p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="p-4 md:p-6 w-full max-w-7xl mx-auto space-y-6">
            
            <?php if ($currentPage === 'dashboard'): ?>
            <!-- ======================= DASHBOARD SCREEN ======================= -->
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

            <!-- Dashboard Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 search-target-container">
                <!-- Interactive Attendance Chart -->
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

                <!-- Notifications List -->
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

                <!-- Faculty Status -->
                <div class="glass-panel p-5 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg lg:col-span-1 searchable-item">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white font-heading">Faculty Status</h3>
                        <div class="p-2 bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-lg"><i class="bi bi-people-fill"></i></div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/50 inner-searchable">
                            <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-500"></div><span class="text-sm font-bold text-slate-800 dark:text-slate-200">Active / In Lab</span></div>
                            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">18</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded-lg bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/50 inner-searchable">
                            <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-amber-500"></div><span class="text-sm font-bold text-slate-800 dark:text-slate-200">On Leave today</span></div>
                            <span class="text-lg font-bold text-amber-600 dark:text-amber-400">2</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded-lg bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/50 inner-searchable">
                            <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-500"></div><span class="text-sm font-bold text-slate-800 dark:text-slate-200">Pending Evaluation</span></div>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">4</span>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Top 5 Scorer Students -->
                <div class="glass-panel p-5 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg lg:col-span-2 searchable-item">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 id="topScorersHeading" class="text-base font-bold text-slate-900 dark:text-white font-heading">Top 5 Scorers (SE Div C - Semester 1)</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Based on recent practical assessments.</p>
                        </div>
                        <div class="p-2 bg-amber-100 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg"><i class="bi bi-trophy-fill"></i></div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left global-table">
                            <thead class="bg-slate-100/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">
                                <tr><th class="p-3">Rank</th><th class="p-3">Student Name</th><th class="p-3">Roll No.</th><th class="p-3 text-right">Avg Score</th></tr>
                            </thead>
                            <tbody id="topScorersBody" class="divide-y divide-slate-100 dark:divide-slate-800/50">
                                <tr class="inner-searchable"><td class="p-3 font-bold text-amber-500">#1</td><td class="p-3 font-semibold dark:text-white">Aarav Sharma</td><td class="p-3 text-slate-500">SE-C-101</td><td class="p-3 text-right font-bold text-brand-600 dark:text-sky-400">96%</td></tr>
                                <tr class="inner-searchable"><td class="p-3 font-bold text-slate-400">#2</td><td class="p-3 font-semibold dark:text-white">Riya Patel</td><td class="p-3 text-slate-500">SE-C-145</td><td class="p-3 text-right font-bold text-brand-600 dark:text-sky-400">94.5%</td></tr>
                                <tr class="inner-searchable"><td class="p-3 font-bold text-amber-700 dark:text-amber-600">#3</td><td class="p-3 font-semibold dark:text-white">Kunal Verma</td><td class="p-3 text-slate-500">SE-C-122</td><td class="p-3 text-right font-bold text-brand-600 dark:text-sky-400">92%</td></tr>
                                <tr class="inner-searchable"><td class="p-3 font-bold text-slate-600 dark:text-slate-400">#4</td><td class="p-3 font-semibold dark:text-white">Neha Gupta</td><td class="p-3 text-slate-500">SE-C-110</td><td class="p-3 text-right font-bold text-brand-600 dark:text-sky-400">91.5%</td></tr>
                                <tr class="inner-searchable"><td class="p-3 font-bold text-slate-600 dark:text-slate-400">#5</td><td class="p-3 font-semibold dark:text-white">Sahil Joshi</td><td class="p-3 text-slate-500">SE-C-155</td><td class="p-3 text-right font-bold text-brand-600 dark:text-sky-400">90%</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activities (Cards) -->
                <div class="glass-panel p-5 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg lg:col-span-3 searchable-item">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white font-heading">Recent Activities</h3>
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-lg"><i class="bi bi-activity"></i></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 flex flex-col gap-2 inner-searchable"><div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm mb-1"><i class="bi bi-cloud-arrow-up-fill"></i></div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">Faculty uploaded Practical Marks</p><p class="text-xs text-slate-500 dark:text-slate-400 mt-auto pt-2">10 mins ago</p></div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 flex flex-col gap-2 inner-searchable"><div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm mb-1"><i class="bi bi-patch-check-fill"></i></div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">Journal Verification Completed</p><p class="text-xs text-slate-500 dark:text-slate-400 mt-auto pt-2">25 mins ago</p></div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 flex flex-col gap-2 inner-searchable"><div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm mb-1"><i class="bi bi-person-check-fill"></i></div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">Attendance Updated</p><p class="text-xs text-slate-500 dark:text-slate-400 mt-auto pt-2">40 mins ago</p></div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 flex flex-col gap-2 inner-searchable"><div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm mb-1"><i class="bi bi-calendar2-week-fill"></i></div><p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">Practical Schedule Generated</p><p class="text-xs text-slate-500 dark:text-slate-400 mt-auto pt-2">1 hr ago</p></div>
                    </div>
                </div>
            </div>

            <?php elseif ($currentPage === 'students'): ?>
            <!-- ======================= STUDENTS SCREEN ======================= -->
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

                <!-- Division Filter Bar -->
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1"><i class="bi bi-funnel"></i> Filter by Division:</span>
                    <select id="studentDivFilter" onchange="filterStudentTable()" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-200 outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="All">All Divisions</option>
                        <option value="Div A">Div A</option>
                        <option value="Div B">Div B</option>
                        <option value="Div C">Div C</option>
                    </select>
                </div>

                <!-- Students Table with Download Marksheet Functionality -->
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
                                    <button onclick="downloadStudentMarksheet('SE-A-101', 'Aditi Sharma', 'Div A', '92%')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
                                        <i class="bi bi-download"></i> Marksheet
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors inner-searchable">
                                <td class="p-3.5 font-bold text-slate-700 dark:text-slate-300">SE-A-115</td>
                                <td class="p-3.5 font-semibold text-slate-900 dark:text-white">Vikram Singh</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 font-bold text-[11px]">Div A</span></td>
                                <td class="p-3.5 text-center font-bold text-emerald-600">76%</td>
                                <td class="p-3.5 text-center">
                                    <button onclick="downloadStudentMarksheet('SE-A-115', 'Vikram Singh', 'Div A', '76%')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
                                        <i class="bi bi-download"></i> Marksheet
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors inner-searchable">
                                <td class="p-3.5 font-bold text-slate-700 dark:text-slate-300">SE-B-205</td>
                                <td class="p-3.5 font-semibold text-slate-900 dark:text-white">Sanya Kapoor</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 font-bold text-[11px]">Div B</span></td>
                                <td class="p-3.5 text-center font-bold text-emerald-600">88%</td>
                                <td class="p-3.5 text-center">
                                    <button onclick="downloadStudentMarksheet('SE-B-205', 'Sanya Kapoor', 'Div B', '88%')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
                                        <i class="bi bi-download"></i> Marksheet
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors inner-searchable">
                                <td class="p-3.5 font-bold text-slate-700 dark:text-slate-300">SE-B-222</td>
                                <td class="p-3.5 font-semibold text-slate-900 dark:text-white">Rohan Das</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 font-bold text-[11px]">Div B</span></td>
                                <td class="p-3.5 text-center font-bold text-rose-500">64%</td>
                                <td class="p-3.5 text-center">
                                    <button onclick="downloadStudentMarksheet('SE-B-222', 'Rohan Das', 'Div B', '64%')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
                                        <i class="bi bi-download"></i> Marksheet
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors inner-searchable">
                                <td class="p-3.5 font-bold text-slate-700 dark:text-slate-300">SE-C-101</td>
                                <td class="p-3.5 font-semibold text-slate-900 dark:text-white">Aarav Sharma</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-bold text-[11px]">Div C</span></td>
                                <td class="p-3.5 text-center font-bold text-emerald-600">96%</td>
                                <td class="p-3.5 text-center">
                                    <button onclick="downloadStudentMarksheet('SE-C-101', 'Aarav Sharma', 'Div C', '96%')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
                                        <i class="bi bi-download"></i> Marksheet
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors inner-searchable">
                                <td class="p-3.5 font-bold text-slate-700 dark:text-slate-300">SE-C-145</td>
                                <td class="p-3.5 font-semibold text-slate-900 dark:text-white">Riya Patel</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-bold text-[11px]">Div C</span></td>
                                <td class="p-3.5 text-center font-bold text-emerald-600">94.5%</td>
                                <td class="p-3.5 text-center">
                                    <button onclick="downloadStudentMarksheet('SE-C-145', 'Riya Patel', 'Div C', '94.5%')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-brand-600 dark:text-sky-300 hover:bg-brand-600 hover:text-white transition-all border border-blue-200 dark:border-blue-800 font-semibold">
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
            
            <?php elseif ($currentPage === 'profile'): ?>
            <!-- ======================= MY PROFILE SCREEN ======================= -->
            <form method="POST" action="?page=profile" id="profileContainer" class="space-y-6">
                <!-- Hidden inputs for logic -->
                <input type="hidden" name="update_profile" value="1">
                
                <?php if (isset($_GET['success'])): ?>
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline font-semibold"><i class="bi bi-check-circle-fill"></i> Profile updated successfully!</span>
                </div>
                <?php endif; ?>

                <!-- Profile Header -->
                <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-brand-600 to-indigo-600 p-1 shadow-lg relative group">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($profile['name']); ?>&background=random&color=fff" alt="Profile Photo" class="w-full h-full rounded-[12px] object-cover">
                            <div class="edit-mode-input absolute inset-0 bg-black/50 rounded-[12px] flex items-center justify-center cursor-pointer opacity-0 hover:opacity-100 transition-opacity"><i class="bi bi-camera-fill text-white"></i></div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading view-mode-text"><?php echo htmlspecialchars($profile['name']); ?></h2>
                            <input type="text" name="profile_name" class="edit-mode-input bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1 font-bold text-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none w-full max-w-xs" value="<?php echo htmlspecialchars($profile['name']); ?>">
                            <p class="text-sm text-brand-600 dark:text-sky-400 font-semibold mt-1"><?php echo htmlspecialchars($profile['designation']); ?> (ECE)</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="toggleProfileEditMode()" id="btnEditProfile" class="bg-brand-100 hover:bg-brand-200 text-brand-700 dark:bg-brand-900/40 dark:hover:bg-brand-800 dark:text-sky-300 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 border border-brand-200 dark:border-brand-800">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </button>
                        <button type="submit" id="btnSaveProfile" class="hidden bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 shadow-lg shadow-emerald-500/30 cursor-pointer">
                            <i class="bi bi-check2-circle"></i> Save Changes
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80">
                        <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-person-lines-fill text-brand-500"></i> I. Personal Information</h3>
                        <div class="space-y-4">
                            <?php foreach($profile['personal'] as $label => $val): ?>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-2">
                                <span class="text-slate-500 dark:text-slate-400 font-medium"><?php echo $label; ?></span>
                                <span class="view-mode-text font-semibold text-slate-800 dark:text-slate-200"><?php echo htmlspecialchars($val); ?></span>
                                <input type="text" name="personal[<?php echo $label; ?>]" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-slate-800 dark:text-slate-200 w-full sm:w-1/2 focus:ring-2 focus:ring-brand-500 outline-none" value="<?php echo htmlspecialchars($val); ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80">
                        <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-envelope-at-fill text-emerald-500"></i> II. Contact Information</h3>
                        <div class="space-y-4">
                            <?php foreach($profile['contact'] as $label => $val): ?>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-2">
                                <span class="text-slate-500 dark:text-slate-400 font-medium"><?php echo $label; ?></span>
                                <span class="view-mode-text font-semibold text-slate-800 dark:text-slate-200"><?php echo htmlspecialchars($val); ?></span>
                                <input type="text" name="contact[<?php echo $label; ?>]" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-slate-800 dark:text-slate-200 w-full sm:w-1/2 focus:ring-2 focus:ring-brand-500 outline-none" value="<?php echo htmlspecialchars($val); ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80">
                        <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-briefcase-fill text-purple-500"></i> III. Professional Info</h3>
                        <div class="space-y-4">
                            <?php foreach($profile['prof'] as $label => $val): ?>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-2">
                                <span class="text-slate-500 dark:text-slate-400 font-medium"><?php echo $label; ?></span>
                                <span class="view-mode-text font-semibold text-slate-800 dark:text-slate-200"><?php echo htmlspecialchars($val); ?></span>
                                <input type="text" name="prof[<?php echo $label; ?>]" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-slate-800 dark:text-slate-200 w-full sm:w-1/2 focus:ring-2 focus:ring-brand-500 outline-none" value="<?php echo htmlspecialchars($val); ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Academic Responsibilities -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80">
                        <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-journal-bookmark-fill text-amber-500"></i> IV. Academic Responsibilities</h3>
                        <div class="space-y-4">
                            <?php foreach($profile['acad'] as $label => $val): ?>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-2">
                                <span class="text-slate-500 dark:text-slate-400 font-medium"><?php echo $label; ?></span>
                                <span class="view-mode-text font-semibold text-slate-800 dark:text-slate-200"><?php echo htmlspecialchars($val); ?></span>
                                <input type="text" name="acad[<?php echo $label; ?>]" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-slate-800 dark:text-slate-200 w-full sm:w-1/2 focus:ring-2 focus:ring-brand-500 outline-none" value="<?php echo htmlspecialchars($val); ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Security Settings & Activity Log -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-shield-lock-fill text-rose-500"></i> Security Settings</h3>
                            <div class="space-y-3">
                                <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-xl overflow-hidden bg-slate-100/30 dark:bg-slate-800/30">
                                    <button type="button" onclick="toggleAccordion('pwd-settings')" class="w-full text-left px-4 py-3 bg-slate-100/50 dark:bg-slate-800/50 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors text-sm font-semibold flex justify-between items-center">
                                        <span>Change Password</span> <i class="bi bi-chevron-down text-slate-400 transition-transform" id="icon-pwd-settings"></i>
                                    </button>
                                    <div id="pwd-settings" class="accordion-content px-4 py-0 bg-white/50 dark:bg-slate-900/50">
                                        <div class="py-3 space-y-3">
                                            <input type="password" placeholder="Current Password" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-rose-500">
                                            <input type="password" placeholder="New Password" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-rose-500">
                                            <button type="button" onclick="alert('Password Updated Successfully')" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-semibold py-2 rounded-lg text-sm transition-colors cursor-pointer">Update Password</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="alert('Opening Security Questions Modal...')" class="w-full text-left px-4 py-3 rounded-xl bg-slate-100/50 dark:bg-slate-800/50 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors text-sm font-semibold flex justify-between items-center border border-slate-200/50 dark:border-slate-700/50">Security Questions <i class="bi bi-shield-check text-slate-400"></i></button>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-clock-history text-indigo-500"></i> V. Activity Log</h3>
                            <div class="relative border-l-2 border-slate-200 dark:border-slate-700 ml-3 space-y-5 pb-4">
                                <div class="relative pl-6"><span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-brand-100 border-2 border-brand-500 dark:bg-brand-900"></span><p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Last Login</p><p class="text-xs text-slate-500">Today, 09:15 AM</p></div>
                                <div class="relative pl-6"><span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-emerald-100 border-2 border-emerald-500 dark:bg-emerald-900"></span><p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Profile Updated</p><p class="text-xs text-slate-500">July 20, 2026, 04:30 PM</p></div>
                                <div class="relative pl-6"><span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-amber-100 border-2 border-amber-500 dark:bg-amber-900"></span><p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Assessment Approved</p><p class="text-xs text-slate-500">July 18, 2026</p></div>
                            </div>
                            <button type="button" class="w-full mt-4 text-center px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-semibold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">View Complete Login History</button>
                        </div>
                    </div>
                </div>
            </form>
            
            <script>
                function toggleProfileEditMode() {
                    document.getElementById('profileContainer').classList.add('is-editing');
                    document.getElementById('btnEditProfile').classList.add('hidden');
                    document.getElementById('btnSaveProfile').classList.remove('hidden');
                }
                
                function toggleAccordion(id) {
                    const content = document.getElementById(id);
                    const icon = document.getElementById('icon-' + id);
                    if (content.classList.contains('expanded')) {
                        content.classList.remove('expanded');
                        content.classList.add('py-0');
                        icon.classList.remove('rotate-180');
                    } else {
                        content.classList.add('expanded');
                        content.classList.remove('py-0');
                        icon.classList.add('rotate-180');
                    }
                }
            </script>

            <?php elseif ($currentPage === 'reports'): ?>
            <!-- ======================= REPORTS SCREEN ======================= -->
            <div class="space-y-8 animate-fade-in search-target-container">
                
                <!-- Main Report Category Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div onclick="toggleReportSection('attendanceSection')" class="cursor-pointer glass-panel p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden searchable-item">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all"></div>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center text-3xl mb-5 shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform"><i class="bi bi-calendar-check-fill"></i></div>
                        <h3 class="text-2xl font-bold font-heading mb-2 text-slate-900 dark:text-white">Attendance Reports</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Analyze overall, subject-wise, and student-wise attendance records.</p>
                        <div class="mt-4 flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-semibold text-sm">View Details <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i></div>
                    </div>

                    <div onclick="toggleReportSection('assessmentSection')" class="cursor-pointer glass-panel p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden searchable-item">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-white flex items-center justify-center text-3xl mb-5 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform"><i class="bi bi-journal-check"></i></div>
                        <h3 class="text-2xl font-bold font-heading mb-2 text-slate-900 dark:text-white">Assessment Reports</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Track practical marks, internal assessments, and journal completions.</p>
                        <div class="mt-4 flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold text-sm">View Details <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i></div>
                    </div>
                </div>

                <!-- Division Selectors: Attendance -->
                <div id="attendanceSection" class="hidden space-y-6">
                    <div id="attendanceDivSelectors" class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg">
                        <h4 class="text-lg font-bold font-heading mb-4 text-indigo-600 dark:text-indigo-400 border-l-4 border-indigo-500 pl-3">Select Division for Attendance</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <button class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 hover:border-indigo-500 hover:bg-indigo-50 font-bold text-lg text-slate-700 dark:text-slate-200 group">Division A</button>
                            <button class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 hover:border-indigo-500 hover:bg-indigo-50 font-bold text-lg text-slate-700 dark:text-slate-200 group">Division B</button>
                            <button onclick="loadDivCReport('attendance')" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 font-bold text-lg text-slate-700 dark:text-slate-200 group relative">
                                <span class="absolute top-2 right-2 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span></span>
                                <span class="text-3xl text-indigo-200 dark:text-indigo-900/50 mb-2 group-hover:text-indigo-500"><i class="bi bi-people-fill"></i></span> Division C
                            </button>
                        </div>
                    </div>
                    
                    <!-- Division C Attendance Data View -->
                    <div id="attendanceDivCReport" class="hidden glass-panel p-6 rounded-3xl border border-indigo-200/80 dark:border-indigo-900/50 shadow-xl searchable-item">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Division C - Attendance Report</h3>
                                <p class="text-sm text-slate-500">Semester 1 (Odd) • 2026-27</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="exportTableToPDF('attendanceTableC', 'Division C - Attendance Report', 'DivC_Attendance.pdf')" class="bg-rose-100 hover:bg-rose-200 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 px-4 py-2 rounded-xl font-semibold text-sm flex items-center gap-2 transition-colors border border-rose-200 dark:border-rose-800"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
                                <button onclick="exportTableToExcel('attendanceTableC', 'DivC_Attendance.xlsx')" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 px-4 py-2 rounded-xl font-semibold text-sm flex items-center gap-2 transition-colors border border-emerald-200 dark:border-emerald-800"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                                <button onclick="backToSelectors('attendance')" class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 px-4 py-2 rounded-xl font-semibold text-sm transition-colors ml-2"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>
                        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
                            <table id="attendanceTableC" class="w-full text-sm text-left global-table">
                                <thead class="bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 border-b border-indigo-100 dark:border-indigo-800">
                                    <tr><th class="p-3">Roll No</th><th class="p-3">Student Name</th><th class="p-3 text-center">DSA</th><th class="p-3 text-center">OOP</th><th class="p-3 text-center">DBMS</th><th class="p-3 text-center">Overall</th></tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50 bg-white/50 dark:bg-slate-900/30">
                                    <tr class="inner-searchable"><td class="p-3 font-semibold">SE-C-101</td><td class="p-3">Aarav Sharma</td><td class="p-3 text-center text-emerald-600 font-bold">95%</td><td class="p-3 text-center text-emerald-600 font-bold">90%</td><td class="p-3 text-center text-emerald-600 font-bold">88%</td><td class="p-3 text-center font-bold text-brand-600">91%</td></tr>
                                    <tr class="inner-searchable"><td class="p-3 font-semibold">SE-C-102</td><td class="p-3">Priya Singh</td><td class="p-3 text-center text-amber-600 font-bold">72%</td><td class="p-3 text-center text-emerald-600 font-bold">80%</td><td class="p-3 text-center text-rose-500 font-bold">65%</td><td class="p-3 text-center font-bold text-amber-600">72%</td></tr>
                                    <tr class="inner-searchable"><td class="p-3 font-semibold">SE-C-103</td><td class="p-3">Rahul Patil</td><td class="p-3 text-center text-rose-500 font-bold">50%</td><td class="p-3 text-center text-rose-500 font-bold">60%</td><td class="p-3 text-center text-amber-600 font-bold">70%</td><td class="p-3 text-center font-bold text-rose-500">60%</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Division Selectors: Assessments -->
                <div id="assessmentSection" class="hidden space-y-6">
                    <div id="assessmentDivSelectors" class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg">
                        <h4 class="text-lg font-bold font-heading mb-4 text-emerald-600 dark:text-emerald-400 border-l-4 border-emerald-500 pl-3">Select Division for Assessments</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <button class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 font-bold text-lg text-slate-700 dark:text-slate-200 group">Division A</button>
                            <button class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 font-bold text-lg text-slate-700 dark:text-slate-200 group">Division B</button>
                            <button onclick="loadDivCReport('assessment')" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 font-bold text-lg text-slate-700 dark:text-slate-200 group relative">
                                <span class="absolute top-2 right-2 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span></span>
                                <span class="text-3xl text-emerald-200 dark:text-emerald-900/50 mb-2 group-hover:text-emerald-500"><i class="bi bi-bar-chart-steps"></i></span> Division C
                            </button>
                        </div>
                    </div>

                    <!-- Division C Assessment Data View -->
                    <div id="assessmentDivCReport" class="hidden glass-panel p-6 rounded-3xl border border-emerald-200/80 dark:border-emerald-900/50 shadow-xl searchable-item">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Division C - Assessment Report</h3>
                                <p class="text-sm text-slate-500">Practical Scores • Semester 1</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="exportTableToPDF('assessmentTableC', 'Division C - Assessment Report', 'DivC_Assessment.pdf')" class="bg-rose-100 hover:bg-rose-200 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 px-4 py-2 rounded-xl font-semibold text-sm flex items-center gap-2 transition-colors border border-rose-200 dark:border-rose-800"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
                                <button onclick="exportTableToExcel('assessmentTableC', 'DivC_Assessment.xlsx')" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 px-4 py-2 rounded-xl font-semibold text-sm flex items-center gap-2 transition-colors border border-emerald-200 dark:border-emerald-800"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                                <button onclick="backToSelectors('assessment')" class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 px-4 py-2 rounded-xl font-semibold text-sm transition-colors ml-2"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>
                        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
                            <table id="assessmentTableC" class="w-full text-sm text-left global-table">
                                <thead class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 border-b border-emerald-100 dark:border-emerald-800">
                                    <tr><th class="p-3">Roll No</th><th class="p-3">Student Name</th><th class="p-3 text-center">DSA (25)</th><th class="p-3 text-center">OOP (25)</th><th class="p-3 text-center">Total (50)</th><th class="p-3 text-center">Status</th></tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50 bg-white/50 dark:bg-slate-900/30">
                                    <tr class="inner-searchable"><td class="p-3 font-semibold">SE-C-101</td><td class="p-3">Aarav Sharma</td><td class="p-3 text-center font-bold">23</td><td class="p-3 text-center font-bold">24</td><td class="p-3 text-center font-bold text-brand-600">47</td><td class="p-3 text-center"><span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 text-xs font-bold">Pass</span></td></tr>
                                    <tr class="inner-searchable"><td class="p-3 font-semibold">SE-C-102</td><td class="p-3">Priya Singh</td><td class="p-3 text-center font-bold">18</td><td class="p-3 text-center font-bold">15</td><td class="p-3 text-center font-bold text-brand-600">33</td><td class="p-3 text-center"><span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 text-xs font-bold">Pass</span></td></tr>
                                    <tr class="inner-searchable"><td class="p-3 font-semibold">SE-C-103</td><td class="p-3">Rahul Patil</td><td class="p-3 text-center font-bold text-rose-500">08</td><td class="p-3 text-center font-bold">12</td><td class="p-3 text-center font-bold text-rose-500">20</td><td class="p-3 text-center"><span class="px-2 py-1 rounded bg-rose-100 text-rose-700 text-xs font-bold">Fail</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function toggleReportSection(sectionId) {
                    document.getElementById('attendanceSection').classList.add('hidden');
                    document.getElementById('assessmentSection').classList.add('hidden');
                    const el = document.getElementById(sectionId);
                    el.classList.remove('hidden');
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                function loadDivCReport(type) {
                    document.getElementById(type + 'DivSelectors').classList.add('hidden');
                    document.getElementById(type + 'DivCReport').classList.remove('hidden');
                }
                function backToSelectors(type) {
                    document.getElementById(type + 'DivCReport').classList.add('hidden');
                    document.getElementById(type + 'DivSelectors').classList.remove('hidden');
                }
            </script>

            <?php elseif ($currentPage === 'timetable'): ?>
            <!-- ======================= TIMETABLE SCREEN ======================= -->
            <div class="space-y-6 search-target-container">
                <!-- Tabs -->
                <div class="flex space-x-2 border-b border-slate-200 dark:border-slate-700/80 pb-4">
                    <button onclick="switchTimetableTab('academic')" id="tabBtn-academic" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                        <i class="bi bi-calendar-week"></i> Academic Timetable
                    </button>
                    <button onclick="switchTimetableTab('exam')" id="tabBtn-exam" class="px-6 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-300 dark:hover:bg-slate-700 transition-all flex items-center gap-2 border border-slate-300 dark:border-slate-600">
                        <i class="bi bi-journal-bookmark-fill"></i> Exam Timetable
                    </button>
                </div>

                <!-- Academic Timetable Content -->
                <div id="content-academic" class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl animate-fade-in searchable-item">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div><h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Academic Schedule</h3><p class="text-sm text-slate-500 dark:text-slate-400">Regular lecture and practical allocations.</p></div>
                        <div class="flex items-center gap-3">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Filter Division:</label>
                            <select class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2 text-sm font-bold text-brand-600 dark:text-brand-400 focus:ring-2 focus:ring-brand-500 outline-none shadow-sm cursor-pointer"><option>Division A</option><option>Division B</option><option selected>Division C</option></select>
                        </div>
                    </div>
                    <div class="overflow-x-auto bg-white/50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <table class="w-full text-sm text-left global-table">
                            <thead class="bg-slate-100/80 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 uppercase text-xs font-bold tracking-wider border-b border-slate-200 dark:border-slate-700">
                                <tr><th class="p-4 w-32">Day / Time</th><th class="p-4">10:00 AM - 11:00 AM</th><th class="p-4">11:00 AM - 12:00 PM</th><th class="p-4">12:00 PM - 01:00 PM</th><th class="p-4 bg-brand-50/50 dark:bg-brand-900/10">01:00 PM - 03:00 PM (Practicals)</th></tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700/80">
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors inner-searchable">
                                    <td class="p-4 font-bold text-slate-800 dark:text-slate-200">Monday</td>
                                    <td class="p-4"><span class="inline-block bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-lg font-semibold border border-indigo-200 dark:border-indigo-800">OOP (Prof. A)</span></td>
                                    <td class="p-4"><span class="inline-block bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 px-3 py-1 rounded-lg font-semibold border border-emerald-200 dark:border-emerald-800">DSA (Prof. B)</span></td>
                                    <td class="p-4 text-slate-400 italic">Lunch Break</td>
                                    <td class="p-4 bg-brand-50/30 dark:bg-brand-900/5"><span class="inline-block bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-300 px-3 py-1 rounded-lg font-semibold border border-rose-200 dark:border-rose-800">Batch C1 - DSA Lab (Prof. B)</span></td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors inner-searchable">
                                    <td class="p-4 font-bold text-slate-800 dark:text-slate-200">Tuesday</td>
                                    <td class="p-4"><span class="inline-block bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 px-3 py-1 rounded-lg font-semibold border border-amber-200 dark:border-amber-800">DBMS (Prof. C)</span></td>
                                    <td class="p-4"><span class="inline-block bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-lg font-semibold border border-indigo-200 dark:border-indigo-800">OOP (Prof. A)</span></td>
                                    <td class="p-4 text-slate-400 italic">Lunch Break</td>
                                    <td class="p-4 bg-brand-50/30 dark:bg-brand-900/5"><span class="inline-block bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-lg font-semibold border border-blue-200 dark:border-blue-800">Batch C2 - OOP Lab (Prof. A)</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Exam Timetable Content -->
                <div id="content-exam" class="hidden glass-panel p-6 rounded-3xl border border-rose-200/80 dark:border-rose-900/30 shadow-xl animate-fade-in searchable-item">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-xl font-bold font-heading text-rose-600 dark:text-rose-400 mb-1">Upcoming Practical Examinations</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">End-semester practical assessment schedule.</p>
                        </div>
                        <button onclick="toggleExamEdit()" id="btnEditExam" class="bg-rose-100 hover:bg-rose-200 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 border border-rose-200 dark:border-rose-800">
                            <i class="bi bi-pencil-square"></i> Edit Schedule
                        </button>
                    </div>
                    
                    <div class="space-y-4" id="examList">
                        <!-- Exam Row 1 -->
                        <div class="exam-row inner-searchable flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-white/60 dark:bg-slate-800/60 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-rose-400 transition-colors">
                            <div class="flex items-center gap-4 mb-3 sm:mb-0">
                                <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 flex items-center justify-center text-xl font-bold"><i class="bi bi-file-earmark-code-fill"></i></div>
                                <div>
                                    <p class="font-bold text-lg text-slate-900 dark:text-white">Data Structures & Algorithms</p>
                                    <p class="text-sm text-slate-500">All Divisions • Int: Prof. B | Ext: Prof. XYZ</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right border-l-2 sm:border-l-0 border-rose-200 pl-4 sm:pl-0 flex flex-col items-end">
                                <span class="view-mode-text font-bold text-rose-500 text-lg">Oct 15, 2026</span>
                                <input type="date" value="2026-10-15" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded p-1 mb-1 text-sm font-bold text-rose-500 outline-none">
                                
                                <span class="view-mode-text text-sm font-semibold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-900 px-2 py-1 rounded-md mt-1"><i class="bi bi-clock"></i> 10:00 AM - 04:00 PM</span>
                                <div class="edit-mode-input flex items-center gap-1 mt-1 bg-slate-100 dark:bg-slate-900 p-1 rounded-md text-sm">
                                    <input type="time" value="10:00" class="bg-transparent border-b border-slate-300 dark:border-slate-600 outline-none text-slate-700 dark:text-slate-300"> to 
                                    <input type="time" value="16:00" class="bg-transparent border-b border-slate-300 dark:border-slate-600 outline-none text-slate-700 dark:text-slate-300">
                                </div>
                            </div>
                        </div>

                        <!-- Exam Row 2 -->
                        <div class="exam-row inner-searchable flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-white/60 dark:bg-slate-800/60 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-rose-400 transition-colors">
                            <div class="flex items-center gap-4 mb-3 sm:mb-0">
                                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 flex items-center justify-center text-xl font-bold"><i class="bi bi-database-fill"></i></div>
                                <div>
                                    <p class="font-bold text-lg text-slate-900 dark:text-white">Database Management System</p>
                                    <p class="text-sm text-slate-500">All Divisions • Int: Prof. C | Ext: Prof. ABC</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right border-l-2 sm:border-l-0 border-rose-200 pl-4 sm:pl-0 flex flex-col items-end">
                                <span class="view-mode-text font-bold text-rose-500 text-lg">Oct 18, 2026</span>
                                <input type="date" value="2026-10-18" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded p-1 mb-1 text-sm font-bold text-rose-500 outline-none">
                                
                                <span class="view-mode-text text-sm font-semibold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-900 px-2 py-1 rounded-md mt-1"><i class="bi bi-clock"></i> 09:00 AM - 02:00 PM</span>
                                <div class="edit-mode-input flex items-center gap-1 mt-1 bg-slate-100 dark:bg-slate-900 p-1 rounded-md text-sm">
                                    <input type="time" value="09:00" class="bg-transparent border-b border-slate-300 dark:border-slate-600 outline-none text-slate-700 dark:text-slate-300"> to 
                                    <input type="time" value="14:00" class="bg-transparent border-b border-slate-300 dark:border-slate-600 outline-none text-slate-700 dark:text-slate-300">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function switchTimetableTab(tabName) {
                    document.getElementById('content-academic').classList.add('hidden');
                    document.getElementById('content-exam').classList.add('hidden');
                    
                    const btnAcad = document.getElementById('tabBtn-academic');
                    const btnExam = document.getElementById('tabBtn-exam');
                    
                    btnAcad.className = "px-6 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-300 dark:hover:bg-slate-700 transition-all flex items-center gap-2 border border-slate-300 dark:border-slate-600";
                    btnExam.className = "px-6 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-300 dark:hover:bg-slate-700 transition-all flex items-center gap-2 border border-slate-300 dark:border-slate-600";
                    
                    document.getElementById('content-' + tabName).classList.remove('hidden');
                    const activeBtn = document.getElementById('tabBtn-' + tabName);
                    activeBtn.className = "px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2";
                }

                let isExamEditing = false;
                function toggleExamEdit() {
                    const container = document.getElementById('content-exam');
                    const btn = document.getElementById('btnEditExam');
                    isExamEditing = !isExamEditing;

                    if (isExamEditing) {
                        container.classList.add('is-editing');
                        btn.innerHTML = `<i class="bi bi-check2-circle"></i> Save Schedule`;
                        btn.className = "bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 shadow-lg shadow-emerald-500/30";
                    } else {
                        container.classList.remove('is-editing');
                        btn.innerHTML = `<i class="bi bi-pencil-square"></i> Edit Schedule`;
                        btn.className = "bg-rose-100 hover:bg-rose-200 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 border border-rose-200 dark:border-rose-800";
                        alert("Exam timetable updated!");
                    }
                }
            </script>

            <?php elseif ($currentPage === 'notifications'): ?>
            <!-- ======================= NOTIFICATIONS SCREEN ======================= -->
            <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl max-w-4xl mx-auto search-target-container">
                <div class="flex items-center justify-between mb-6 border-b border-slate-200 dark:border-slate-700 pb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading">Notifications Center</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">All alerts and system updates.</p>
                    </div>
                    <button class="text-brand-600 dark:text-brand-400 text-sm font-semibold hover:underline">Mark all as read</button>
                </div>

                <div class="space-y-4">
                    <div class="inner-searchable p-4 rounded-xl bg-rose-50 dark:bg-rose-900/10 border border-rose-200 dark:border-rose-800/50 flex gap-4 items-start relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-rose-500"></div>
                        <div class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-900/40 text-rose-600 flex items-center justify-center text-lg flex-shrink-0"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-900 dark:text-white">5 Faculty pending mark entries</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Please remind the faculty members assigned to Div B and C to complete practical marks entry before the deadline tomorrow.</p>
                            <p class="text-xs text-rose-500 mt-2 font-semibold"><i class="bi bi-clock"></i> 10 min ago</p>
                        </div>
                        <button class="px-3 py-1.5 rounded-lg bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold shadow-sm transition-colors">Send Reminder</button>
                    </div>

                    <div class="inner-searchable p-4 rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/50 flex gap-4 items-start relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500"></div>
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-600 flex items-center justify-center text-lg flex-shrink-0"><i class="bi bi-person-x-fill"></i></div>
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-900 dark:text-white">12 Students below attendance limit</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">12 students in Second Year (SE) Div C have fallen below the 75% mandatory attendance threshold in practicals.</p>
                            <p class="text-xs text-amber-500 mt-2 font-semibold"><i class="bi bi-clock"></i> 30 min ago</p>
                        </div>
                        <button class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-xs font-semibold shadow-sm transition-colors hover:bg-slate-50 dark:hover:bg-slate-700">View List</button>
                    </div>

                    <div class="inner-searchable p-4 rounded-xl bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-600 flex items-center justify-center text-lg flex-shrink-0"><i class="bi bi-calendar-event-fill"></i></div>
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-900 dark:text-white text-sm">Mock Practical exam starts tomorrow</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">The system has finalized the batch distributions for tomorrow's mock practical exams.</p>
                            <p class="text-xs text-slate-400 mt-2"><i class="bi bi-clock"></i> 1 hr ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php elseif ($currentPage === 'settings'): ?>
            <!-- ======================= SETTINGS SCREEN ======================= -->
            <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl max-w-4xl mx-auto space-y-6">
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading">System Settings</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Manage dashboard preferences and module configurations.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-5 rounded-2xl bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2"><i class="bi bi-sliders text-brand-500"></i> General Preferences</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div><p class="text-sm font-semibold dark:text-white">Enable Dark Mode Default</p><p class="text-xs text-slate-500">System opens in dark mode.</p></div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                  <input type="checkbox" checked class="sr-only peer">
                                  <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div><p class="text-sm font-semibold dark:text-white">Compact Sidebar</p><p class="text-xs text-slate-500">Show only icons on sidebar.</p></div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                  <input type="checkbox" class="sr-only peer">
                                  <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2"><i class="bi bi-bell-fill text-amber-500"></i> Alert Preferences</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div><p class="text-sm font-semibold dark:text-white">Email Alerts</p><p class="text-xs text-slate-500">Receive critical alerts via email.</p></div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                  <input type="checkbox" checked class="sr-only peer">
                                  <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div><p class="text-sm font-semibold dark:text-white">Daily Summary Report</p><p class="text-xs text-slate-500">Auto-generate daily attendance PDF.</p></div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                  <input type="checkbox" class="sr-only peer">
                                  <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700">
                    <button class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-brand-500/30">Save Settings</button>
                </div>
            </div>

            <?php else: ?>
            <!-- ======================= FALLBACK ======================= -->
            <div class="glass-panel p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 text-center flex flex-col items-center justify-center min-h-[50vh]">
                <h2 class="text-2xl font-bold font-heading text-slate-500">Module Under Construction</h2>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Global Export, Download Marksheet, Navigation, & Chart Scripts -->
    <script>
        // --- Navigation Sidebar & Dark Mode Handlers ---
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            const themeIcon = document.getElementById('themeIcon');
            if (html.classList.contains('dark')) {
                themeIcon.className = 'bi bi-sun-fill';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill';
            }
            if(typeof updateChartThemes === 'function'){
                updateChartThemes();
            }
        }

        // --- Global Search Functionality ---
        function globalSearch() {
            const input = document.getElementById('globalSearchInput').value.toLowerCase();
            const searchableItems = document.querySelectorAll('.inner-searchable');
            
            searchableItems.forEach(item => {
                const text = item.innerText.toLowerCase();
                if (text.includes(input)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // --- 1. Export Table to Excel (.xlsx) ---
        function exportTableToExcel(tableId, fileName = 'Report.xlsx') {
            const table = document.getElementById(tableId);
            if (!table) {
                alert("Table element not found!");
                return;
            }
            const clonedTable = table.cloneNode(true);
            const actionHeaders = clonedTable.querySelectorAll('th:last-child, td:last-child');
            actionHeaders.forEach(el => {
                if (el.innerText.trim().toLowerCase().includes('action') || el.querySelector('button')) {
                    el.remove();
                }
            });

            const wb = XLSX.utils.table_to_book(clonedTable, { sheet: "Sheet1" });
            XLSX.writeFile(wb, fileName);
        }

        // --- 2. Export Table to PDF (.pdf) ---
        function exportTableToPDF(tableId, title, fileName = 'Report.pdf') {
            const table = document.getElementById(tableId);
            if (!table) {
                alert("Table element not found!");
                return;
            }
            
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'pt', 'a4'); 
            
            doc.setFontSize(16);
            doc.text(title, 40, 40);
            
            doc.autoTable({
                html: '#' + tableId,
                startY: 50,
                theme: 'grid',
                headStyles: { fillColor: [59, 130, 246] },
                columnStyles: { 
                    4: { cellWidth: 'auto', hidden: tableId === 'studentsTable' } 
                }
            });
            
            doc.save(fileName);
        }

        // --- 3. DOWNLOAD STUDENT MARKSHEET FUNCTIONALITY ---
        function downloadStudentMarksheet(rollNo, studentName, division, attendance) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Header Banner
            doc.setFillColor(30, 58, 138); // Brand blue
            doc.rect(0, 0, 210, 36, 'F');
            
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");
            doc.text("ZEAL EDUCATION SOCIETY'S ZEAL COLLEGE OF ENGINEERING & RESEARCH", 105, 14, { align: "center" });
            
            doc.setFontSize(10);
            doc.setFont("helvetica", "normal");
            doc.text("Department of Electronics & Computer Engineering", 105, 22, { align: "center" });
            doc.text("Academic Year 2026-27 | Semester 1 Marks Statement", 105, 29, { align: "center" });

            // Document Title
            doc.setTextColor(30, 41, 59);
            doc.setFontSize(12);
            doc.setFont("helvetica", "bold");
            doc.text("PRACTICAL ASSESSMENT MARKSHEET", 105, 48, { align: "center" });

            // Student Meta Box
            doc.setDrawColor(203, 213, 225);
            doc.setFillColor(248, 250, 252);
            doc.roundedRect(15, 54, 180, 24, 3, 3, 'FD');

            doc.setFontSize(10);
            doc.setFont("helvetica", "bold");
            doc.text(`Student Name:`, 20, 62);
            doc.setFont("helvetica", "normal");
            doc.text(`${studentName}`, 50, 62);

            doc.setFont("helvetica", "bold");
            doc.text(`Roll Number:`, 20, 71);
            doc.setFont("helvetica", "normal");
            doc.text(`${rollNo}`, 50, 71);

            doc.setFont("helvetica", "bold");
            doc.text(`Division:`, 130, 62);
            doc.setFont("helvetica", "normal");
            doc.text(`${division}`, 155, 62);

            doc.setFont("helvetica", "bold");
            doc.text(`Attendance:`, 130, 71);
            doc.setFont("helvetica", "normal");
            doc.text(`${attendance}`, 155, 71);

            // Marks Table
            const marksData = [
                ["1", "Data Structures & Algorithms (DSA)", "25", "23", "18", "41 / 50", "PASS"],
                ["2", "Object Oriented Programming (OOP)", "25", "22", "19", "41 / 50", "PASS"],
                ["3", "Database Management System (DBMS)", "25", "21", "20", "41 / 50", "PASS"],
                ["4", "Computer Networks Practical", "25", "24", "18", "42 / 50", "PASS"]
            ];

            doc.autoTable({
                startY: 85,
                head: [["Sr.", "Subject / Lab Name", "Max Marks", "Practical Marks", "Journal Score", "Total Score", "Status"]],
                body: marksData,
                theme: 'grid',
                headStyles: { fillColor: [30, 58, 138], textColor: [255, 255, 255], fontStyle: 'bold', halign: 'center' },
                columnStyles: {
                    0: { cellWidth: 12, halign: 'center' },
                    1: { cellWidth: 70 },
                    2: { cellWidth: 22, halign: 'center' },
                    3: { cellWidth: 26, halign: 'center' },
                    4: { cellWidth: 24, halign: 'center' },
                    5: { cellWidth: 26, halign: 'center' },
                    6: { cellWidth: 20, halign: 'center' }
                },
                styles: { fontSize: 8.5, cellPadding: 5 }
            });

            // Summary Section
            let finalY = doc.lastAutoTable.finalY + 12;
            doc.setDrawColor(226, 232, 240);
            doc.line(15, finalY, 195, finalY);

            finalY += 10;
            doc.setFontSize(10);
            doc.setFont("helvetica", "bold");
            doc.text("Total Obtained Marks: 165 / 200", 15, finalY);
            doc.text("Percentage: 82.50%", 130, finalY);

            doc.text("Overall Class Result: FIRST CLASS WITH DISTINCTION", 15, finalY + 8);

            // Signature Block
            finalY += 40;
            doc.setFont("helvetica", "normal");
            doc.setFontSize(9);
            
            doc.line(20, finalY, 70, finalY);
            doc.text("Class Teacher Signature", 23, finalY + 10);

            doc.line(140, finalY, 190, finalY);
            doc.text("HOD (ECE Dept) Signature", 143, finalY + 10);

            // Footer Note
            doc.setFontSize(8);
            doc.setTextColor(100, 116, 139);
            doc.text("This is an official computer-generated marksheet issued by the HOD Office.", 105, finalY + 25, { align: "center" });

            // File Download
            const cleanFileName = studentName.replace(/\s+/g, '_');
            doc.save(`${rollNo}_${cleanFileName}_Marksheet.pdf`);
        }

        // --- 4. Dashboard Chart Generation ---
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('divCAttendanceChart')) {
                const options = {
                    series: [{
                        name: 'Attendance %',
                        data: [88, 75, 92, 85, 68]
                    }],
                    chart: {
                        type: 'bar',
                        height: 280,
                        toolbar: { show: false },
                        fontFamily: 'Plus Jakarta Sans, sans-serif',
                        foreColor: '#64748b'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            horizontal: false,
                            columnWidth: '45%',
                        }
                    },
                    dataLabels: { enabled: false },
                    xaxis: {
                        categories: ['DSA', 'OOP', 'DBMS', 'CG', 'DEL'],
                        labels: { style: { fontWeight: 600 } }
                    },
                    yaxis: {
                        max: 100,
                        tickAmount: 5,
                    },
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
</body>
</html>