<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'SLGTI 10-Year Impact Report';
require ROOT_PATH . '/includes/partials/header_public.php';
?>
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">SLGTI 10-Year Impact Report</h1>
        <p class="lead mb-4">Data Collection System for Department Heads of Study</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?= url('submit/index.php') ?>" class="btn btn-slgti-secondary btn-lg"><i class="bi bi-plus-circle me-2"></i>Submit Department Data</a>
            <a href="<?= url('submit/update.php') ?>" class="btn btn-outline-light btn-lg"><i class="bi bi-pencil-square me-2"></i>Update Existing Submission</a>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <h2 class="text-center text-slgti-primary mb-5">Participating Departments</h2>
        <div class="row g-4">
            <?php
            $depts = [
                ['bi-laptop', 'Information & Communication Technology (ICT)'],
                ['bi-car-front', 'Automotive Technology'],
                ['bi-lightning-charge', 'Electrical & Electronic Technology'],
                ['bi-gear-wide-connected', 'Mechanical Technology'],
                ['bi-building', 'Construction Technology'],
                ['bi-cup-hot', 'Food Technology'],
            ];
            foreach ($depts as [$icon, $name]): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 report-card">
                    <div class="card-body text-center p-4">
                        <i class="bi <?= $icon ?> text-slgti-primary" style="font-size:2.5rem;"></i>
                        <h5 class="card-title mt-3"><?= e($name) ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require ROOT_PATH . '/includes/partials/footer_public.php'; ?>
