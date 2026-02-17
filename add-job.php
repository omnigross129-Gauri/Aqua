<?php
session_start();

if (!isset($_SESSION['hr'])) {
    header("Location: hr-login.php");
    exit();
}
include 'db.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $experience = $_POST['experience'];
    $description = $_POST['description'];

    mysqli_query($conn, "INSERT INTO jobs(title, location, experience, description, status, created_at)
    VALUES('$title','$location','$experience','$description','Active',NOW())");

    echo "<script>alert('✅ Job Added Successfully');window.location='manage_jobs.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Job</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, sans-serif;
}

body {
    margin: 0;
    background: #f4f6f9;
}

/* Header */
.header {
    background: #007bff;
    color: #fff;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin: 0;
    font-size: 22px;
}

.header a {
    background: #6c757d;
    padding: 8px 14px;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

/* Container */
.container {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Form */
label {
    font-weight: 600;
    margin-top: 15px;
    display: block;
}

input, textarea {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 15px;
}

input:focus, textarea:focus {
    outline: none;
    border-color: #007bff;
}

/* Buttons */
.actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn {
    padding: 12px 18px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 15px;
}

.btn-save {
    background: #28a745;
    color: #fff;
}

.btn-cancel {
    background: #dc3545;
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

/* Mobile */
@media (max-width: 600px) {
    .container {
        margin: 20px;
        padding: 20px;
    }
}
</style>
</head>

<body>

<div class="header">
    <h2>Add New Job</h2>
    <a href="manage_jobs.php">⬅ Back</a>
</div>

<div class="container">

<form method="POST">
    <label>Job Title *</label>
    <input type="text" name="title" required placeholder="e.g. Software Developer">

    <label>Location</label>
    <input type="text" name="location" placeholder="e.g. Pune">

    <label>Experience</label>
    <input type="text" name="experience" placeholder="e.g. 2–4 Years">

    <label>Job Description</label>
<textarea name="description" id="job_description" rows="6"></textarea>


    <div class="actions">
        <button type="submit" name="submit" class="btn btn-save">💾 Save Job</button>
        <a href="manage_jobs.php" class="btn btn-cancel">Cancel</a>
    </div>
</form>

</div>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#job_description'), {
        toolbar: [
            'bold',
            'italic',
            'underline',
            'numberedList',
            'bulletedList',
            'link',
            'undo',
            'redo'
        ]
    })
    .catch(error => {
        console.error(error);
    });
</script>




</body>
</html>
