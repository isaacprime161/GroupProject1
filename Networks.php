<?php
session_start();

if (!isset($_POST['job_title'])) {
    die("No job selected.");
}

$job_title = htmlspecialchars($_POST['job_title']);
$fullname = htmlspecialchars($_POST['fullname']);
$email = htmlspecialchars($_POST['email']);
$age = htmlspecialchars($_POST['age']);
$gender = htmlspecialchars($_POST['gender']);

// Handle CV upload
$cv_name = 'Not uploaded';
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $cv_name = basename($_FILES['cv']['name']);
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    move_uploaded_file($_FILES['cv']['tmp_name'], $upload_dir . $cv_name);
}

// Initialize Networks session
if (!isset($_SESSION['Networks'])) $_SESSION['Networks'] = [];

// Add job to Networks
$_SESSION['Networks'][] = [
    'job' => $job_title,
    'fullname' => $fullname,
    'email' => $email,
    'gender' => $gender,
    'age' => $age,
    'cv' => $cv_name
];

// Redirect to My Networks
header("Location: Networks.php");
exit();
?>
