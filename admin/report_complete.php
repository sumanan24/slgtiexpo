<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$submissions = Submission::allWithDepartment();
usort($submissions, fn($a, $b) => $a['department_id'] <=> $b['department_id']);
$pageTitle = 'Complete Impact Report';
$active = 'reports';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="d-flex justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="text-slgti-primary mb-0">SLGTI 10-Year Complete Impact Report</h2>
    <div>
        <a href="<?= url('admin/export_pdf.php?type=complete') ?>" class="btn btn-outline-danger btn-sm">PDF</a>
        <a href="<?= url('admin/export_excel.php?type=complete') ?>" class="btn btn-outline-success btn-sm">Excel</a>
    </div>
</div>
<div class="alert alert-primary">Report Period: 2016 – 2026 | Generated: <?= date('d M Y, h:i A') ?></div>
<?php if ($submissions): foreach ($submissions as $submission) require ROOT_PATH . '/includes/partials/submission_details.php';
else: ?><div class="alert alert-info">No submissions available.</div><?php endif; ?>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
