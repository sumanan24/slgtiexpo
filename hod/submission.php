<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_hod();

$hod = hod_user();
$dbSubmission = Submission::findByDepartment((int)$hod['department_id']);
$formInput = pull_submission_form_input();
$submission = merge_submission_with_form_input($dbSubmission, $formInput);
$department = Department::find((int)$hod['department_id']);
$departments = [$department];
$hodLocked = true;
$lockedDepartment = $department;
$pageTitle = ($dbSubmission || !empty($submission['id'])) ? 'Update My Submission' : 'Submit Impact Data';
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);

if (!$submission) {
    $submission = [
        'department_id' => $hod['department_id'],
        'staff_name' => $hod['name'],
        'submitted_by' => $hod['name'],
        'designation' => $hod['designation'],
        'email' => $hod['email'],
        'phone' => $hod['phone'],
    ];
}

require ROOT_PATH . '/includes/partials/header_hod.php';
?>
<div class="container hod-page">
    <div class="dashboard-header">
        <div>
            <h2 class="dashboard-title text-slgti-primary">
                <i class="bi bi-file-earmark-text"></i><?= e($pageTitle) ?>
            </h2>
            <p class="dashboard-subtitle">
                Department: <strong><?= e($hod['department_name']) ?></strong>
                <?php if ($submission && !empty($submission['reference_number'])): ?>
                    &nbsp;|&nbsp; Reference: <code><?= e($submission['reference_number']) ?></code>
                <?php elseif ($dbSubmission && !empty($dbSubmission['reference_number'])): ?>
                    &nbsp;|&nbsp; Reference: <code><?= e($dbSubmission['reference_number']) ?></code>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?= url('hod/dashboard.php') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    <form action="<?= url('hod/submission_process.php') ?>" method="POST" enctype="multipart/form-data" class="hod-submission-form">
        <?= csrf_field() ?>
        <?php if (!empty($submission['id'])): ?>
            <input type="hidden" name="submission_id" value="<?= (int)$submission['id'] ?>">
        <?php elseif ($dbSubmission): ?>
            <input type="hidden" name="submission_id" value="<?= (int)$dbSubmission['id'] ?>">
        <?php endif; ?>

        <div class="admin-page-card hod-submission-card">
            <div class="card-body p-4">
                <?php require ROOT_PATH . '/includes/partials/submission_form.php'; ?>
            </div>
            <div class="hod-form-actions">
                <a href="<?= url('hod/dashboard.php') ?>" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-slgti-primary btn-lg px-4">
                    <i class="bi bi-check-circle me-2"></i><?= ($dbSubmission || !empty($submission['id'])) ? 'Update My Submission' : 'Submit Data' ?>
                </button>
            </div>
        </div>
    </form>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_hod.php'; ?>
