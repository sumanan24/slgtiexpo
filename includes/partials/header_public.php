<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'SLGTI 10-Year Impact Report') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= asset('css/slgti.css') ?>?v=2.8" rel="stylesheet">
</head>
<body class="public-body">
<nav class="navbar navbar-expand-lg navbar-dark bg-slgti-primary shadow-sm public-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url('index.php') ?>">SLGTI <span>Impact Report</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link active" href="<?= url('index.php') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('hod/login.php') ?>">Staff Login</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('admin/login.php') ?>">Admin Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="public-main">
<?php require ROOT_PATH . '/includes/partials/alerts.php'; ?>
