<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
load_composer();

if (!class_exists(\Dompdf\Dompdf::class)) {
    die('PDF library not installed. Run: composer install');
}

$type = $_GET['type'] ?? 'complete';
$departmentId = (int)($_GET['department_id'] ?? 0);

ob_start();
if ($type === 'department' && $departmentId) {
    $department = Department::find($departmentId);
    $submissions = Submission::byDepartment($departmentId);
    $title = 'Department Report';
    include ROOT_PATH . '/includes/exports/pdf_template.php';
    $filename = 'slgti-department-report.pdf';
} elseif ($type === 'comparative') {
    $submissions = Submission::allWithDepartment();
    $title = 'Comparative Report';
    $comparative = true;
    include ROOT_PATH . '/includes/exports/pdf_template.php';
    $filename = 'slgti-comparative-report.pdf';
} else {
    $submissions = Submission::allWithDepartment();
    $title = 'Complete Impact Report';
    include ROOT_PATH . '/includes/exports/pdf_template.php';
    $filename = 'slgti-complete-impact-report.pdf';
}
$html = ob_get_clean();

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($filename, ['Attachment' => true]);
exit;
