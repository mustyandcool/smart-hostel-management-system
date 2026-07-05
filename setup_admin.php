<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/functions.php';

$stmt = $conn->query("SELECT COUNT(*) FROM administrators");
$count = $stmt->fetchColumn();

if ($count > 0) {
    die("Administrator already exists.");
}

$full_name = "System Administrator";
$email = "admin@smarthostel.com";
$password = password_hash("Admin@123", PASSWORD_DEFAULT);
$role = "Super Admin";

$stmt = $conn->prepare("
INSERT INTO administrators(full_name,email,password,role)
VALUES(?,?,?,?)
");

$stmt->execute([
    $full_name,
    $email,
    $password,
    $role
]);

echo "Administrator created successfully.";