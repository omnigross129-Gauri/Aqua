<?php
session_start();

if (!isset($_SESSION['hr'])) {
    header("Location: hr-login.php");
    exit();
}

include 'db.php';

/* DELETE JOB */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM jobs WHERE id = $id");
    header("Location: manage_jobs.php");
    exit();
}

/* CLOSE JOB */
if (isset($_GET['close'])) {
    $id = (int)$_GET['close'];
    mysqli_query($conn, "UPDATE jobs SET status='Closed' WHERE id=$id");
    header("Location: manage_jobs.php");
    exit();
}

/* FETCH JOBS */
$jobs = mysqli_query($conn, "SELECT * FROM jobs ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Jobs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*/* ================= RESET ================= */
* {
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, sans-serif;
}

body {
    margin: 0;
    background: #f4f6f9;
    color: #1f2937;
}

/* ================= HEADER (MOBILE FIRST) ================= */
.header {
    background: #007bff;
    color: #fff;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.header h2 {
    margin: 0;
    font-size: 18px;
}

.header a {
    align-self: flex-start;
    background: #dc3545;
    padding: 8px 14px;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

/* ================= CONTAINER ================= */
.container {
    padding: 16px;
}

/* ================= BUTTONS ================= */
.btn {
    padding: 10px 14px;
    border-radius: 8px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    display: inline-block;
    margin-bottom: 8px;
}

.btn-add { background: #28a745; }
.btn-edit { background: #007bff; }
.btn-delete { background: #dc3545; }

/* ================= TABLE (MOBILE FIRST) ================= */
.table-wrapper {
    background: #fff;
    margin-top: 16px;
    border-radius: 10px;
    overflow-x: auto; /* KEY FOR MOBILE */
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px; /* forces scroll only on table */
}

th {
    background: #007bff;
    color: #fff;
    padding: 10px;
    font-size: 13px;
    text-align: left;
}

td {
    padding: 10px;
    font-size: 13px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
}

/* Hover disabled on mobile (better UX) */
tr:hover {
    background: transparent;
}

/* ================= STATUS ================= */
.status-active {
    color: #16a34a;
    font-weight: 600;
}

.status-closed {
    color: #dc2626;
    font-weight: 600;
}

/* ================= ACTION BUTTONS ================= */
.actions-cell {
    display: flex;
    flex-direction: column; /* STACKED FOR MOBILE */
    gap: 6px;
}

/* ================= DESKTOP ENHANCEMENTS ================= */
@media (min-width: 768px) {

    .header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
    }

    .header h2 {
        font-size: 20px;
    }

    .container {
        padding: 24px;
    }

    table {
        min-width: 900px;
    }

    th, td {
        font-size: 14px;
        padding: 12px;
    }

    .actions-cell {
        flex-direction: row; /* INLINE ON DESKTOP */
        flex-wrap: wrap;
    }

    tr:hover {
        background: #f9f9f9;
    }
}

</style>
</head>

<body>

<div class="header">
    <h2>HR – Manage Jobs</h2>
    <a href="hr-logout.php">Logout</a>
</div>

<div class="container">

<a href="hr_dashboard.php" class="btn" style="background:#6c757d;">← Back</a>
<a href="add-job.php" class="btn btn-add">➕ Add Job</a>

<div class="table-wrapper">
<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Location</th>
    <th>Experience</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($jobs) > 0): ?>
<?php while ($row = mysqli_fetch_assoc($jobs)): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['title']) ?></td>
    <td><?= htmlspecialchars($row['location']) ?></td>
    <td><?= htmlspecialchars($row['experience']) ?></td>
    <td class="<?= $row['status'] == 'Active' ? 'status-active' : 'status-closed' ?>">
        <?= $row['status'] ?>
    </td>
    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
    <td>
        <div class="actions-cell">
            <a href="edit-job.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="?delete=<?= $row['id'] ?>"
               onclick="return confirm('Delete this job?')"
               class="btn btn-delete">Delete</a>

            <?php if ($row['status'] == 'Active'): ?>
            <a href="?close=<?= $row['id'] ?>"
               onclick="return confirm('Close applications for this job?')"
               class="btn"
               style="background:#ffc107;color:#000;">
               Close
            </a>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="7" style="text-align:center;padding:20px;">
        No jobs available
    </td>
</tr>
<?php endif; ?>
</table>
</div>

</div>

</body>
</html>
