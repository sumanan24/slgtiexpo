<?php
require_once dirname(__DIR__) . '/includes/init.php';
$ref = $_GET['ref'] ?? '';
$submission = Submission::findByReference($ref);
if (!$submission) {
    flash('error', 'Submission not found.');
    redirect('index.php');
}
$pageTitle = 'Submission Successful';
require ROOT_PATH . '/includes/partials/header_public.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body p-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
                    <h2 class="text-slgti-primary mt-3">Submission Successful!</h2>
                    <div class="alert alert-info mt-4">
                        <h5>Your Reference Number</h5>
                        <p class="display-6 fw-bold text-slgti-primary mb-0"><?= e($submission['reference_number']) ?></p>
                    </div>
                    <p><strong>Department:</strong> <?= e($submission['department_name']) ?></p>
                    <a href="<?= url('submit/update.php?ref=' . urlencode($submission['reference_number'])) ?>" class="btn btn-slgti-primary">Edit Submission</a>
                    <a href="<?= url('index.php') ?>" class="btn btn-outline-secondary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_public.php'; ?>
