<?php
require_once dirname(__DIR__) . '/includes/init.php';
$departments = Department::all();
$pageTitle = 'Submit Impact Data';
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);
require ROOT_PATH . '/includes/partials/header_public.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-4">
                <h2 class="text-slgti-primary">Department Impact Data Submission</h2>
                <p class="text-muted">Complete all sections below to submit your department's 10-year impact data.</p>
            </div>
            <form action="<?= url('submit/process.php') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <?php require ROOT_PATH . '/includes/partials/submission_form.php'; ?>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-slgti-primary btn-lg px-5"><i class="bi bi-send me-2"></i>Submit Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_public.php'; ?>
