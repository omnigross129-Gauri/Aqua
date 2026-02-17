<?php
$conn = new mysqli("localhost", "root", "", "eventdb");
if ($conn->connect_error) {
    die("Connection failed");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: careers.php");
    exit;
}

/* -------- Sanitize Inputs -------- */
$full_name = trim($_POST['full_name']);
$email     = trim($_POST['email']);
$phone     = trim($_POST['phone']);
$position  = trim($_POST['position']);
$message   = trim($_POST['message']);

/* -------- Resume Upload -------- */
$maxSize = 2 * 1024 * 1024; // 2MB
$allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
$resumeFile = "";

if (!empty($_FILES['resume']['name'])) {

    if ($_FILES['resume']['size'] > $maxSize) {
        die("Resume must be less than 2MB");
    }

    if (!in_array($_FILES['resume']['type'], $allowedTypes)) {
        die("Only PDF, JPG, PNG allowed");
    }

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    $resumeFile = time() . "_" . basename($_FILES['resume']['name']);
    move_uploaded_file($_FILES['resume']['tmp_name'], "uploads/" . $resumeFile);
}

/* -------- Insert Data (SAFE) -------- */
$stmt = $conn->prepare("
    INSERT INTO job_applications 
    (full_name, email, phone, position, message, resume, created_at)
    VALUES (?, ?, ?, ?, ?, ?, NOW())
");

$stmt->bind_param(
    "ssssss",
    $full_name,
    $email,
    $phone,
    $position,
    $message,
    $resumeFile
);

$stmt->execute();

$stmt->close();
$conn->close();

/* -------- Redirect to Thank You -------- */
header("Location: job_thankyou.php");
exit;
