<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/csrf.php';

class AuthController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    private function logAttempt($email, $success)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $stmt = $this->pdo->prepare("INSERT INTO login_attempts (email, ip_address, success, attempt_time) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$email, $ip, $success ? 1 : 0]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'])) {
                $_SESSION['login_error'] = "Security verification failed (Invalid CSRF token).";
                header("Location: /myphpproject/index.php?page=login");
                exit();
            }

            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Limit attempts
            $ip = $_SERVER['REMOTE_ADDR'];
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address = ? AND success = 0 AND attempt_time > (NOW() - INTERVAL 10 MINUTE)");
            $stmt->execute([$ip]);
            $failedAttempts = $stmt->fetchColumn();

            if ($failedAttempts >= 5) {
                $_SESSION['login_error'] = "Too many failed attempts. Please wait 10 minutes before trying again.";
                header("Location: /myphpproject/index.php?page=login");
                exit();
            }

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $this->logAttempt($email, true);

                if ($user['role'] === 'admin') {
                    header("Location: /myphpproject/index.php?page=dashboard");
                } elseif ($user['role'] === 'employee') {
                    header("Location: /myphpproject/index.php?page=userdashboard");
                } else {
                    $_SESSION['login_error'] = "Unauthorized role.";
                    header("Location: /myphpproject/index.php?page=login");
                }
                exit();
            } else {
                $this->logAttempt($email, false);
                $_SESSION['login_error'] = "Invalid email or password.";
                header("Location: /myphpproject/index.php?page=login");
                exit();
            }
        }
    }

    

 public function logout()
{
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Clear all session data
    $_SESSION = [];

    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header("Location: /myphpproject/index.php?page=login");
    exit();
}



    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                $token = bin2hex(random_bytes(50));
                $stmt = $this->pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, NOW() + INTERVAL 1 HOUR)");
                $stmt->execute([$email, $token]);

                $resetLink = "https://yourdomain.com/myphpproject/index.php?page=reset_password&token=$token";

                // Here you would use mail() or PHPMailer to send the reset email.
                // Example:
                // mail($email, "Password Reset Request", "Reset your password here: $resetLink");

                $_SESSION['forgot_success'] = "Password reset link sent to your email.";
            } else {
                $_SESSION['forgot_error'] = "Email not found.";
            }

            header("Location: /myphpproject/index.php?page=forgot_password");
            exit();
        }
    }



    // ✅ REGISTER FUNCTION
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'])) {
                $_SESSION['register_error'] = "Security verification failed (Invalid CSRF token).";
                header("Location: /myphpproject/index.php?page=register");
                exit();
            }

            $name = trim($_POST['name']);
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $role = trim($_POST['role']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $_SESSION['register_error'] = "Passwords do not match.";
                header("Location: /myphpproject/index.php?page=register");
                exit();
            }

            // Check for existing email
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['register_error'] = "Email already exists. Please use a different email.";
                header("Location: /myphpproject/index.php?page=register");
                exit();
            }

            // Check for existing username
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $_SESSION['register_error'] = "Username already taken. Please choose another one.";
                header("Location: /myphpproject/index.php?page=register");
                exit();
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare("INSERT INTO users (name, username, email, role, password) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $username, $email, $role, $hashed_password])) {
                $_SESSION['register_success'] = "Registration successful! You can now log in.";
                header("Location: /myphpproject/index.php?page=login");
                exit();
            } else {
                $_SESSION['register_error'] = "Registration failed. Please try again.";
                header("Location: /myphpproject/index.php?page=register");
                exit();
            }
        }
    }
}