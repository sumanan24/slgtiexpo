<?php
require_once dirname(__DIR__) . '/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $ref = trim($_POST['reference_number'] ?? '');
    if ($ref === '' || !Submission::findByReference($ref)) {
        $errors = ['Invalid reference number.'];
    } else {
        redirect('submit/update.php?ref=' . urlencode($ref));
    }
}

$ref = $_GET['ref'] ?? '';
$submission = $ref ? Submission::findByReference($ref) : null;
$departments = Department::all();
$pageTitle = $submission ? 'Edit Submission' : 'Update Submission';
$errors = $errors ?? ($_SESSION['form_errors'] ?? []);
unset($_SESSION['form_errors']);
require ROOT_PATH . '/includes/partials/header_public.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-<?= $submission ? '10' : '6' ?>">
            <?php if (!$submission): ?>
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="text-slgti-primary text-center">Update Submission</h2>
                    <form method="POST" class="mt-4">
                        <?= csrf_field() ?>
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="reference_number" class="form-control form-control-lg" required placeholder="SLGTI-XXXXXXXX">
                        <button type="submit" class="btn btn-slgti-primary w-100 btn-lg mt-3">Find Submission</button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center mb-4">
                <h2 class="text-slgti-primary">Update Submission</h2>
                <p class="text-muted">Reference: <strong><?= e($submission['reference_number']) ?></strong></p>
            </div>
            <form action="<?= url('submit/update_process.php') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="reference_number" value="<?= e($submission['reference_number']) ?>">
                <?php require ROOT_PATH . '/includes/partials/submission_form.php'; ?>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-slgti-primary btn-lg px-5">Update Submission</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_public.php'; ?>
