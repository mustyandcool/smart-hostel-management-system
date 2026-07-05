<?php
include("includes/db.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

<div class="overlay">

    <div class="glass-card">

        <div class="card-header">
            <div class="logo-icon">🔐</div>
            <div class="title">Student Login</div>
            <div class="small-text">Access your hostel dashboard</div>
        </div>

        <div class="card-body">

            <form method="POST">

                <input type="email" name="email" class="form-control" placeholder="Email Address" required>

                <input type="password" name="password" class="form-control" placeholder="Password" required>

                <button type="submit" name="login" class="btn-primary">
                    Login
                </button>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<?php

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM students WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])) {

            // CREATE SESSION
            $_SESSION['student_id'] = $user['id'];
            $_SESSION['student_name'] = $user['fullname'];

            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Welcome back!'
            }).then(() => {
                window.location.href = 'student/dashboard.php';
            });
            </script>";

        } else {

            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Password'
            });
            </script>";

        }

    } else {

        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'User Not Found'
        });
        </script>";

    }
}
?>