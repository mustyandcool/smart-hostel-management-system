<?php
require_once '../includes/functions.php';

if (isAdminLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM administrators WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {

        $admin = $stmt->fetch();

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];

            redirect('dashboard.php');

        } else {
            $error = "Invalid email or password.";
        }

    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Administrator Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header text-center">

<h3>Administrator Login</h3>

</div>

<div class="card-body">

<?php if($error): ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-primary w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>