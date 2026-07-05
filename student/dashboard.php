<?php
session_start();

if(!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h2 class="brand">🏫 HostelSys</h2>

        <ul>
            <li><a href="#">🏠 Dashboard</a></li>
            <li><a href="#">👤 Profile</a></li>
            <li><a href="#">🏨 Apply Hostel</a></li>
            <li><a href="#">📦 My Allocation</a></li>
            <li><a href="#">🔔 Notifications</a></li>
            <li><a href="../logout.php">🚪 Logout</a></li>
        </ul>

    </div>

    <!-- MAIN AREA -->
    <div class="main">

        <!-- TOP BAR -->
        <div class="topbar">
            <h3>Welcome, <?php echo $_SESSION['student_name']; ?> 👋</h3>
        </div>

        <!-- CARDS SECTION -->
        <div class="cards">

            <div class="card">
                <h3>Profile</h3>
                <p>View your personal details</p>
            </div>

            <div class="card">
                <h3>Hostel Status</h3>
                <p>Pending Allocation</p>
            </div>

            <div class="card">
                <h3>Notifications</h3>
                <p>No new messages</p>
            </div>

        </div>

    </div>

</div>

</body>
</html>