<?php
session_start();

if (!isset($_SESSION['hr'])) {
    header("Location: hr-login.php");
    exit();
}

include 'db.php';

/* ACTIVE JOBS */
$activeResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs WHERE status='Active'");
$activeJobs = $activeResult ? mysqli_fetch_assoc($activeResult)['total'] : 0;

/* CLOSED JOBS */
$closedResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs WHERE status='Closed'");
$closedJobs = $closedResult ? mysqli_fetch_assoc($closedResult)['total'] : 0;

/* APPLICATIONS */
$appResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM job_applications");
$applications = $appResult ? mysqli_fetch_assoc($appResult)['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HR Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* ================= BASE ================= */
* {
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, sans-serif;
}

body {
    margin: 0;
    background: #f1f5f9;
    color: #1f2937;
}

/* ================= HEADER ================= */
.header {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    padding: 18px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin: 0;
    font-size: 22px;
}

.header a {
    background: rgba(255,255,255,0.2);
    padding: 8px 16px;
    color: #fff;
    text-decoration: none;
    border-radius: 999px;
    font-size: 14px;
    transition: background 0.3s;
}

.header a:hover {
    background: rgba(255,255,255,0.35);
}

/* ================= CONTAINER ================= */
.container {
    padding: 30px;
    max-width: 1200px;
    margin: auto;
}

/* ================= STATS CARDS ================= */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 24px;
}

.card {
    background: #ffffff;
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
}

.card h3 {
    margin: 0;
    font-size: 15px;
    color: #6b7280;
    font-weight: 500;
}

.card p {
    font-size: 40px;
    margin: 12px 0 0;
    font-weight: 700;
}

.active { color: #16a34a; }
.closed { color: #dc2626; }
.apps   { color: #2563eb; }

/* ================= ACTION BUTTONS ================= */
.actions {
    margin-top: 40px;
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.actions a {
    padding: 14px 22px;
    background: #2563eb;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    transition: background 0.3s, transform 0.3s;
}

.actions a:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .container {
        padding: 20px;
    }

    .card p {
        font-size: 34px;
    }

    .actions {
        flex-direction: column;
    }

    .actions a {
        width: 100%;
        text-align: center;
    }
}
</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="header">
    <h2>HR Dashboard</h2>
    <a href="hr-logout.php">Logout</a>
</div>

<!-- ================= CONTENT ================= -->
<div class="container">

    <!-- Stats Cards -->
    <div class="cards">
        <div class="card">
            <h3>Active Jobs</h3>
            <p class="active"><?= $activeJobs ?></p>
        </div>

        <div class="card">
            <h3>Closed Jobs</h3>
            <p class="closed"><?= $closedJobs ?></p>
        </div>

        <div class="card">
            <h3>Total Applications</h3>
            <p class="apps"><?= $applications ?></p>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions">
        <a href="manage_jobs.php">📋 Manage Jobs</a>
        <a href="admin-applications.php">📨 View Applications</a>
    </div>

</div>

</body>
</html>
