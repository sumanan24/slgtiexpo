<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$id = (int)($_GET['id'] ?? 0);
$department = Department::find($id);
if (!$department) { flash('error', 'Department not found.'); redirect('admin/reports.php'); }
$submissions = Submission::byDepartment($id);
$pageTitle = 'Department Report';
$active = 'reports';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="d-flex justify-content-between mb-4 flex-wrap gap-2 no-print">
    <h2 class="text-slgti-primary mb-0"><?= e($department['department_name']) ?></h2>
    <div>
        <a href="<?= url('admin/export_pdf.php?type=department&department_id=' . $id) ?>" class="btn btn-outline-danger btn-sm">PDF</a>
        <a href="<?= url('admin/export_excel.php?type=department&department_id=' . $id) ?>" class="btn btn-outline-success btn-sm">Excel</a>
        <a href="<?= url('admin/reports.php') ?>" class="btn btn-outline-primary btn-sm">Back</a>
    </div>
</div>
<p>Staff Name: <?= e($department['staff_name']) ?></p>
<?php if ($submissions): foreach ($submissions as $submission) require ROOT_PATH . '/includes/partials/submission_details.php';
else: ?><div class="alert alert-info">No submissions for this department.</div><?php endif; ?>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
