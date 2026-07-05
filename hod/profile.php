<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_hod();

$hod = hod_user();
$fullHod = HodUser::find((int)$hod['id']);
$pageTitle = 'My Profile';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $errors = [];
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirmation'] ?? '';

    if ($name === '') $errors[] = 'Staff name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    $existingEmail = HodUser::findByEmail($email);
    if ($existingEmail && (int)$existingEmail['id'] !== (int)$hod['id']) {
        $errors[] = 'Email is already used by another account.';
    }
    if ($password !== '' && strlen($password) < 6) {
        $errors[] = 'New password must be at least 6 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Password confirmation does not match.';
    }

    if (!$errors) {
        HodUser::updateProfile((int)$hod['id'], [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'designation' => $designation,
            'password' => $password,
        ]);
        $_SESSION['hod']['name'] = $name;
        $_SESSION['hod']['email'] = $email;
        $_SESSION['hod']['phone'] = $phone;
        $_SESSION['hod']['designation'] = $designation;
        flash('success', 'Profile updated successfully.');
        redirect('hod/profile.php');
    }
    $_SESSION['form_errors'] = $errors;
}

$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);
require ROOT_PATH . '/includes/partials/header_hod.php';
?>
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="admin-page-card">
                <div class="card-body p-4">
                    <h2 class="text-slgti-primary h4 mb-4"><i class="bi bi-person me-2"></i>My Profile</h2>
                    <form method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" readonly value="<?= e($fullHod['department_name']) ?>">
                            <small class="text-muted">Department cannot be changed after registration.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Staff Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required value="<?= e($_POST['name'] ?? $fullHod['name']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control" value="<?= e($_POST['designation'] ?? $fullHod['designation'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? $fullHod['email']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= e($_POST['phone'] ?? $fullHod['phone'] ?? '') ?>">
                        </div>
                        <hr>
                        <p class="text-muted small">Leave password blank to keep current password.</p>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" minlength="6">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" minlength="6">
                        </div>
                        <button type="submit" class="btn btn-slgti-primary">Save Profile</button>
                        <a href="<?= url('hod/dashboard.php') ?>" class="btn btn-outline-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_hod.php'; ?>
