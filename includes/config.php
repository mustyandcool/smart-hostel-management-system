<?php
// ======================================
// Database Configuration
// Smart Hostel Allocation & Management System
// ======================================

define('DB_HOST', 'sql301.infinityfree.com');
define('DB_NAME', 'if0_42340667_smart_hostel_db');
define('DB_USER', 'if0_42340667');
define('DB_PASS', 'Musty2026');

// Website URL
define('BASE_URL', 'https://smarthostel.lovestoblog.com/');

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('Africa/Lagos');
?>