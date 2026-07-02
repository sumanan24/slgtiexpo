<?php
require_once dirname(__DIR__) . '/includes/init.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/login.php');
verify_csrf();
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
if (admin_login($email, $password)) {
    redirect('admin/dashboard.php');
}
flash('error', 'Invalid email or password.');
redirect('admin/login.php');
