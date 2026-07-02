<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$id = (int)($_GET['id'] ?? 0);
$submission = Submission::find($id);
if (!$submission) { flash('error', 'Submission not found.'); redirect('admin/submissions.php'); }
$pageTitle = 'View Submission';
$active = 'submissions';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="d-flex justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="text-slgti-primary mb-0">Submission Details</h2>
    <div class="d-flex gap-2">
        <form method="POST" action="<?= url('admin/submission_status.php') ?>" class="d-flex gap-2">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= $id ?>">
            <select name="status" class="form-select form-select-sm">
                <option value="pending" <?= $submission['status']==='pending'?'selected':'' ?>>Pending</option>
                <option value="completed" <?= $submission['status']==='completed'?'selected':'' ?>>Completed</option>
            </select>
            <button class="btn btn-sm btn-slgti-secondary">Update</button>
        </form>
        <a href="<?= url('admin/submission_edit.php?id=' . $id) ?>" class="btn btn-sm btn-slgti-primary">Edit</a>
        <a href="<?= url('admin/submissions.php') ?>" class="btn btn-sm btn-outline-secondary">Back</a>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/submission_details.php'; ?>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
