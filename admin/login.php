<?php
require_once dirname(__DIR__) . '/includes/init.php';
if (admin_user()) redirect('admin/dashboard.php');
$pageTitle = 'Admin Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SLGTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= asset('css/slgti.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock text-slgti-primary" style="font-size:3rem;"></i>
                        <h3 class="text-slgti-primary mt-2">Admin Login</h3>
                    </div>
                    <?php require ROOT_PATH . '/includes/partials/alerts.php'; ?>
                    <form action="<?= url('admin/login_process.php') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-slgti-primary w-100 btn-lg">Login</button>
                    </form>
                    <div class="text-center mt-4"><a href="<?= url('index.php') ?>">Back to Home</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
