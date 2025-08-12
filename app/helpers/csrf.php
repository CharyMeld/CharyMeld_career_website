<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function generateCsrfToken() {
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function get_flash_messages() {
    $messages = [];
    if (isset($_SESSION['register_success'])) {
        $messages[] = ['type' => 'success', 'message' => $_SESSION['register_success']];
        unset($_SESSION['register_success']);
    }
    if (isset($_SESSION['register_error'])) {
        $messages[] = ['type' => 'error', 'message' => $_SESSION['register_error']];
        unset($_SESSION['register_error']);
    }
    if (isset($_SESSION['login_error'])) {
        $messages[] = ['type' => 'error', 'message' => $_SESSION['login_error']];
        unset($_SESSION['login_error']);
    }
    return $messages;
}
