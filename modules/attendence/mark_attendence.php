<?php
// 1. Start Session to simulate a database for data persistence
session_start();

// Initialize dummy data if the session is empty
if (!isset($_SESSION['attendance_data'])) {
    $_SESSION['attendance_data'] = [
        'ZPRN1001' => ['name' => 'Aarav Sharma', 'status' => 'Present'],
        'ZPRN1002' => ['name' => 'Isha Patel', 'status' => 'Absent'],
        'ZPRN1003' => ['name' => 'Rohan Desai', 'status' => 'Late']
    ];
}

// 2. Handle Form Submissions (Create, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        
        // Save (Add or Update)
        if ($_POST['action'] === 'save') {
            $zprn = trim(htmlspecialchars($_POST['zprn']));
            $name = trim(htmlspecialchars($_POST['name']));
            $status = trim(htmlspecialchars($_POST['status']));
            
            if (!empty($zprn) && !empty($name)) {
                // If editing, check if the original ZPRN was changed and remove the old one
                if (isset($_POST['original_zprn']) && $_POST['original_zprn'] !== $zprn && !empty($_POST['original_zprn'])) {
                    unset($_SESSION['attendance_data'][$_POST['original_zprn']]);
                }
                // Save new/updated record
                $_SESSION['attendance_data'][$zprn] = ['name' => $name, 'status' => $status];
            }
            // Redirect to prevent form resubmission on refresh
            header("Location: ?page=mark");
            exit;
        }

        // Delete
        if ($_POST['action'] === 'delete') {
            $zprn = $_POST['zprn'];
            if (isset($_SESSION['attendance_data'][$zprn])) {
                unset($_SESSION['attendance_data'][$zprn]);
            }
            header("Location: ?page=mark");
            exit;
        }
    }
}

// 3. Simulated dynamic data for the header
$systemName = "PRACTICAL";
$systemSubTitle = "MANAGEMENT SYSTEM";
$facultyName = "Prof. S. Patil";
$facultyInitials = "PP";
$facultyRole = "Faculty";
$currentDate = "18 May 2025";
$notificationCount = 3;
$greeting = "Welcome, " . $facultyName . " 👋";
$greetingSubtext = "Manage and track student practical attendance with ease.";

// Determine which page to show
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $systemName; ?> - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
        }
    </style>
