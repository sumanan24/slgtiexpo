<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$id = (int)($_GET['id'] ?? 0);
$submission = Submission::find($id);
if (!$submission) { flash('error', 'Submission not found.'); redirect('admin/submissions.php'); }
$metrics = submission_metrics($submission);
$pageTitle = 'View Submission';
$active = 'submissions';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="report-page submission-view-page">
    <div class="report-page-header no-print">
        <div class="report-page-intro">
            <nav class="report-breadcrumb" aria-label="breadcrumb">
                <a href="<?= url('admin/submissions.php') ?>">Submissions</a>
                <span class="report-breadcrumb-sep">/</span>
                <span>View Submission</span>
            </nav>
            <h2 class="report-page-title"><?= e($submission['department_name']) ?></h2>
            <p class="report-page-subtitle">
                Reference <code><?= e($submission['reference_number']) ?></code>
                &nbsp;·&nbsp; Staff: <?= e($submission['staff_name']) ?>
                &nbsp;·&nbsp; <?= e(date('d M Y', strtotime($submission['submission_date']))) ?>
            </p>
        </div>
        <div class="report-toolbar">
            <form method="POST" action="<?= url('admin/submission_status.php') ?>" class="report-status-form">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $id ?>">
                <label class="report-status-label" for="submission-status">Status</label>
                <select name="status" id="submission-status" class="form-select form-select-sm">
                    <option value="pending" <?= $submission['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="completed" <?= $submission['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit" class="btn btn-sm btn-slgti-secondary">
                    <i class="bi bi-check2 me-1"></i>Update
                </button>
            </form>
            <div class="btn-group report-btn-group" role="group" aria-label="Submission actions">
                <a href="<?= url('admin/submission_edit.php?id=' . $id) ?>" class="btn btn-slgti-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="<?= url('admin/report_department.php?id=' . (int)$submission['department_id']) ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-bar-chart me-1"></i>Dept Report
                </a>
            </div>
            <a href="<?= url('admin/submissions.php') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <div class="report-meta-bar no-print">
        <div class="report-meta-item">
            <i class="bi bi-person"></i>
            <span>Submitted by <?= e($submission['submitted_by']) ?></span>
        </div>
        <div class="report-meta-item">
            <i class="bi bi-envelope"></i>
            <span><?= e($submission['email']) ?></span>
        </div>
        <div class="report-meta-item">
            <i class="bi bi-telephone"></i>
            <span><?= e($submission['phone']) ?></span>
        </div>
        <div class="report-meta-item">
            <i class="bi bi-flag"></i>
            <span class="submission-status-badge submission-status-<?= e($submission['status']) ?>">
                <?= ucfirst(e($submission['status'])) ?>
            </span>
        </div>
    </div>

    <div class="dashboard-stats report-summary-stats no-print">
        <div class="stat-card">
            <div class="stat-card-icon primary"><i class="bi bi-people"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Students</div>
                <div class="stat-card-value"><?= number_format($metrics['total_students']) ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success"><i class="bi bi-mortarboard"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Graduates</div>
                <div class="stat-card-value"><?= number_format($metrics['total_graduates']) ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon info"><i class="bi bi-briefcase"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Employment Rate</div>
                <div class="stat-card-value"><?= number_format($metrics['employment_rate'], 1) ?>%</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon warning"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Income</div>
                <div class="stat-card-value report-stat-income">LKR <?= number_format($metrics['total_income'], 0) ?></div>
            </div>
        </div>
    </div>

    <div class="report-details-stack">
        <?php require ROOT_PATH . '/includes/partials/submission_details.php'; ?>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
