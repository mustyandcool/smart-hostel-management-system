<?php
require_once 'includes/functions.php';

// Check if an administrator already exists
$stmt = $conn->query("SELECT COUNT(*) FROM administrators");

if ($stmt->fetchColumn() > 0) {
    die("Administrator already exists.");
}

// Default Administrator Details
$full_name = "System Administrator";
$email = "admin@smarthostel.com";
$password = password_hash("Admin@123", PASSWORD_DEFAULT);
$role = "Super Admin";

// Insert Administrator
$stmt = $conn->prepare("
    INSERT INTO administrators (full_name, email, password, role)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $full_name,
    $email,
    $password,
    $role
]);

echo "<h2>Administrator created successfully.</h2>";
echo "<p><strong>Email:</strong> admin@smarthostel.com</p>";
echo "<p><strong>Password:</strong> Admin@123</p>";
echo "<p><strong>Delete setup_admin.php after successful setup.</strong></p>";
?>