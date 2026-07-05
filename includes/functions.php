<?php
require_once 'config.php';
// ===============================
// SMART HOSTEL MANAGEMENT SYSTEM
// Common Functions
// ===============================

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = DB_HOST;
$dbname = DB_NAME;
$username = DB_USER;
$password = DB_PASS;

try{

    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

    die("Database Connection Failed.");

}


// ===============================
// SANITIZE INPUT
// ===============================

function sanitize($data){

    return htmlspecialchars(trim($data));

}



// ===============================
// STUDENT LOGIN CHECK
// ===============================

function studentLoggedIn(){

    return isset($_SESSION['student_id']);

}



// ===============================
// ADMIN LOGIN CHECK
// ===============================

function adminLoggedIn(){

    return isset($_SESSION['admin_id']);

}



// ===============================
// REDIRECT
// ===============================

function redirect($url){

    header("Location: ".$url);

    exit();

}



// ===============================
// STUDENT AUTH
// ===============================

function requireStudent(){

    if(!studentLoggedIn()){

        redirect("../login.php");

    }

}



// ===============================
// ADMIN AUTH
// ===============================

function requireAdmin(){

    if(!adminLoggedIn()){

        redirect("../login.php");

    }

}



// ===============================
// ESCAPE OUTPUT
// ===============================

function e($string){

    return htmlspecialchars($string,ENT_QUOTES,'UTF-8');

}



// ===============================
// RANDOM HOSTEL APPLICATION CODE
// ===============================

function applicationCode(){

    return "APP".date("Ymd").rand(1000,9999);

}



// ===============================
// RANDOM ROOM CODE
// ===============================

function roomCode(){

    return "RM".rand(100,999);

}



// ===============================
// SUCCESS MESSAGE
// ===============================

function success($msg){

    return '

    <div class="alert alert-success">

    '.$msg.'

    </div>

    ';

}



// ===============================
// ERROR MESSAGE
// ===============================

function error($msg){

    return '

    <div class="alert alert-danger">

    '.$msg.'

    </div>

    ';

}

?>