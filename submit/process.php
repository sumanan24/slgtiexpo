<?php
require_once dirname(__DIR__) . '/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('submit/index.php');
}

verify_csrf();
$data = collect_submission_data();
$errors = validate_submission($data);

if ($errors) {
    $_SESSION['form_errors'] = $errors;
    redirect('submit/index.php');
}

try {
    $doc = handle_upload($_FILES['supporting_documents'] ?? null);
    $data['reference_number'] = generate_reference();
    $data['status'] = 'pending';
    Submission::create($data, $doc);
    flash('success', 'Your submission has been saved successfully.');
    redirect('submit/success.php?ref=' . urlencode($data['reference_number']));
} catch (Throwable $e) {
    $_SESSION['form_errors'] = [$e->getMessage()];
    redirect('submit/index.php');
}
