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
                $realKey = str_replace('_', ' ', $key); 
                if(array_key_exists($realKey, $_SESSION['profile_data'][$cat])) {
                    $_SESSION['profile_data'][$cat][$realKey] = htmlspecialchars($val);
                }
            }
        }
    }
    header("Location: ?page=profile&success=1");
    exit;
}

// Assign active profile data to variables
$profile = $_SESSION['profile_data'];
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

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>