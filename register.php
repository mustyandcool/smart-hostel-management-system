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

    if ($password != $confirm_password) {

        $message = '
        <div class="alert alert-danger">
        Passwords do not match.
        </div>';

    } else {

        $checkEmail = $conn->prepare("SELECT student_id FROM students WHERE email=?");
        $checkEmail->execute([$email]);

        if($checkEmail->rowCount()>0){

            $message='
            <div class="alert alert-danger">
            Email already exists.
            </div>';

        }else{

            $checkMatric=$conn->prepare("SELECT student_id FROM students WHERE matric_number=?");
            $checkMatric->execute([$matric_number]);

            if($checkMatric->rowCount()>0){

                $message='
                <div class="alert alert-danger">
                Matric Number already exists.
                </div>';

            }else{

                $hashedPassword=password_hash($password,PASSWORD_DEFAULT);

                $stmt=$conn->prepare("INSERT INTO students
                (matric_number,surname,other_names,gender,department,level,phone,email,password)
                VALUES(?,?,?,?,?,?,?,?,?)");

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

                $message='
                <div class="alert alert-success text-center">

                <h4>Registration Successful</h4>

                <p>Your account has been created successfully.</p>

                <p>Please login to continue.</p>

                <a href="login.php" class="btn btn-success">
                Login Now
                </a>

                </div>';

            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Student Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

body{

background:url("https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1600&q=80");

background-size:cover;

background-position:center;

background-repeat:no-repeat;

min-height:100vh;

}

.overlay{

background:rgba(0,0,0,.65);

min-height:100vh;

padding:40px 0;

}

.card{

border:none;

border-radius:18px;

box-shadow:0 15px 40px rgba(0,0,0,.35);

}

.card-header{

background:#0d6efd;

color:#fff;

border-radius:18px 18px 0 0 !important;

text-align:center;

padding:20px;

}

.card-header h3{

margin:0;

font-weight:bold;

}

.form-control,

.form-select{

height:48px;

}

.btn-primary{

height:48px;

font-size:18px;

font-weight:bold;

}

.logo{

font-size:55px;

color:#fff;

text-align:center;

margin-bottom:10px;

}

.title{

color:#fff;

text-align:center;

margin-bottom:30px;

font-weight:bold;

}

</style>

</head>

<body>

<div class="overlay">

<div class="container">

<div class="logo">

<i class="fa-solid fa-building-user"></i>

</div>

<h2 class="title">

SMART HOSTEL ALLOCATION AND MANAGEMENT SYSTEM

</h2>

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card">

<div class="card-header">

<h3>Student Registration</h3>

</div>

<div class="card-body p-4">

<?= $message; ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Matric Number</label>

<input
type="text"
name="matric_number"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Surname</label>

<input
type="text"
name="surname"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Other Names (Optional)</label>

<input
type="text"
name="other_names"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Gender</label>

<select
name="gender"
class="form-select"
required>

<option value="">Select Gender</option>

<option>Male</option>

<option>Female</option>

</select>

</div>
<div class="col-md-6 mb-3">

<label class="form-label">Department</label>

<input
type="text"
name="department"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Level</label>

<select
name="level"
class="form-select"
required>

<option value="">Select Level</option>

<option>100</option>
<option>200</option>
<option>300</option>
<option>400</option>
<option>500</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Email Address</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Password</label>

<div class="input-group">

<input
type="password"
id="password"
name="password"
class="form-control"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword('password',this)">

<i class="fa fa-eye"></i>

</button>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Confirm Password</label>

<div class="input-group">

<input
type="password"
id="confirm_password"
name="confirm_password"
class="form-control"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword('confirm_password',this)">

<i class="fa fa-eye"></i>

</button>

</div>

</div>

</div>

<div class="d-grid">

<button
type="submit"
class="btn btn-primary">

<i class="fa fa-user-plus"></i>

Create Account

</button>

</div>

<div class="text-center mt-4">

Already have an account?

<a
href="login.php"
class="text-decoration-none fw-bold">

Login Here

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

function togglePassword(id,button){

const input=document.getElementById(id);

const icon=button.querySelector("i");

if(input.type==="password"){

input.type="text";

icon.classList.remove("fa-eye");

icon.classList.add("fa-eye-slash");

}else{

input.type="password";

icon.classList.remove("fa-eye-slash");

icon.classList.add("fa-eye");

}

}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>