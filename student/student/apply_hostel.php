<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

// HANDLE FORM SUBMISSION
if(isset($_POST['apply'])) {

    $student_id = $_SESSION['student_id'];
    $hostel_name = $_POST['hostel_name'];
    $room_type = $_POST['room_type'];

    $insert = mysqli_query($conn,
        "INSERT INTO applications (student_id, hostel_name, room_type)
        VALUES ('$student_id', '$hostel_name', '$room_type')"
    );

    if($insert) {
        echo "Application submitted successfully";
    } else {
        echo "Error submitting application";
    }
}
?>

<h2>Apply Hostel</h2>

<form method="POST">

    <label>Hostel</label><br>
    <select name="hostel_name" required>
        <option value="Male Hostel A">Male Hostel A</option>
        <option value="Female Hostel B">Female Hostel B</option>
    </select>
    <br><br>

    <label>Room Type</label><br>
    <select name="room_type" required>
        <option value="Single">Single</option>
        <option value="Double">Double</option>
    </select>

    <br><br>

    <button type="submit" name="apply">
        Apply Now
    </button>

</form>