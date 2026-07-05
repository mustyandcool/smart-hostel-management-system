<?php
include("includes/db.php");

session_start();

$message = "";

// ===============================
// HANDLE FORM SUBMISSION
// ===============================
if(isset($_POST['register'])) {

    // Collect form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $faculty = trim($_POST['faculty']);
    $matric = strtoupper(trim($_POST['matric']));
    $password_raw = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

if ($password_raw !== $confirm_password) {
    $message = "password_mismatch";
}

    // Hash password
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Passport upload setup
    $passport_name = $_FILES['passport']['name'];
    $passport_tmp = $_FILES['passport']['tmp_name'];

    $upload_folder = "assets/uploads/";
    $passport_final = $upload_folder . time() . "_" . $passport_name;

    // ===============================
    // DUPLICATE EMAIL CHECK
    // ===============================
    $check_email = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");
    if(mysqli_num_rows($check_email) > 0) {
        $message = "email_exists";
    }

    // ===============================
    // DUPLICATE MATRIC CHECK
    // ===============================
    $check_matric = mysqli_query($conn, "SELECT * FROM students WHERE matric='$matric'");
    if(mysqli_num_rows($check_matric) > 0) {
        $message = "matric_exists";
    }

    // ===============================
    // CONTINUE ONLY IF VALID
    // ===============================
    if($message == "") {

        // Move uploaded file
        move_uploaded_file($passport_tmp, $passport_final);

        // INSERT INTO DATABASE
        $insert = "INSERT INTO students 
        (fullname, email, gender, faculty, matric, password, passport, status)
        VALUES 
        ('$fullname', '$email', '$gender', '$faculty', '$matric', '$password', '$passport_final', 'Pending')";

        $result = mysqli_query($conn, $insert);

        if($result) {
            $message = "success";
        } else {
            $message = "error";
        }
    }
}
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

    <div class="glass-card">

        <!-- HEADER -->
        <div class="card-header">
            <div class="logo-icon">🏫</div>
            <div class="title">Student Registration</div>
            <div class="small-text">Create your hostel account</div>
        </div>

        <!-- BODY -->
        <div class="card-body">

            <!-- Passport Preview -->
            <img id="preview" class="preview" src="#" alt="Passport Preview">

            <!-- FORM START -->
            <form action="" method="POST" enctype="multipart/form-data">

                <!-- FULL NAME -->
                <input type="text" name="fullname" class="form-control"
                       placeholder="Full Name" required>

                <!-- EMAIL -->
                <input type="email" name="email" class="form-control"
                       placeholder="Email Address" required>

                <!-- MATRIC NUMBER -->
                <input type="text" name="matric" id="matric"
                       class="form-control"
                       placeholder="Matric Number (AUTO-UPPERCASE)" required>

                <!-- GENDER -->
                <select name="gender" class="form-select" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <!-- FACULTY -->
                <input type="text" name="faculty" class="form-control"
                       placeholder="Faculty" required>
                                       <!-- DEPARTMENT -->
                <select name="department" class="form-select" required>
                    <option value="">Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Cyber Security">Cyber Security</option>
                </select>

                <!-- PASSWORD -->
                <input type="password" name="password" id="password"
                       class="form-control"
                       placeholder="Password" required>

                <!-- CONFIRM PASSWORD -->
                <input type="password" name="confirm_password"
                       class="form-control"
                       placeholder="Confirm Password" required>

                <!-- PASSPORT UPLOAD -->
                <label class="small-text">Upload Passport Photo</label>
                <input type="file" name="passport" id="passport"
                       class="form-control" accept="image/*" required>

                <!-- SUBMIT BUTTON -->
                <button type="submit" name="register" class="btn-primary">
                    Create Account
                </button>

                <!-- LOADING SPINNER -->
                <div class="spinner" id="spinner">
                    <p class="small-text">Processing registration...</p>
                </div>

            </form>
            <!-- FORM END -->

        </div>
        <!-- CARD BODY END -->

    </div>
    <!-- GLASS CARD END -->

</div>
<!-- OVERLAY END -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ===============================
// AUTO-UPPERCASE MATRIC NUMBER
// ===============================
document.getElementById("matric").addEventListener("input", function () {
    this.value = this.value.toUpperCase();
});


// ===============================
// PASSPORT PREVIEW
// ===============================
document.getElementById("passport").addEventListener("change", function (event) {
    let reader = new FileReader();
    reader.onload = function () {
        let preview = document.getElementById("preview");
        preview.src = reader.result;
        preview.style.display = "block";
    }
    reader.readAsDataURL(event.target.files[0]);
});


// ===============================
// PASSWORD STRENGTH METER
// ===============================
const password = document.getElementById("password");

password.addEventListener("input", function () {
    let value = password.value;
    let strength = 0;

    if (value.length >= 6) strength++;
    if (value.match(/[A-Z]/)) strength++;
    if (value.match(/[0-9]/)) strength++;
    if (value.match(/[@$!%*?&#]/)) strength++;

    if (strength <= 1) {
        password.style.border = "2px solid red";
    } 
    else if (strength == 2 || strength == 3) {
        password.style.border = "2px solid orange";
    } 
    else {
        password.style.border = "2px solid green";
    }
});


// ===============================
// FORM LOADING SPINNER
// ===============================
const form = document.querySelector("form");
const spinner = document.getElementById("spinner");

form.addEventListener("submit", function () {
    spinner.style.display = "block";
});


// ===============================
// PASSWORD MATCH VALIDATION
// ===============================
form.addEventListener("submit", function (e) {
    let pass = document.getElementById("password").value;
    let confirm = document.querySelector("input[name='confirm_password']").value;

    if (pass !== confirm) {
        e.preventDefault();
        spinner.style.display = "none";

        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Passwords do not match!'
        });
    }
});
</script>
<?php if(isset($message)): ?>

<script>
document.addEventListener("DOMContentLoaded", function () {

    <?php if($message == "success"): ?>

        Swal.fire({
            icon: 'success',
            title: 'Account Created!',
            text: 'Registration successful.'
        });

    <?php elseif($message == "email_exists"): ?>

        Swal.fire({
            icon: 'error',
            title: 'Email Already Exists'
        });

    <?php elseif($message == "matric_exists"): ?>

        Swal.fire({
            icon: 'error',
            title: 'Matric Exists'
        });

    <!-- 👇 THIS IS YOUR NEW PART -->
    <?php elseif($message == "password_mismatch"): ?>

        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Please confirm your password correctly.'
        });

    <?php else: ?>

        Swal.fire({
            icon: 'error',
            title: 'Registration Failed'
        });

    <?php endif; ?>

});
</script>

<?php endif; ?>