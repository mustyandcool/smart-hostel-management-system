<?php
require_once 'includes/functions.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric_number = sanitize($_POST['matric_number']);
    $surname = sanitize($_POST['surname']);
    $other_names = sanitize($_POST['other_names']);
    $gender = sanitize($_POST['gender']);
    $department = sanitize($_POST['department']);
    $level = sanitize($_POST['level']);
    $phone = sanitize($_POST['phone']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check password match
    if ($password != $confirm_password) {
        $message = "<div class='alert alert-danger'>Passwords do not match.</div>";
    } else {

        // Check duplicate email
        $stmt = $conn->prepare("SELECT student_id FROM students WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {

            $message = "<div class='alert alert-danger'>Email already exists.</div>";

        } else {

            // Check duplicate matric number
            $stmt = $conn->prepare("SELECT student_id FROM students WHERE matric_number = ?");
            $stmt->execute([$matric_number]);

            if ($stmt->rowCount() > 0) {

                $message = "<div class='alert alert-danger'>Matric number already exists.</div>";

            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("
                INSERT INTO students
                (matric_number,surname,other_names,gender,department,level,phone,email,password)
                VALUES (?,?,?,?,?,?,?,?,?)
                ");

                $stmt->execute([
                    $matric_number,
                    $surname,
                    $other_names,
                    $gender,
                    $department,
                    $level,
                    $phone,
                    $email,
                    $hashedPassword
                ]);

                $message = "<div class='alert alert-success'>Registration Successful.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Student Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header text-center">

<h3>Student Registration</h3>

</div>

<div class="card-body">

<?= $message ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>Matric Number</label>
<input type="text" name="matric_number" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Surname</label>
<input type="text" name="surname" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Other Names</label>
<input type="text" name="other_names" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Gender</label>
<select name="gender" class="form-control" required>
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Department</label>
<input type="text" name="department" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Level</label>
<select name="level" class="form-control" required>
<option value="">Select Level</option>
<option>100</option>
<option>200</option>
<option>300</option>
<option>400</option>
<option>500</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Phone Number</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Email Address</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Confirm Password</label>
<input type="password" name="confirm_password" class="form-control" required>
</div>

</div>

<button class="btn btn-primary w-100">

Register

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>