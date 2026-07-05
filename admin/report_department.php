<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$id = (int)($_GET['id'] ?? 0);
$department = Department::find($id);
if (!$department) { flash('error', 'Department not found.'); redirect('admin/reports.php'); }
$submissions = Submission::byDepartment($id);
$latestSubmission = $submissions[0] ?? null;
$metrics = $latestSubmission ? submission_metrics($latestSubmission) : null;
$pageTitle = 'Department Report';
$active = 'reports';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="report-page">
    <div class="report-page-header no-print">
        <div class="report-page-intro">
            <nav class="report-breadcrumb" aria-label="breadcrumb">
                <a href="<?= url('admin/reports.php') ?>">Reports</a>
                <span class="report-breadcrumb-sep">/</span>
                <span>Department Report</span>
            </nav>
            <h2 class="report-page-title"><?= e($department['department_name']) ?></h2>
            <p class="report-page-subtitle">
                SLGTI 10-Year Impact Report &nbsp;·&nbsp; 2016 – 2026
                <?php if ($latestSubmission): ?>
                    &nbsp;·&nbsp; Reference <code><?= e($latestSubmission['reference_number']) ?></code>
                <?php endif; ?>
            </p>
        </div>
        <div class="report-toolbar">
            <?php if ($latestSubmission): ?>
            <div class="btn-group report-btn-group" role="group" aria-label="Submission actions">
                <a href="<?= url('admin/submission_view.php?id=' . (int)$latestSubmission['id']) ?>" class="btn btn-slgti-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>View
                </a>
                <a href="<?= url('admin/submission_edit.php?id=' . (int)$latestSubmission['id']) ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
            </div>
            <?php endif; ?>
            <div class="btn-group report-btn-group" role="group" aria-label="Export actions">
                <a href="<?= url('admin/export_pdf.php?type=department&department_id=' . $id) ?>" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-file-pdf me-1"></i>PDF
                </a>
                <a href="<?= url('admin/export_excel.php?type=department&department_id=' . $id) ?>" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i>Excel
                </a>
            </div>
            <a href="<?= url('admin/reports.php') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <?php if ($latestSubmission && $metrics): ?>
    <div class="report-meta-bar no-print">
        <div class="report-meta-item">
            <i class="bi bi-calendar3"></i>
            <span>Generated <?= date('d M Y, h:i A') ?></span>
        </div>
        <div class="report-meta-item">
            <i class="bi bi-file-earmark-check"></i>
            <span><?= count($submissions) ?> submission<?= count($submissions) !== 1 ? 's' : '' ?></span>
        </div>
        <div class="report-meta-item">
            <i class="bi bi-flag"></i>
            <span class="submission-status-badge submission-status-<?= e($latestSubmission['status']) ?>">
                <?= ucfirst(e($latestSubmission['status'])) ?>
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
    <?php endif; ?>

    <div class="report-details-stack">
        <?php if ($submissions): ?>
            <?php foreach ($submissions as $submission) require ROOT_PATH . '/includes/partials/submission_details.php'; ?>
        <?php else: ?>
            <div class="report-empty-state no-print">
                <div class="report-empty-icon"><i class="bi bi-inbox"></i></div>
                <h5>No Submissions Yet</h5>
                <p class="text-muted mb-0">This department has not submitted impact data yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
