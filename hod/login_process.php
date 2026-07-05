<?php
require_once dirname(__DIR__) . '/includes/init.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('hod/login.php');
verify_csrf();
if (hod_login(trim($_POST['email'] ?? ''), $_POST['password'] ?? '')) {
    flash('success', 'Welcome back!');
    redirect('hod/dashboard.php');
}
flash('error', 'Invalid email or password.');
redirect('hod/login.php');
