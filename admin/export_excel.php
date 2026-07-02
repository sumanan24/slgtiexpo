<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
load_composer();

if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
    die('Excel library not installed. Run: composer install');
}

$type = $_GET['type'] ?? 'complete';
$departmentId = (int)($_GET['department_id'] ?? 0);

if ($type === 'department' && $departmentId) {
    $submissions = Submission::byDepartment($departmentId);
    $filename = 'slgti-department-report.xlsx';
} else {
    $submissions = Submission::allWithDepartment();
    $filename = $type === 'comparative' ? 'slgti-comparative-report.xlsx' : 'slgti-complete-impact-report.xlsx';
}

$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$headers = ['Reference','Department','Staff Name','Submitted By','Email','Phone','Students','Graduates','Employment %','Income','Research','Achievements','Status','Date'];
$sheet->fromArray($headers, null, 'A1');

$row = 2;
foreach ($submissions as $s) {
    $m = submission_metrics($s);
    $sheet->fromArray([
        $s['reference_number'], $s['department_name'], $s['staff_name'], $s['submitted_by'],
        $s['email'], $s['phone'], $m['total_students'], $m['total_graduates'], $m['employment_rate'],
        $m['total_income'], $m['research_output'], $m['achievement_score'], ucfirst($s['status']),
        date('Y-m-d', strtotime($s['submission_date'])),
    ], null, 'A' . $row++);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('php://output');
exit;
