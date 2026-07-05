<?php
include("includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

<div class="overlay">

    <div class="container">

        <div class="glass-card" style="max-width:600px;margin:auto;">

            <div class="card-header">
                <div class="logo-icon">🏫</div>
                <h2 class="title">Student Registration</h2>
            </div>

            <div class="card-body">

                <form action="register.php" method="POST" enctype="multipart/form-data">

                    <!-- Full Name -->
                    <input type="text" name="fullname" class="form-control" placeholder="Full Name" required><br>

                    <!-- Email -->
                    <input type="email" name="email" class="form-control" placeholder="Email" required><br>

                    <!-- Gender -->
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select><br>

                    <!-- Faculty -->
                    <input type="text" name="faculty" class="form-control" placeholder="Faculty" required><br>

                    <!-- Password -->
                    <input type="password" name="password" class="form-control" placeholder="Password" required><br>

                    <!-- Passport Upload -->
                    <label style="color:#fff;">Upload Passport</label>
                    <input type="file" name="passport" class="form-control" accept="image/*" required><br>

                    <button type="submit" name="register" class="btn btn-primary">
                        Register
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>

<?php
if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Passport upload
    $passport = $_FILES['passport']['name'];
    $tmp = $_FILES['passport']['tmp_name'];

    $uploadDir = "assets/uploads/";
    $filePath = $uploadDir . time() . "_" . $passport;

    move_uploaded_file($tmp, $filePath);

    // Insert into database
    $query = "INSERT INTO students 
    (fullname, email, gender, faculty, password, passport, status)
    VALUES 
    ('$fullname', '$email', '$gender', '$faculty', '$password', '$filePath', 'Pending')";

    if(mysqli_query($conn, $query)){

        echo "<script>
        Swal.fire('Success', 'Registration Successful!', 'success');
        </script>";

    } else {

        echo "<script>
        Swal.fire('Error', 'Something went wrong!', 'error');
        </script>";

    }
}
?>