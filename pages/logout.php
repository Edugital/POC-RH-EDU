<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include auth file which has the BASE_URL constant
require_once '../includes/auth.php';

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// Construct the URL properly avoiding concatenation issues
$loginUrl = BASE_URL . '/pages/login.php';
header('Location: ' . $loginUrl);
exit();
?> 