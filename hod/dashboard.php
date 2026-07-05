<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_hod();

$hod = hod_user();
$submission = Submission::findByDepartment((int)$hod['department_id']);
$pageTitle = 'Staff Dashboard';
require ROOT_PATH . '/includes/partials/header_hod.php';
?>
<div class="container">
    <div class="dashboard-header">
        <h2 class="text-slgti-primary"><i class="bi bi-grid me-2"></i>My Dashboard</h2>
        <div class="dashboard-welcome">Department: <strong><?= e($hod['department_name']) ?></strong></div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon primary"><i class="bi bi-building"></i></div>
                <div class="stat-card-body">
                    <div class="stat-card-label">Department</div>
                    <p class="mb-0 fw-semibold text-slgti-primary" style="font-size:0.95rem;"><?= e($hod['department_name']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon info"><i class="bi bi-person"></i></div>
                <div class="stat-card-body">
                    <div class="stat-card-label">Staff Name</div>
                    <p class="mb-0 fw-semibold"><?= e($hod['name']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon <?= $submission ? 'success' : 'warning' ?>">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
                <div class="stat-card-body">
                    <div class="stat-card-label">Submission Status</div>
                    <p class="mb-0 fw-semibold"><?= $submission ? ucfirst(e($submission['status'])) : 'Not Submitted' ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-page-card mt-4">
        <div class="card-body">
            <?php if ($submission): ?>
                <h5 class="text-slgti-primary">Department Submission</h5>
                <p class="text-muted">Reference: <code><?= e($submission['reference_number']) ?></code></p>
                <p>Last updated: <?= e(date('d M Y, h:i A', strtotime($submission['updated_at'] ?? $submission['submission_date']))) ?></p>
                <a href="<?= url('hod/submission.php') ?>" class="btn btn-slgti-primary">
                    <i class="bi bi-pencil me-1"></i>Update My Submission
                </a>
            <?php else: ?>
                <h5 class="text-slgti-primary">No Submission Yet</h5>
                <p class="text-muted">Submit your department's 10-year impact data. You can update it anytime after submission.</p>
                <a href="<?= url('hod/submission.php') ?>" class="btn btn-slgti-primary">
                    <i class="bi bi-plus-circle me-1"></i>Submit Impact Data
                </a>
            <?php endif; ?>
            <a href="<?= url('hod/profile.php') ?>" class="btn btn-outline-secondary ms-2">
                <i class="bi bi-person me-1"></i>Edit Profile
            </a>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_hod.php'; ?>