</head>
<body class="text-gray-800 flex flex-col min-h-screen">

    <!-- Header (Persistent across all pages) -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-[1400px] mx-auto px-6 py-4 flex justify-between items-center">
            
            <!-- Logo & Brand -->
            <a href="?page=dashboard" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div class="bg-blue-700 text-white p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-gray-900 leading-tight tracking-tight"><?php echo $systemName; ?></span>
                    <span class="text-xs text-gray-500 font-medium tracking-wide"><?php echo $systemSubTitle; ?></span>
                </div>
            </a>

            <!-- Header Right: Date, Notifications, Profile -->
            <div class="flex items-center gap-6">
                <!-- Date -->
                <div class="flex items-center gap-2 border border-gray-200 rounded-md px-3 py-1.5 text-sm font-medium text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <?php echo $currentDate; ?>
                </div>

                <!-- Notifications -->
                <div class="relative cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <?php if($notificationCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center border-2 border-white">
                        <?php echo $notificationCount; ?>
                    </span>
                    <?php endif; ?>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="bg-blue-700 text-white h-9 w-9 rounded-full flex items-center justify-center font-semibold text-sm">
                        <?php echo $facultyInitials; ?>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-900"><?php echo $facultyName; ?></span>
                        <span class="text-xs text-gray-500"><?php echo $facultyRole; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-[1000px] mx-auto px-6 py-8 w-full flex-grow">
        
        <?php if ($page === 'dashboard'): ?>
        <!-- ==================== DASHBOARD VIEW ==================== -->
        
        <!-- Welcome Banner -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-8 flex justify-between items-center mb-10 overflow-hidden relative">
            <div class="flex items-center gap-5 relative z-10">
                <div class="bg-[#eff4ff] text-blue-600 h-16 w-16 rounded-full flex items-center justify-center">
                    <span class="text-2xl">👋</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1"><?php echo $greeting; ?></h1>
                    <p class="text-gray-500 text-sm"><?php echo $greetingSubtext; ?></p>
                </div>
            </div>
            
            <!-- Decorative Illustration -->
            <div class="hidden md:block relative w-48 h-24 opacity-90">
                <svg viewBox="0 0 200 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute right-0 top-1/2 transform -translate-y-1/2">
                    <circle cx="170" cy="50" r="40" fill="#f0f5ff" />
                    <rect x="70" y="20" width="50" height="70" rx="4" fill="#e0e7ff" />
                    <rect x="65" y="25" width="50" height="70" rx="4" fill="#ffffff" stroke="#e0e7ff" stroke-width="2"/>
                    <rect x="80" y="15" width="20" height="8" rx="2" fill="#93c5fd" />
                    <path d="M72 40 l 3 3 l 6 -6" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <rect x="85" y="38" width="20" height="3" rx="1.5" fill="#dbeafe" />
                    <path d="M72 55 l 3 3 l 6 -6" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <rect x="85" y="53" width="20" height="3" rx="1.5" fill="#dbeafe" />
                    <circle cx="125" cy="55" r="9" fill="#3b82f6" />
                    <path d="M105 85 Q 125 60 145 85 L 145 95 L 105 95 Z" fill="#3b82f6" />
                </svg>
            </div>
        </div>

        <!-- Section Title -->
        <div class="mb-6">
            <h2 class="text-sm font-bold text-blue-700 tracking-wider uppercase mb-1">Attendance</h2>
            <div class="h-1 w-8 bg-blue-600 rounded-full"></div>
        </div>

        <!-- Action Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- View Attendance Card -->
            <div class="bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(6,81,237,0.08)] p-10 flex flex-col items-center text-center transition-transform hover:-translate-y-1 duration-300 border border-transparent hover:border-blue-100">
                <div class="bg-[#eff4ff] p-5 rounded-2xl mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h6M9 14h3" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 16l4 4m-2.5-7.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">View Attendance</h3>
                <p class="text-gray-500 text-sm mb-8 px-4 leading-relaxed">
                    View and filter attendance records<br>for practical sessions.
                </p>
                <!-- Linked to ?page=view -->
                <a href="?page=view" class="mt-auto w-full max-w-[240px] bg-[#1d4ed8] hover:bg-blue-800 text-white font-medium py-3 px-6 rounded-md flex items-center justify-center gap-2 transition-colors shadow-md">
                    View Attendance
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Mark Attendance Card -->
            <div class="bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(6,81,237,0.08)] p-10 flex flex-col items-center text-center transition-transform hover:-translate-y-1 duration-300 border border-transparent hover:border-blue-100">
                <div class="bg-[#eff4ff] p-5 rounded-2xl mb-6 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <div class="absolute bottom-3 right-3 bg-[#1d4ed8] rounded-full p-1 border-2 border-[#eff4ff]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Mark Attendance</h3>
                <p class="text-gray-500 text-sm mb-8 px-4 leading-relaxed">
                    Select a session and mark attendance<br>for students.
                </p>
                <!-- Linked to ?page=mark -->
                <a href="?page=mark" class="mt-auto w-full max-w-[240px] bg-[#1d4ed8] hover:bg-blue-800 text-white font-medium py-3 px-6 rounded-md flex items-center justify-center gap-2 transition-colors shadow-md">
                    Mark Attendance
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <?php elseif ($page === 'view'): ?>
        <!-- ==================== VIEW ATTENDANCE VIEW ==================== -->
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Session Attendance</h2>
                <p class="text-gray-500 text-sm mt-1">Read-only view of current student attendance records.</p>
            </div>
            <a href="?page=dashboard" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors flex items-center gap-2">
                &larr; Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-semibold">ZPRN</th>
                        <th class="p-4 font-semibold">Student Name</th>
                        <th class="p-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($_SESSION['attendance_data'])): ?>
                        <tr>
                            <td colspan="3" class="p-8 text-center text-gray-500">No attendance records found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($_SESSION['attendance_data'] as $zprn => $data): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 font-medium text-gray-900"><?php echo htmlspecialchars($zprn); ?></td>
                            <td class="p-4 text-gray-700"><?php echo htmlspecialchars($data['name']); ?></td>
                            <td class="p-4">
                                <?php 
                                    // Status Badge styling
                                    $bg = $data['status'] == 'Present' ? 'bg-green-100 text-green-800' : 
                                         ($data['status'] == 'Absent' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $bg; ?>">
                                    <?php echo htmlspecialchars($data['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($page === 'mark'): ?>
        <!-- ==================== MARK ATTENDANCE VIEW (CRUD) ==================== -->
        
        <?php 
            // Check if editing a specific record
            $edit_zprn = isset($_GET['edit']) ? $_GET['edit'] : '';
            $edit_name = '';
            $edit_status = 'Present';
            $is_editing = false;

            if ($edit_zprn && isset($_SESSION['attendance_data'][$edit_zprn])) {
                $edit_name = $_SESSION['attendance_data'][$edit_zprn]['name'];
                $edit_status = $_SESSION['attendance_data'][$edit_zprn]['status'];
                $is_editing = true;
            }
        ?>

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manage Attendance</h2>
                <p class="text-gray-500 text-sm mt-1">Add, edit, or remove student records.</p>
            </div>
            <a href="?page=dashboard" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors flex items-center gap-2">
                &larr; Back to Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Add/Edit Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                        <?php echo $is_editing ? 'Edit Student Record' : 'Add New Student'; ?>
                    </h3>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="save">
                        <?php if ($is_editing): ?>
                            <input type="hidden" name="original_zprn" value="<?php echo htmlspecialchars($edit_zprn); ?>">
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Student ZPRN</label>
                            <input type="text" name="zprn" required value="<?php echo htmlspecialchars($edit_zprn); ?>" placeholder="e.g., ZPRN1004" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                            <input type="text" name="name" required value="<?php echo htmlspecialchars($edit_name); ?>" placeholder="e.g., John Doe" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="Present" <?php echo $edit_status === 'Present' ? 'selected' : ''; ?>>Present</option>
                                <option value="Absent" <?php echo $edit_status === 'Absent' ? 'selected' : ''; ?>>Absent</option>
                                <option value="Late" <?php echo $edit_status === 'Late' ? 'selected' : ''; ?>>Late</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-md transition-colors shadow-sm">
                                <?php echo $is_editing ? 'Update Record' : 'Save Record'; ?>
                            </button>
                            <?php if ($is_editing): ?>
                                <a href="?page=mark" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors">
                                    Cancel
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Management Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500 uppercase tracking-wider">
                                <th class="p-4 font-semibold">ZPRN</th>
                                <th class="p-4 font-semibold">Student Info</th>
                                <th class="p-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($_SESSION['attendance_data'])): ?>
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-gray-500">No attendance records found. Add one on the left.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($_SESSION['attendance_data'] as $zprn => $data): ?>
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="p-4 font-medium text-gray-900"><?php echo htmlspecialchars($zprn); ?></td>
                                    <td class="p-4">
                                        <div class="text-gray-900 font-medium"><?php echo htmlspecialchars($data['name']); ?></div>
                                        <?php 
                                            $bg = $data['status'] == 'Present' ? 'text-green-600' : 
                                                 ($data['status'] == 'Absent' ? 'text-red-600' : 'text-yellow-600');
                                        ?>
                                        <div class="text-sm font-semibold <?php echo $bg; ?>">
                                            &bull; <?php echo htmlspecialchars($data['status']); ?>
                                        </div>
                                    </td>
                                    <td class="p-4 flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- Edit Button -->
                                        <a href="?page=mark&edit=<?php echo urlencode($zprn); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded text-sm font-medium transition-colors">
                                            Edit
                                        </a>
                                        <!-- Delete Form -->
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this record?');" class="inline">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="zprn" value="<?php echo htmlspecialchars($zprn); ?>">
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded text-sm font-medium transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php endif; ?>

    </main>

    <!-- Footer -->
    <footer class="mt-auto py-6 border-t border-gray-200 bg-white">
        <p class="text-center text-sm text-gray-500 font-medium">
            &copy; 2025 Practical Assessment System. All rights reserved.
        </p>
    </footer>

</body>
</html>