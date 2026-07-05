<?php
require_once dirname(__DIR__) . '/includes/init.php';
if (hod_user()) redirect('hod/dashboard.php');
$pageTitle = 'Staff Login';
require ROOT_PATH . '/includes/partials/header_hod.php';
?>
<div class="container hod-auth-page">
    <div class="row justify-content-center w-100 mx-0">
        <div class="col-md-8 col-lg-5 hod-auth-card">
            <div class="admin-page-card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-badge text-slgti-primary" style="font-size:2.5rem;"></i>
                        <h2 class="text-slgti-primary mt-2 h4">Staff Login</h2>
                    </div>
                    <form action="<?= url('hod/login_process.php') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-slgti-primary w-100 btn-lg">Login</button>
                    </form>
                    <p class="text-center mt-3 mb-0 small">
                        No account? <a href="<?= url('hod/register.php') ?>">Create Staff Account</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_hod.php'; ?>
