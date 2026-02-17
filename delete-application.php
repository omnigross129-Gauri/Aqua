<?php
session_start();
if (
    !isset($_SESSION['admin']) &&
    !isset($_SESSION['hr'])
) {
    header("Location: admin-login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "eventdb");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // fetch resume filename
    $res = $conn->query("SELECT resume FROM job_applications WHERE id=$id");
    $row = $res->fetch_assoc();

    // delete file from "uploads"
    if (!empty($row['resume']) && file_exists("uploads/" . $row['resume'])) {
        unlink("uploads/" . $row['resume']);
    }

    // delete row from table
    $conn->query("DELETE FROM job_applications WHERE id=$id");
}

header("Location:admin-applications.php");
exit();
?>
