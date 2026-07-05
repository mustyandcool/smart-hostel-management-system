<?php

require_once 'includes/functions.php';

$message="";

if(isset($_POST['login'])){

$email=sanitize($_POST['email']);

$password=$_POST['password'];


// ======================
// STUDENT LOGIN
// ======================

$stmt=$conn->prepare("SELECT * FROM students WHERE email=? LIMIT 1");

$stmt->execute([$email]);

if($stmt->rowCount()>0){

$user=$stmt->fetch(PDO::FETCH_ASSOC);

if(password_verify($password,$user['password'])){

$_SESSION['student_id']=$user['student_id'];

$_SESSION['student_name']=$user['surname']." ".$user['other_names'];

$_SESSION['student_email']=$user['email'];

header("Location: student/dashboard.php");

exit();

}

}


// ======================
// ADMIN LOGIN
// ======================

$stmt=$conn->prepare("SELECT * FROM administrators WHERE email=? LIMIT 1");

$stmt->execute([$email]);

if($stmt->rowCount()>0){

$admin=$stmt->fetch(PDO::FETCH_ASSOC);

if(password_verify($password,$admin['password'])){

$_SESSION['admin_id']=$admin['admin_id'];

$_SESSION['admin_name']=$admin['full_name'];

$_SESSION['admin_role']=$admin['role'];

header("Location: admin/dashboard.php");

exit();

}

}

$message="Invalid Email or Password.";

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title>

Login

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
rel="stylesheet">

<link
href="assets/css/style.css"
rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<div class="overlay">

<div class="container">

<div class="title">

<div class="logo-icon">

<i class="fa-solid fa-building-user"></i>

</div>

<h2>

SMART HOSTEL ALLOCATION AND MANAGEMENT SYSTEM

</h2>

<p>

Student / Administrator Login

</p>

</div>

<div class="row justify-content-center">

<div class="col-md-6">

<div class="glass-card">

<div class="card-header">

<h3>

Login

</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Email Address</label>

<input

type="email"

name="email"

class="form-control"

required>

</div>

<div class="mb-3">

<label>Password</label>

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

onclick="togglePassword()">

<i class="fa-solid fa-eye"></i>

</button>

</div>

</div>
<div class="d-grid mt-4">

<button
type="submit"
name="login"
id="loginBtn"
class="btn btn-primary">

<span
id="spinner"
class="spinner-border spinner-border-sm d-none me-2">

</span>

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

</div>

<div class="text-center mt-4">

Don't have an account?

<a
href="register.php"
class="fw-bold text-decoration-none">

Create Account

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script>

function togglePassword(){

let password=document.getElementById("password");

let icon=document.querySelector(".input-group i");

if(password.type==="password"){

password.type="text";

icon.classList.remove("fa-eye");

icon.classList.add("fa-eye-slash");

}else{

password.type="password";

icon.classList.remove("fa-eye-slash");

icon.classList.add("fa-eye");

}

}

// Loading Animation

document.querySelector("form").addEventListener("submit",function(){

document.getElementById("loginBtn").disabled=true;

document.getElementById("spinner").classList.remove("d-none");

});

<?php if(!empty($message)){ ?>

Swal.fire({

icon:"error",

title:"Login Failed",

text:"<?= addslashes($message) ?>"

});

<?php } ?>

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>