<?php
require_once 'db.php';

/**
 * Sanitize user input
 */
function sanitize($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to another page
 */
function redirect($url)
{
    header("Location: $url");
    exit();
}

/**
 * Check if student is logged in
 */
function isStudentLoggedIn()
{
    return isset($_SESSION['student_id']);
}

/**
 * Check if administrator is logged in
 */
function isAdminLoggedIn()
{
    return isset($_SESSION['admin_id']);
}

/**
 * Display success message
 */
function successMessage($message)
{
    $_SESSION['success'] = $message;
}

/**
 * Display error message
 */
function errorMessage($message)
{
    $_SESSION['error'] = $message;
}

/**
 * Generate current date/time
 */
function currentDateTime()
{
    return date('Y-m-d H:i:s');
}