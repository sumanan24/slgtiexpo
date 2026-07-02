<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/submissions.php');
verify_csrf();
$id = (int)($_POST['id'] ?? 0);
$submission = Submission::find($id);
if (!$submission) { flash('error', 'Submission not found.'); redirect('admin/submissions.php'); }
$data = collect_submission_data();
$errors = validate_submission($data, true);
if ($errors) { $_SESSION['form_errors'] = $errors; redirect('admin/submission_edit.php?id=' . $id); }
try {
    $doc = handle_upload($_FILES['supporting_documents'] ?? null, $submission['supporting_documents'] ?? null);
    Submission::update($id, $data, $doc);
    flash('success', 'Submission updated successfully.');
    redirect('admin/submission_view.php?id=' . $id);
} catch (Throwable $e) {
    $_SESSION['form_errors'] = [$e->getMessage()];
    redirect('admin/submission_edit.php?id=' . $id);
}
