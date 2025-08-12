<?php

define('ROOT_PATH', __DIR__);
session_start();
require_once ROOT_PATH . "/config/database.php";
require_once ROOT_PATH . "/app/helpers/csrf.php";
require_once ROOT_PATH . '/app/controllers/AttendanceController.php';

ob_start(function ($buffer) {
    return preg_replace_callback(
        '/<form(.*?)>/i',
        function ($matches) {
            $csrfToken = generateCsrfToken();
            return '<form' . $matches[1] . '>' .
                '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrfToken) . '">';
        },
        $buffer
    );
});

// ✅ Logout handling
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

// ✅ Define public and protected pages
$public_pages = ['home', 'about', 'contact', 'blog', 'services', 'login','Records_digitization_digitalization','web_development','it_support','consultancy', 'gallery'];
$protected_pages = [
    'dashboard', 'user_management', 'admin_reports', 'blog_management',
    'edit_profile', 'edit_user', 'attendance', 'attendance_report',
    'register', 'delete_report', 'userdashboard', 'manage_clients', 'add_clients', 'add_testimonials'
];

// ✅ Get requested page or default to 'home'
$page = $_GET['page'] ?? 'home';

// ✅ Redirect if protected page and not logged in
if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

// ✅ Redirect employees trying to access admin dashboard
if ($page === 'dashboard' && isset($_SESSION['role']) && $_SESSION['role'] === 'employee') {
    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
}

// ✅ Auth routes
if (in_array($page, ['auth_login', 'auth_register', 'auth_logout'])) {
    require_once ROOT_PATH . '/app/controllers/AuthController.php';
    $authController = new AuthController();

    switch ($page) {
        case 'auth_login':
            $authController->login();
            break;
        case 'auth_register':
            $authController->register();
            break;
        case 'auth_logout':
            $authController->logout();
            break;
    }
    exit();
}

// ✅ Work report submission
if ($page === 'submit_work_report') {
    require_once ROOT_PATH . '/app/controllers/WorkReportController.php';
    $controller = new WorkReportController();
    $controller->submitReport();
    exit();
}

// ✅ Upload profile image
if ($page === 'upload_profile_image') {
    require_once ROOT_PATH . '/app/controllers/ProfileController.php';
    $controller = new ProfileImageController();
    $controller->upload();
    exit();
}

// ✅ Attendance action
if ($page === 'attendance_action') {
    require_once ROOT_PATH . '/app/controllers/AttendanceController.php';
    $attendanceController = new AttendanceController($pdo);
    $attendanceController->handleAttendance();
    exit();
}

// ✅ Delete user action
if ($page === 'delete_user') {
    require_once ROOT_PATH . '/app/controllers/DeleteUserController.php';
    $deleteUserController = new DeleteUserController($pdo);
    $deleteUserController->deleteUser();
    exit();
}

// ✅ Handle logout by URL (alternative)
if ($page === 'logout') {
    require_once ROOT_PATH . '/app/controllers/AuthController.php';
    $authController = new AuthController($pdo);
    $authController->logout();
    exit();
}

// ✅ Blog routes
if ($page === 'blog') {
    require_once ROOT_PATH . '/app/controllers/BlogController.php';
    require_once ROOT_PATH . '/app/models/Blog.php';
    include ROOT_PATH . '/app/views/blog.php';
    ob_end_flush();
    exit();
}

if ($page === 'blog_detail') {
    require_once ROOT_PATH . '/app/controllers/BlogController.php';
    require_once ROOT_PATH . '/app/models/Blog.php';
    include ROOT_PATH . "/app/views/blog_detail.php";
    ob_end_flush();
    exit();
}

// ✅ Comment routes
if ($page === 'CommentController') {
    require_once ROOT_PATH . '/app/controllers/CommentController.php';
    exit();
}

// ✅ Like routes
if ($page === 'LikeController') {
    require_once ROOT_PATH . '/app/controllers/LikeController.php';
    exit();
}

//if (isset($_GET['page'])) {
  //  $page = $_GET['page'];
  //  $file = "app/views/$page.php";

  //  if (file_exists($file)) {
   //     include($file);
  //  } else {
   //     echo "<h2>404 - Page Not Found</h2>";
   //     echo "<p>Requested Page: $page</p>";
   //     echo "<p>Expected File Path: $file</p>";
  //  }
//} else {
//    include("app/views/home.php");
//}


// ✅ Load requested view or show 404
$view_file = ROOT_PATH . "/app/views/{$page}.php";
if (file_exists($view_file)) {
    include $view_file;
} else {
  include ROOT_PATH . "/app/views/404.php";
}

ob_end_flush();

