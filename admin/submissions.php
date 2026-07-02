<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$page = max(1, (int)($_GET['page'] ?? 1));
$result = Submission::search([
    'search' => $_GET['search'] ?? '',
    'department_id' => $_GET['department_id'] ?? '',
    'status' => $_GET['status'] ?? '',
], $page);
$departments = Department::all();
$pageTitle = 'Submissions';
$active = 'submissions';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<h2 class="text-slgti-primary mb-4"><i class="bi bi-file-earmark-text me-2"></i>Submissions</h2>
<div class="card border-0 shadow-sm mb-4"><div class="card-body">
<form method="GET" class="row g-3">
    <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search..." value="<?= e($_GET['search'] ?? '') ?>"></div>
    <div class="col-md-3"><select name="department_id" class="form-select"><option value="">All Departments</option>
        <?php foreach ($departments as $d): ?><option value="<?= $d['id'] ?>" <?= ($_GET['department_id'] ?? '') == $d['id'] ? 'selected' : '' ?>><?= e($d['department_name']) ?></option><?php endforeach; ?>
    </select></div>
    <div class="col-md-3"><select name="status" class="form-select"><option value="">All Status</option>
        <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="completed" <?= ($_GET['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
    </select></div>
    <div class="col-md-2"><button class="btn btn-slgti-primary w-100">Filter</button></div>
</form></div></div>
<div class="card border-0 shadow-sm"><div class="table-responsive">
<table class="table table-hover table-slgti mb-0">
<thead><tr><th>Reference</th><th>Department</th><th>Submitted By</th><th>Students</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($result['items'] as $s): $m = submission_metrics($s); ?>
<tr>
    <td><code><?= e($s['reference_number']) ?></code></td>
    <td><?= e($s['department_name']) ?></td>
    <td><?= e($s['submitted_by']) ?></td>
    <td><?= $m['total_students'] ?></td>
    <td><span class="badge badge-<?= e($s['status']) ?>"><?= ucfirst(e($s['status'])) ?></span></td>
    <td><?= e(date('d M Y', strtotime($s['submission_date']))) ?></td>
    <td>
        <a href="<?= url('admin/submission_view.php?id=' . $s['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
        <a href="<?= url('admin/submission_edit.php?id=' . $s['id']) ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
    </td>
</tr>
<?php endforeach; ?>
<?php if (!$result['items']): ?><tr><td colspan="7" class="text-center py-4">No submissions found.</td></tr><?php endif; ?>
</tbody></table></div>
<?php if ($result['total_pages'] > 1): ?>
<div class="card-footer bg-white"><nav><ul class="pagination mb-0">
<?php for ($i = 1; $i <= $result['total_pages']; $i++): ?>
<li class="page-item <?= $i === $result['page'] ? 'active' : '' ?>"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a></li>
<?php endfor; ?>
</ul></nav></div>
<?php endif; ?>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
