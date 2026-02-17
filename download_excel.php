<?php
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$conn = new mysqli("localhost", "root", "", "eventdb");

// FILTER
$filter = "";
if (!empty($_GET['program'])) {
    $program = $_GET['program'];
    $filter = "WHERE program='$program'";
}

$result = $conn->query("SELECT * FROM tickets $filter ORDER BY id DESC");

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Column headers
$sheet->fromArray(
    ["ID", "Program", "Name", "Phone", "Email", "City", "Date"],
    NULL,
    'A1'
);

// Row data
$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray([
        $row['id'],
        $row['program'],
        $row['name'],
        $row['phone'],
        $row['email'],
        $row['city'],
        $row['created_at']
    ], NULL, "A{$rowIndex}");

    $rowIndex++;
}

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"tickets.xlsx\"");
header("Cache-Control: max-age=0");

// Output file
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");

exit;
?>
