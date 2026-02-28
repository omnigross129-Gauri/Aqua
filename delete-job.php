<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';  // SAME as manage_jobs.php

$id = intval($_GET['id']); // security

mysqli_query($conn, "DELETE FROM jobs WHERE id=$id");

header("Location: manage_jobs.php");
exit();
?>
