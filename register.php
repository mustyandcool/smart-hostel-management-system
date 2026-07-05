<?php
require_once 'includes/functions.php';

$message = "";

$faculties = [

"Faculty of Computing" => [
"Computer Science",
"Software Engineering",
"Cyber Security",
"Information Technology",
"Computer Engineering"
],

"Faculty of Science" => [
"Mathematics",
"Statistics",
"Physics",
"Chemistry",
"Biochemistry",
"Microbiology",
"Biology"
],

"Faculty of Engineering" => [
"Civil Engineering",
"Mechanical Engineering",
"Electrical and Electronics Engineering",
"Chemical Engineering",
"Petroleum Engineering"
],

"Faculty of Management Sciences" => [
"Accounting",
"Business Administration",
"Banking and Finance",
"Public Administration",
"Entrepreneurship"
],

"Faculty of Social Sciences" => [
"Economics",
"Political Science",
"Sociology",
"Mass Communication",
"Geography"
],

"Faculty of Education" => [
"Education Biology",
"Education Chemistry",
"Education Mathematics",
"Education Physics",
"Guidance and Counselling"
]

];

if(isset($_POST['register'])){

$matric_number=strtoupper(sanitize($_POST['matric_number']));
$surname=sanitize($_POST['surname']);
$other_names=sanitize($_POST['other_names']);
$gender=sanitize($_POST['gender']);
$faculty=sanitize($_POST['faculty']);
$department=sanitize($_POST['department']);
$level=sanitize($_POST['level']);
$phone=sanitize($_POST['phone']);
$email=sanitize($_POST['email']);
$password=$_POST['password'];
$confirm=$_POST['confirm_password'];

if($password!=$confirm){

$message=error("Passwords do not match.");

}else{

$emailCheck=$conn->prepare("SELECT student_id FROM students WHERE email=?");
$emailCheck->execute([$email]);

if($emailCheck->rowCount()>0){

$message=error("Email already exists.");

}else{

$matricCheck=$conn->prepare("SELECT student_id FROM students WHERE matric_number=?");
$matricCheck->execute([$matric_number]);

if($matricCheck->rowCount()>0){

$message=error("Matric Number already exists.");

}else{

$passport="default.png";

if(isset($_FILES['passport']) && $_FILES['passport']['error']==0){

$extension=strtolower(pathinfo($_FILES['passport']['name'],PATHINFO_EXTENSION));

$allowed=['jpg','jpeg','png'];

if(in_array($extension,$allowed)){

$passport=time().rand(1000,9999).".".$extension;

move_uploaded_file(

$_FILES['passport']['tmp_name'],

"assets/uploads/".$passport

);

}

}

$hashed=password_hash($password,PASSWORD_DEFAULT);

$stmt=$conn->prepare("

INSERT INTO students

(

matric_number,
surname,
other_names,
gender,
faculty,
department,
level,
phone,
email,
password,
passport

)

VALUES

(

?,?,?,?,?,?,?,?,?,?,?

)

");

$stmt->execute([

$matric_number,
$surname,
$other_names,
$gender,
$faculty,
$department,
$level,
$phone,
$email,
$hashed,
$passport

]);

$message=success("Registration successful. Please login to continue.");

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

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<link href="assets/css/style.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<div class="overlay">

<div class="container">

<div class="title">

<div class="logo-icon">

<i class="fa-solid fa-building-user"></i>

</div>

<h2>SMART HOSTEL ALLOCATION AND MANAGEMENT SYSTEM</h2>

<p>Create your student account</p>

</div>

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="glass-card">

<div class="card-header">

<h3>Student Registration</h3>

</div>

<div class="card-body">

<?= $message ?>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label>Matric Number</label>

<input
type="text"
name="matric_number"
id="matric"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Surname</label>

<input
type="text"
name="surname"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Other Names (Optional)</label>

<input
type="text"
name="other_names"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Gender</label>

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

<label>Faculty</label>

<select
name="faculty"
id="faculty"
class="form-select"
required>

<option value="">Select Faculty</option>

<?php foreach($faculties as $facultyName=>$dept){ ?>

<option value="<?= $facultyName ?>">

<?= $facultyName ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Department</label>

<select
name="department"
id="department"
class="form-select"
required>

<option value="">Select Department</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Level</label>

<select
name="level"
class="form-select"
required>

<option value="">Select Level</option>

<option>100 Level</option>
<option>200 Level</option>
<option>300 Level</option>
<option>400 Level</option>
<option>500 Level</option>
<option>600 Level</option>
<option>Postgraduate Diploma (PGD)</option>
<option>Masters (M.Sc./M.A./MBA)</option>
<option>Doctor of Philosophy (Ph.D.)</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Phone Number</label>

<input
type="tel"
name="phone"
class="form-control"
maxlength="11"
placeholder="08012345678"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email Address</label>

<input
type="email"
name="email"
class="form-control"
placeholder="example@email.com"
required>

</div>

<div class="col-md-6 mb-3">

<label>Passport Photograph</label>

<input
type="file"
name="passport"
id="passport"
class="form-control"
accept=".jpg,.jpeg,.png">

</div>

<div class="col-12 text-center mb-3">

<img
id="preview"
class="preview"
src="#"
alt="Passport Preview">

</div>

<div class="col-md-6 mb-3">

<label>Password</label>

<div class="input-group">

<input
type="password"
name="password"
id="password"
class="form-control"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword('password',this)">

<i class="fa-solid fa-eye"></i>

</button>

</div>

<div class="progress mt-2">

<div
id="strengthBar"
class="progress-bar"
style="width:0%">

</div>

</div>

<small id="strengthText"></small>

</div>

<div class="col-md-6 mb-3">

<label>Confirm Password</label>

<div class="input-group">

<input
type="password"
name="confirm_password"
id="confirmPassword"
class="form-control"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword('confirmPassword',this)">

<i class="fa-solid fa-eye"></i>

</button>

</div>

</div>

<div class="col-12 mt-4">

<button
type="submit"
name="register"
id="submitBtn"
class="btn btn-primary w-100">

<span
id="spinner"
class="spinner-border spinner-border-sm spinner d-none">

</span>

Create Account

</button>

</div>

<div class="text-center mt-4">

Already have an account?

<a
href="login.php"
class="fw-bold text-decoration-none">

Login Here

</a>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

</div>
<script>

const departments = <?php echo json_encode($faculties); ?>;

// ==========================
// Faculty → Department
// ==========================

document.getElementById("faculty").addEventListener("change",function(){

let faculty=this.value;

let department=document.getElementById("department");

department.innerHTML='<option value="">Select Department</option>';

if(faculty!==""){

departments[faculty].forEach(function(item){

let option=document.createElement("option");

option.value=item;

option.text=item;

department.appendChild(option);

});

}

});

// ==========================
// Passport Preview
// ==========================

document.getElementById("passport").addEventListener("change",function(e){

const file=e.target.files[0];

if(!file) return;

const reader=new FileReader();

reader.onload=function(event){

const preview=document.getElementById("preview");

preview.src=event.target.result;

preview.style.display="block";

}

reader.readAsDataURL(file);

});

// ==========================
// Auto Uppercase Matric No
// ==========================

document.getElementById("matric").addEventListener("keyup",function(){

this.value=this.value.toUpperCase();

});

// ==========================
// Password Toggle
// ==========================

function togglePassword(id,button){

let input=document.getElementById(id);

let icon=button.querySelector("i");

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

// ==========================
// Phone Validation
// ==========================

document.querySelector("input[name='phone']").addEventListener("input",function(){

this.value=this.value.replace(/[^0-9]/g,'');

});


// ==========================
// Email Validation
// ==========================

document.querySelector("input[name='email']").addEventListener("blur",function(){

let email=this.value.trim();

let pattern=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if(email!="" && !pattern.test(email)){

this.classList.add("is-invalid");

}else{

this.classList.remove("is-invalid");

}

});

</script>
<script>

// ===============================
// PASSWORD STRENGTH METER
// ===============================

const password=document.getElementById("password");
const strengthBar=document.getElementById("strengthBar");
const strengthText=document.getElementById("strengthText");

password.addEventListener("keyup",function(){

let value=password.value;

let strength=0;

if(value.length>=8) strength++;

if(/[A-Z]/.test(value)) strength++;

if(/[0-9]/.test(value)) strength++;

if(/[^A-Za-z0-9]/.test(value)) strength++;

switch(strength){

case 0:

strengthBar.style.width="0%";
strengthBar.className="progress-bar";
strengthText.innerHTML="";
break;

case 1:

strengthBar.style.width="25%";
strengthBar.className="progress-bar bg-danger";
strengthText.innerHTML="Weak Password";
break;

case 2:

strengthBar.style.width="50%";
strengthBar.className="progress-bar bg-warning";
strengthText.innerHTML="Fair Password";
break;

case 3:

strengthBar.style.width="75%";
strengthBar.className="progress-bar bg-info";
strengthText.innerHTML="Good Password";
break;

case 4:

strengthBar.style.width="100%";
strengthBar.className="progress-bar bg-success";
strengthText.innerHTML="Strong Password";
break;

}

});

// ===============================
// FORM VALIDATION
// ===============================

document.querySelector("form").addEventListener("submit",function(e){

let pass=password.value;

let confirm=document.getElementById("confirmPassword").value;

if(pass.length<8){

e.preventDefault();

Swal.fire({

icon:'warning',

title:'Weak Password',

text:'Password must be at least 8 characters long.'

});

return;

}

if(pass!==confirm){

e.preventDefault();

Swal.fire({

icon:'error',

title:'Password Mismatch',

text:'Passwords do not match.'

});

return;

}

// Loading

document.getElementById("submitBtn").disabled=true;

document.getElementById("spinner").classList.remove("d-none");

});

// ===============================
// SUCCESS / ERROR ALERTS
// ===============================

<?php if(!empty($message)){ ?>

Swal.fire({

icon:"<?= strpos($message,'success')!==false?'success':'error' ?>",

title:"Notification",

html:`<?= addslashes($message) ?>`

});

<?php } ?>

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>