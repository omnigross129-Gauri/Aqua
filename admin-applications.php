<?php
session_start();

if (!isset($_SESSION['hr'])) {
    header("Location: hr-login.php");
    exit();
}

include 'db.php';

/* FETCH APPLICATIONS */
/* FETCH APPLICATIONS */
/* ================= FILTER LOGIC ================= */

$search   = $_GET['search'] ?? '';
$position = $_GET['position'] ?? '';
$date     = $_GET['date'] ?? '';

$where = " WHERE 1=1 ";

/* 🔍 Search */
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $where .= " AND (
        full_name LIKE '%$search%' OR
        email LIKE '%$search%' OR
        phone LIKE '%$search%'
    )";
}

/* 📌 Position Filter */
if (!empty($position)) {
    $position = mysqli_real_escape_string($conn, $position);
    $where .= " AND position = '$position'";
}

/* 📅 Date Filter */
if (!empty($date)) {
    $where .= " AND DATE(created_at) = '$date'";
}

/* FINAL QUERY */
$query = "
    SELECT id, full_name, email, phone, position, resume, created_at
    FROM job_applications
    $where
    ORDER BY id DESC
";

$result = mysqli_query($conn, $query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Job Applications</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    font-family: Segoe UI, sans-serif;
    background: #f4f6f9;
    margin: 0;
}

.header {
    background: #007bff;
    color: #fff;
    padding: 15px 25px;
}

.container {
    padding: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

th, td {
    padding: 14px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

th {
    background: #f8f9fa;
}

a.resume {
    color: #007bff;
    text-decoration: none;
    font-weight: 600;
}

.back {
    margin-bottom: 20px;
    display: inline-block;
    text-decoration: none;
    color: #007bff;
}

/* ================= FILTER CARD ================= */

.filter-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

/* ================= FORM LAYOUT ================= */

.filter-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: center;
}

/* ================= INPUTS ================= */

.input-group input,
.input-group select {
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    min-width: 220px;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.input-group input:focus,
.input-group select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    background: #fff;
}

/* ================= BUTTONS ================= */

.btn-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    padding: 12px 20px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.3);
}

.btn-reset {
    background: #6b7280;
    color: #fff;
    padding: 12px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-reset:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

/* ================= MOBILE ================= */

@media (max-width: 768px) {

    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }

    .input-group input,
    .input-group select {
        width: 100%;
    }

    .btn-primary,
    .btn-reset {
        width: 100%;
        text-align: center;
    }
}


/* ================= TOP BAR ================= */

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

/* Back Button */

.back-btn {
    text-decoration: none;
    color: #2563eb;
    font-weight: 600;
    font-size: 15px;
    transition: 0.3s;
}

.back-btn:hover {
    color: #1d4ed8;
}

/* Excel Button */

.btn-excel {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-excel:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(22, 163, 74, 0.3);
}

/* Mobile */

@media (max-width: 768px) {
    .top-bar {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .btn-excel {
        width: 100%;
        text-align: center;
    }
}


</style>
</head>

<body>

<div class="header">
    <h2>Job Applications</h2>
</div>

<div class="container">

<div class="top-bar">
    <a href="hr_dashboard.php" class="back-btn">
        ← Back to Dashboard
    </a>

   <a href="export_excel.php?search=<?= urlencode($search ?? '') ?>&position=<?= urlencode($position ?? '') ?>&date=<?= urlencode($date ?? '') ?>" class="btn-excel">
Download Excel
</a>

</div>


<div class="filter-card">

<form method="GET" class="filter-form">

<div class="input-group">
<input type="text" name="search"
placeholder="Search name, email, phone"
value="<?= htmlspecialchars($search ?? '') ?>">
</div>

<div class="input-group">
<select name="position">
    <option value="">All Positions</option>
    <option value="Manager">Manager</option>
    <option value="Sales Executive">Sales Executive</option>
    <option value="Web Developer">Web Developer</option>
</select>
</div>

<div class="input-group">
<input type="date" name="date"
value="<?= htmlspecialchars($date ?? '') ?>">
</div>

<button type="submit" class="btn-primary">Filter</button>

<a href="admin-applications.php" class="btn-reset">Reset</a>

</form>



</div>



<table>
<thead>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Position</th>
    <th>Resume</th>
    <th>Applied On</th>
</tr>
</thead>

<tbody>
<?php if ($result && mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['position']) ?></td>
        <td>
            <a class="resume" href="uploads/<?= htmlspecialchars($row['resume']) ?>" target="_blank">
                View Resume
            </a>
        </td>
        <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="6">No applications found.</td>
    </tr>
<?php endif; ?>
</tbody>
</table>

</div>
</body>
</html>
