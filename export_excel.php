<?php
include 'db.php';

/* ================= FILTER SUPPORT ================= */

$search   = $_GET['search'] ?? '';
$position = $_GET['position'] ?? '';
$date     = $_GET['date'] ?? '';

$where = " WHERE 1=1 ";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $where .= " AND (
        full_name LIKE '%$search%' OR
        email LIKE '%$search%' OR
        phone LIKE '%$search%'
    )";
}

if (!empty($position)) {
    $position = mysqli_real_escape_string($conn, $position);
    $where .= " AND position = '$position'";
}

if (!empty($date)) {
    $where .= " AND DATE(created_at) = '$date'";
}

/* ================= DOWNLOAD EXCEL ================= */

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=job_applications.xls");

echo "Name\tEmail\tPhone\tPosition\tApplied On\n";

$query = "SELECT full_name, email, phone, position, created_at 
          FROM job_applications 
          $where
          ORDER BY id DESC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['full_name'] . "\t";
    echo $row['email'] . "\t";
    echo $row['phone'] . "\t";
    echo $row['position'] . "\t";
    echo date("d M Y", strtotime($row['created_at'])) . "\n";
}
exit;
?>
