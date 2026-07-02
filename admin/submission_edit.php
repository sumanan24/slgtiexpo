<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
$id = (int)($_GET['id'] ?? 0);
$submission = Submission::find($id);
if (!$submission) { flash('error', 'Submission not found.'); redirect('admin/submissions.php'); }
$departments = Department::all();
$showStatus = true;
$pageTitle = 'Edit Submission';
$active = 'submissions';
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<h2 class="text-slgti-primary mb-4">Edit Submission</h2>
<form action="<?= url('admin/submission_update.php') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="id" value="<?= $id ?>">
    <?php require ROOT_PATH . '/includes/partials/submission_form.php'; ?>
    <button type="submit" class="btn btn-slgti-primary">Save Changes</button>
    <a href="<?= url('admin/submission_view.php?id=' . $id) ?>" class="btn btn-outline-secondary">Cancel</a>
</form>
<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
