<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}

require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$conn = new mysqli("localhost", "root", "", "eventdb");

// Fetch job applications
$result = $conn->query("SELECT * FROM job_applications ORDER BY id DESC");

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header row
$sheet->fromArray(
    ["ID", "Name", "Email", "Phone", "Position", "Message", "Resume", "Date"],
    NULL,
    'A1'
);

// Fill data
$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray([
        $row['id'],
        $row['full_name'],
        $row['email'],
        $row['phone'],
        $row['position'],
        $row['message'],
        $row['resume'], // Resume link or file path
        $row['created_at'],
    ], NULL, "A{$rowNum}");

    $rowNum++;
}

// Prepare download
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=job_applications.xlsx");
header("Cache-Control: max-age=0");

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
