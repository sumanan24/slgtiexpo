<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$submissions = Submission::allWithDepartment();
$pageTitle = 'Comparative Report';
$active = 'reports';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="d-flex justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="text-slgti-primary mb-0">Comparative Department Report</h2>
    <div>
        <a href="<?= url('admin/export_pdf.php?type=comparative') ?>" class="btn btn-outline-danger btn-sm">PDF</a>
        <a href="<?= url('admin/export_excel.php?type=comparative') ?>" class="btn btn-outline-success btn-sm">Excel</a>
    </div>
</div>
<div class="card border-0 shadow-sm"><div class="table-responsive">
<table class="table table-bordered mb-0">
<thead class="table-slgti"><tr><th>Department</th><th>Students</th><th>Graduates</th><th>Employment %</th><th>Income</th><th>Research</th><th>Achievements</th><th>Status</th></tr></thead>
<tbody>
<?php foreach ($submissions as $s): $m = submission_metrics($s); ?>
<tr>
    <td><?= e($s['department_name']) ?></td>
    <td><?= $m['total_students'] ?></td><td><?= $m['total_graduates'] ?></td><td><?= $m['employment_rate'] ?>%</td>
    <td><?= number_format($m['total_income'], 2) ?></td><td><?= $m['research_output'] ?></td><td><?= $m['achievement_score'] ?></td>
    <td><?= ucfirst(e($s['status'])) ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
