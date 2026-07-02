<?php
require_once dirname(__DIR__) . '/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('submit/update.php');
}

verify_csrf();
$ref = trim($_POST['reference_number'] ?? '');
$submission = Submission::findByReference($ref);

if (!$submission) {
    flash('error', 'Submission not found.');
    redirect('submit/update.php');
}

$data = collect_submission_data();
$errors = validate_submission($data);

if ($errors) {
    $_SESSION['form_errors'] = $errors;
    redirect('submit/update.php?ref=' . urlencode($ref));
}

try {
    $doc = handle_upload($_FILES['supporting_documents'] ?? null, $submission['supporting_documents'] ?? null);
    Submission::update((int)$submission['id'], $data, $doc);
    flash('success', 'Your submission has been updated successfully.');
    redirect('submit/success.php?ref=' . urlencode($ref));
} catch (Throwable $e) {
    $_SESSION['form_errors'] = [$e->getMessage()];
    redirect('submit/update.php?ref=' . urlencode($ref));
}
