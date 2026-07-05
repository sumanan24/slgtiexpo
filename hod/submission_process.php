<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_hod();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('hod/submission.php');
}

verify_csrf();
$hod = hod_user();
$data = collect_submission_data();
$data = enforce_hod_submission_data($data);
$errors = validate_submission($data);

if ($errors) {
    $_SESSION['form_errors'] = $errors;
    store_submission_form_input($data, (int)($_POST['submission_id'] ?? 0));
    redirect('hod/submission.php');
}

$submissionId = (int)($_POST['submission_id'] ?? 0);
$existing = Submission::findByDepartment((int)$hod['department_id']);

try {
    if ($submissionId && $existing && (int)$existing['id'] === $submissionId) {
        if (!hod_owns_submission($existing)) {
            throw new RuntimeException('You can only update your department submission.');
        }
        $doc = handle_upload($_FILES['supporting_documents'] ?? null, $existing['supporting_documents'] ?? null);
        $data['status'] = $existing['status'];
        Submission::update($submissionId, $data, $doc, (int)$hod['id']);
        flash('success', 'The department submission has been updated successfully.');
    } elseif (!$existing) {
        $doc = handle_upload($_FILES['supporting_documents'] ?? null);
        $data['reference_number'] = generate_reference();
        $data['status'] = 'pending';
        Submission::create($data, $doc);
        flash('success', 'The department submission has been saved successfully.');
    } else {
        if (!hod_owns_submission($existing)) {
            throw new RuntimeException('You can only update your department submission.');
        }
        $doc = handle_upload($_FILES['supporting_documents'] ?? null, $existing['supporting_documents'] ?? null);
        $data['status'] = $existing['status'];
        Submission::update((int)$existing['id'], $data, $doc, (int)$hod['id']);
        flash('success', 'The department submission has been updated successfully.');
    }
    redirect('hod/dashboard.php');
} catch (Throwable $e) {
    $_SESSION['form_errors'] = [$e->getMessage()];
    store_submission_form_input($data, (int)($_POST['submission_id'] ?? 0));
    redirect('hod/submission.php');
}
