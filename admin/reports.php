<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$departments = Department::withSubmissionCounts();
$pageTitle = 'Reports';
$active = 'reports';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<h2 class="text-slgti-primary mb-4"><i class="bi bi-bar-chart-line me-2"></i>Reports</h2>
<div class="row g-4 mb-4">
    <div class="col-md-4"><div class="card report-card h-100"><div class="card-body text-center p-4">
        <h5>Comparative Report</h5><a href="<?= url('admin/report_comparative.php') ?>" class="btn btn-slgti-primary btn-sm">View</a>
    </div></div></div>
    <div class="col-md-4"><div class="card report-card h-100"><div class="card-body text-center p-4">
        <h5>Complete Impact Report</h5><a href="<?= url('admin/report_complete.php') ?>" class="btn btn-slgti-primary btn-sm">View</a>
    </div></div></div>
    <div class="col-md-4"><div class="card report-card h-100"><div class="card-body text-center p-4">
        <h5>Export All</h5>
        <a href="<?= url('admin/export_pdf.php?type=complete') ?>" class="btn btn-outline-danger btn-sm">PDF</a>
        <a href="<?= url('admin/export_excel.php?type=complete') ?>" class="btn btn-outline-success btn-sm">Excel</a>
    </div></div></div>
</div>
<h5 class="text-slgti-primary mb-3">Individual Department Reports</h5>
<div class="row g-3">
<?php foreach ($departments as $d): ?>
<div class="col-md-6 col-lg-4"><div class="card border-0 shadow-sm"><div class="card-body">
    <h6><?= e($d['department_name']) ?></h6>
    <p class="small text-muted">Staff Name: <?= e($d['staff_name']) ?></p>
    <a href="<?= url('admin/report_department.php?id=' . $d['id']) ?>" class="btn btn-sm btn-slgti-primary">View</a>
    <a href="<?= url('admin/export_pdf.php?type=department&department_id=' . $d['id']) ?>" class="btn btn-sm btn-outline-danger">PDF</a>
    <a href="<?= url('admin/export_excel.php?type=department&department_id=' . $d['id']) ?>" class="btn btn-sm btn-outline-success">Excel</a>
</div></div></div>
<?php endforeach; ?>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
