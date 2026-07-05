<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Staff Portal') ?> - SLGTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= asset('css/slgti.css') ?>?v=2.2" rel="stylesheet">
</head>
<body class="hod-portal-body">
<?php $hod = hod_user(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-slgti-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url('hod/dashboard.php') ?>">SLGTI <span>Staff Portal</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hodNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="hodNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <?php if ($hod): ?>
                <li class="nav-item"><a class="nav-link" href="<?= url('hod/dashboard.php') ?>"><i class="bi bi-grid me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('hod/submission.php') ?>"><i class="bi bi-file-earmark-text me-1"></i>My Submission</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('hod/profile.php') ?>"><i class="bi bi-person me-1"></i>My Profile</a></li>
                <li class="nav-item ms-lg-2">
                    <span class="nav-link py-1"><small><?= e($hod['department_name']) ?></small></span>
                </li>
                <li class="nav-item">
                    <a href="<?= url('hod/logout.php') ?>" class="btn btn-sm btn-outline-light ms-lg-2">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="<?= url('hod/login.php') ?>">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('hod/register.php') ?>">Create Account</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('index.php') ?>">Home</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="hod-portal-main">
<?php require ROOT_PATH . '/includes/partials/alerts.php'; ?>
